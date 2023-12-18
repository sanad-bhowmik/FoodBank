@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('payment-setting') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="paymentheader text-center">{{ __('setting.payment_type') }}</h4>
                        <hr>
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ ((old('settingtypepayment', setting('settingtypepayment')) == 'stripe') || (old('settingtypepayment', setting('settingtypepayment')) == '')) ? 'active' : '' }}"
                                    id="stripe" data-toggle="pill" href="#stripetab" role="tab" aria-controls="stripetab"
                                    aria-selected="true">{{ __('setting.stripe') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (old('settingtypepayment', setting('settingtypepayment')) == 'razorpay') ? 'active' : '' }}" id="razorpay" data-toggle="pill" href="#razorpaytab" role="tab" aria-controls="razorpaytab" aria-selected="false">{{ __('setting.razorpay') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (old('settingtypepayment', setting('settingtypepayment')) == 'paystack') ? 'active' : '' }}" id="paystack" data-toggle="pill" href="#paystacktab" role="tab" aria-controls="paystacktab" aria-selected="false">{{ __('setting.paystack') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (old('settingtypepayment', setting('settingtypepayment')) == 'paypal') ? 'active' : '' }}" id="paypal" data-toggle="pill" href="#paypaltab" role="tab" aria-controls="paypaltab" aria-selected="false">{{ __('setting.paypal') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade {{ ((old('settingtypepayment', setting('settingtypepayment')) == 'stripe') || (old('settingtypepayment', setting('settingtypepayment')) == '')) ? 'show active' : '' }}"
                                id="stripetab" role="tabpanel" aria-labelledby="stripe">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.stripe_setting') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="stripe">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="stripe_key">{{ __('levels.stripe_key') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="stripe_key" id="stripe_key" type="text"
                                                        class="form-control @error('stripe_key') is-invalid @enderror"
                                                        value="{{ old('stripe_key', setting('stripe_key') ?? '') }}">
                                                    @error('stripe_key')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="stripe_secret">{{ __('levels.stripe_secret') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="stripe_secret" id="stripe_secret" type="text"
                                                        class="form-control @error('stripe_secret') is-invalid @enderror"
                                                        value="{{ old('stripe_secret', setting('stripe_secret') ?? '') }}">
                                                    @error('stripe_secret')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_stripe_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade {{ (old('settingtypepayment', setting('settingtypepayment')) == 'razorpay') ? 'show active' : '' }}"
                                id="razorpaytab" role="tabpanel" aria-labelledby="razorpay">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.razorpay_setting') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="razorpay">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="razorpay_key">{{ __('levels.razorpay_key') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="razorpay_key" id="razorpay_key" type="text"
                                                        class="form-control @error('razorpay_key')is-invalid @enderror"
                                                        value="{{ old('razorpay_key', setting('razorpay_key') ?? '') }}">
                                                    @error('razorpay_key')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="razorpay_secret">{{ __('levels.razorpay_secret') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="razorpay_secret" id="razorpay_secret" type="text"
                                                        class="form-control @error('razorpay_secret') is-invalid @enderror"
                                                        value="{{ old('razorpay_secret', setting('razorpay_secret') ?? '') }}">
                                                    @error('razorpay_secret')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_razorpay_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade {{ (old('settingtypepayment', setting('settingtypepayment')) == 'paystack') ? 'show active' : '' }}"
                                id="paystacktab" role="tabpanel" aria-labelledby="paystack">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.paystack_setting') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="paystack">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paystack_key">{{ __('setting.paystack_key') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paystack_key" id="paystack_key" type="text"
                                                        class="form-control @error('paystack_key')is-invalid @enderror"
                                                        value="{{ old('paystack_key', setting('paystack_key') ?? '') }}">
                                                    @error('paystack_key')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paystack_secret">{{ __('setting.paystack_secret') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paystack_secret" id="paystack_secret" type="text"
                                                        class="form-control @error('paystack_secret')is-invalid @enderror"
                                                        value="{{ old('paystack_secret', setting('paystack_secret') ?? '') }}">
                                                    @error('paystack_secret')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_paystack_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade {{ (old('settingtypepayment', setting('settingtypepayment')) == 'paypal') ? 'show active' : '' }}"
                                 id="paypaltab" role="tabpanel" aria-labelledby="paypal">
                                <form class="form-horizontal" role="form" method="POST"
                                      action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.paypal_setting') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="paypal">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paystack_key">{{ __('setting.paypal_client_id') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paypal_client_id" id="paypal_client_id" type="text"
                                                           class="form-control @error('paypal_client_id')is-invalid @enderror"
                                                           value="{{ old('paypal_client_id', setting('paypal_client_id') ?? '') }}">
                                                    @error('paypal_client_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paystack_key">{{ __('setting.paypal_client_secret') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paypal_client_secret" id="paypal_client_secret" type="text"
                                                           class="form-control @error('paypal_client_secret')is-invalid @enderror"
                                                           value="{{ old('paypal_client_secret', setting('paypal_client_secret') ?? '') }}">
                                                    @error('paypal_client_secret')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paystack_key">{{ __('setting.paypal_mode') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paypal_mode" id="paypal_mode" type="text"
                                                           class="form-control @error('paypal_mode')is-invalid @enderror"
                                                           value="{{ old('paypal_mode', setting('paypal_mode') ?? '') }}">
                                                    @error('paypal_mode')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paystack_key">{{ __('setting.paypal_app_id') }}</label>
                                                    <input name="paypal_app_id" id="paypal_app_id" type="text"
                                                           class="form-control @error('paypal_app_id')is-invalid @enderror"
                                                           value="{{ old('paypal_app_id', setting('paypal_app_id') ?? '') }}">
                                                    @error('paypal_app_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_paypal_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
