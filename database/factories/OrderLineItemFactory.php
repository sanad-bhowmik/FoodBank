<?php

namespace Database\Factories;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;



class OrderLineItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $unitPrice = rand(200, 100);
        $quantity  = rand(1, 5);
        return [
            'restaurant_id'    => Restaurant::get()->pluck('id')->random(),
            'order_id'         => Order::get()->pluck('id')->random(),
            'menu_item_id'     => MenuItem::get()->pluck('id')->random(),
            'quantity'         => $quantity,
            'unit_price'       => $unitPrice,
            'discounted_price' => 0.00,
            'item_total'       => $unitPrice * $quantity,
        ];
    }
}

