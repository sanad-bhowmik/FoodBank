<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Database\Eloquent\Factories\Factory;



class OrderHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id'        => Order::get()->pluck('id')->random(),
            'previous_status' => null,
            'current_status'  => OrderStatus::PENDING,
        ];
    }
}
