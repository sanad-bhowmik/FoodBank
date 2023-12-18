<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Libraries\MyString;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;



class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $autoIncrement = autoIncrement();
        $total          = rand(5000, 10000);
        $deliveryCharge = rand(50, 100);
        $autoIncrement->next();

        $role = Role::find(2);
        return [
            'user_id'         => User::role($role->name)->get()->pluck('id')->random(),
            'restaurant_id'   => Restaurant::get()->pluck('id')->random(),
            'total'           => $total + $deliveryCharge,
            'sub_total'       => $total,
            'delivery_charge' => $deliveryCharge,
            'status'          => OrderStatus::PENDING,
            'payment_status'  => PaymentStatus::UNPAID,
            'paid_amount'     => 0.00,
            'address'         => $this->faker->address,
            'payment_method'  => PaymentMethod::CASH_ON_DELIVERY,
            'mobile'          => $this->faker->phoneNumber,
            'lat'             => $this->faker->latitude,
            'long'            => $this->faker->longitude,
            'misc'            => json_encode(['order_code' => 'ORD-' . MyString::code($autoIncrement->current())]),
        ];
    }
}

function autoIncrement()
{
    for ($i = 0; $i < 1000; $i++) {
        yield $i;
    }
}

