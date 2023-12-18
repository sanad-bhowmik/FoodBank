<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Services\PushNotificationService;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Paystack;
use Razorpay\Api\Api;
use App\Enums\PaymentMethod;
use App\Models\Address;
use App\Http\Controllers\FrontendController;
use App\Http\Services\StripeService;
use App\Http\Services\PaymentService;

class CheckoutController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'Checkout';
    }

    public function index()
    {
        if (blank(session()->get('cart'))) {
            return redirect('/');
        }

        $this->data['addresses'] = Address::where('user_id', auth()->user()->id)->get();
        $this->data['lastAddress'] = '';

        $lastAddress = Order::select('address')->where('user_id', auth()->user()->id)->latest()->first();
        if (!blank($lastAddress)) {
            if (isJson($lastAddress->address)) {
                $this->data['lastAddress'] = Address::where('address', json_decode($lastAddress->address, true)['address'])->first();
            }
        }

        if (blank($this->data['lastAddress'])) {
            $this->data['lastAddress'] = Address::where('user_id', auth()->user()->id)->first();
        }
        
        $this->data['menuitems']    = session()->get('cart');
        $this->data['totalPayment'] = session()->get('cart')['totalPayAmount'];
        $this->data['restaurant']   = Restaurant::find(session('session_cart_restaurant_id'));
        return view('frontend.restaurant.checkout', $this->data);
    }

    public function store(Request $request)
    {
        $sessionRestaurantId = session('session_cart_restaurant_id');
        if (blank($sessionRestaurantId)) {
            return redirect(route('checkout.index'))->withError('The Restaurant not found');
        }

        $this->setDeliveryCharge($request);
        $restaurant = Restaurant::find($sessionRestaurantId);
        $validator = $this->validateCheckoutRequest($request, $restaurant);
        if(!session()->get('cart')['delivery_type']){
            $validation = [
                'mobile'       => 'required',
                'address'      => 'string',
                'payment_type' => 'required|numeric',
            ];
        }else {
            $validation = [
                'mobile'       => 'required',
                'payment_type' => 'required|numeric',
            ];
        }



        $validator = Validator::make($request->all(), $validation);
        $validator->after(function ($validator) use ($request, $restaurant) {
            if ($request->payment_type == PaymentMethod::WALLET) {
                if ((float) auth()->user()->balance->balance < (float) (session()->get('cart')['totalAmount'] + session()->get('delivery_charge'))) {
                    $validator->errors()->add('payment_type', 'The Credit balance does not enough for this payment.');
                }
            }
        })->validate();

        if ($validator->fails()) {
            return redirect(route('checkout.index'))->withError($validator);
        }

        if (auth()->check()) {
            session()->put('checkoutRequest', $request->all());
            $paymentType = $request->payment_type;

            if ($paymentType == PaymentMethod::STRIPE) {
                return $this->processStripePayment($restaurant);
            } elseif ($paymentType == PaymentMethod::PAYSTACK) {
                return $this->initiatePaystackPayment($request);
            } elseif ($paymentType == PaymentMethod::PAYPAL) {
                return $this->initiatePaypalPayment();
            } elseif ($paymentType == PaymentMethod::RAZORPAY) {
                return $this->processRazorpayPayment($request);
            } else {
                return $this->processDefaultPayment();
            }
        } else {
            return redirect()->route('login');
        }
    }

    protected function setDeliveryCharge($request)
    {
        $deliveryCharge = $request->total_delivery_charge;
        session()->put('delivery_charge', $deliveryCharge ?: 0);
    }

    protected function getLastAddress()
    {
        $lastAddress = Order::select('address')
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->first();

        if (!blank($lastAddress) && isJson($lastAddress->address)) {
            return Address::where('address', json_decode($lastAddress->address, true)['address'])->first();
        }

        return Address::where('user_id', auth()->user()->id)->first();
    }

    protected function validateCheckoutRequest($request, $restaurant)
    {
        $validation = [
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'payment_type' => 'required|numeric',
        ];
        if (!$request->delivery_type) {
            $validation['address'] = 'string';
        }

        $validator = Validator::make($request->all(), $validation);

        $validator->after(function ($validator) use ($request, $restaurant) {
            if (
                $request->payment_type == PaymentMethod::WALLET &&
                (float) auth()->user()->balance->balance < (float) (session()->get('cart')['totalAmount'] + session()->get('delivery_charge'))
            ) {
                $validator->errors()->add('payment_type', 'The Credit balance does not enough for this payment.');
            }
        });

        return $validator;
    }

    protected function processStripePayment($restaurant)
    {
        $stripeService = new StripeService();
        $stripeParameters = [
            'amount' => session()->get('cart')['totalAmount'] + session()->get('delivery_charge'),
            'currency' => 'USD',
            'token' => request('stripeToken'),
            'description' => 'N/A',
        ];

        $payment = $stripeService->payment($stripeParameters);

        $orderService = $this->handlePaymentResponse($payment);
        if ($orderService->status) {
            $order = Order::find($orderService->order_id);
            $this->clearSessionData();
            $this->sendOrderNotifications($order);
            return redirect(route('account.order.show', $order->id))->withSuccess('You order completed successfully.');
        } else {
            return redirect(route('checkout.index'))->withError($orderService->message);
        }
    }

    protected function initiatePaystackPayment($request)
    {
        $paymentData = $this->preparePaystackPaymentData($request);
        try {
            return Paystack::getAuthorizationUrl()->redirectNow($paymentData);
        } catch (\Exception $e) {
            return redirect(route('checkout.index'))->withError("The paystack token has expired. Please refresh the page and try again.");
        }
    }

    protected function preparePaystackPaymentData($request)
    {
        return [
            'currency'  => "ZAR",
            'amount'    => (session()->get('cart')['totalAmount'] + session()->get('delivery_charge')) * 100,
            'email'     => auth()->user()->email,
            'metadata'  => json_encode(['key_name' => 'value']),
            'reference' => Paystack::genTranxRef(),
            '_token'    => csrf_token(),
        ];
    }

    protected function initiatePaypalPayment()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $this->createPaypalOrder($provider);

        if (isset($response['id']) && $response['id'] != null) {
            return $this->redirectPaypalApproval($response['links']);
        } else {
            return redirect(route('checkout.index'))->withError('You have canceled the transaction.');
        }
    }

    protected function createPaypalOrder($provider)
    {
        return $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('successTransaction'),
                'cancel_url' => route('cancelTransaction'),
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => setting('currency_name'),
                        'value' => session()->get('cart')['totalAmount'] + session()->get('delivery_charge'),
                    ],
                ],
            ],
        ]);
    }

    protected function redirectPaypalApproval($links)
    {
        foreach ($links as $link) {
            if ($link['rel'] == 'approve') {
                return redirect()->away($link['href']);
            }
        }

        return redirect(route('checkout.index'))->withError('You have canceled the transaction.');
    }

    protected function processRazorpayPayment($request)
    {
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $this->fetchRazorpayPayment($api, $input);

        if (count($input) && !empty($input['razorpay_payment_id'])) {
            $response = $this->captureRazorpayPayment($api, $input, $payment);

            $orderService = app(PaymentService::class)->payment($response['status'] === 'captured');
            return $this->handleOrderServiceResponse($orderService);
        } else {
            return redirect(route('checkout.index'))->withError('You have canceled the transaction.');
        }
    }

    protected function fetchRazorpayPayment($api, $input)
    {
        return $api->payment->fetch($input['razorpay_payment_id']);
    }

    protected function captureRazorpayPayment($api, $input, $payment)
    {
        return $api->payment->fetch($input['razorpay_payment_id'])->capture(['amount' => $payment['amount']]);
    }

    protected function processDefaultPayment()
    {
        $orderService = app(PaymentService::class)->payment(false);
        return $this->handleOrderServiceResponse($orderService);
    }

    protected function handleOrderServiceResponse($orderService)
    {
        if ($orderService->status) {
            $order = Order::find($orderService->order_id);
            $this->clearSessionData();
            $this->sendOrderNotifications($order);
            return redirect(route('account.order.show', $order->id))->withSuccess('You order completed successfully.');
        } else {
            return redirect(route('checkout.index'))->withError($orderService->message);
        }
    }

    protected function clearSessionData()
    {
        session()->put('cart', null);
        session()->put('checkoutRequest', null);
        session()->put('session_cart_restaurant_id', 0);
        session()->put('session_cart_restaurant', null);
    }

    protected function sendOrderNotifications($order)
    {
        try {
            app(PushNotificationService::class)->sendNotificationOrder($order, $order->restaurant->user, 'restaurant');
            app(PushNotificationService::class)->sendNotificationOrder($order, auth()->user(), 'customer');
        } catch (\Exception $exception) {
            //
        }
    }

    protected function handlePaymentResponse($payment)
    {
        if (is_object($payment) && $payment->isSuccessful()) {
            $orderService = app(PaymentService::class)->payment(true);
        } else {
            $orderService = app(PaymentService::class)->payment(false);
        }
        return $orderService;
    }

    public function PaystackCallback()
    {
        $payment = Paystack::getPaymentData();

        if ($payment['status'] && $payment['data']['status'] === 'success') {
            $orderService = app(PaymentService::class)->payment(true);
        } else {
            $orderService = app(PaymentService::class)->payment(false);
        }

        return $this->handleOrderServiceResponse($orderService);
    }

    public function paypalSuccessTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $orderService = app(PaymentService::class)->payment(true);
        } else {
            $orderService = app(PaymentService::class)->payment(false);
        }

        return $this->handleOrderServiceResponse($orderService);
    }

    public function paypalCancelTransaction(Request $request)
    {
        return redirect(route('checkout.index'))->withError('You have canceled the transaction.');
    }
}
