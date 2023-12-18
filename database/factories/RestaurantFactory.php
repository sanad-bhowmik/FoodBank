<?php

namespace Database\Factories;

use App\Enums\WaiterStatus;
use App\Models\User;
use App\Enums\TableStatus;
use App\Models\Restaurant;
use App\Enums\PickupStatus;
use App\Enums\CurrentStatus;
use App\Enums\DeliveryStatus;
use Faker\Generator as Faker;
use App\Enums\RestaurantStatus;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;



class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $role = Role::find(3);
        return [
            'user_id'         => User::role($role->name)->pluck('id')->random(),
            'name'            => $this->faker->company,
            'description'     => $this->faker->text(100),
            'delivery_charge' => random_int(10, 100),
            'lat'             => $this->faker->latitude,
            'long'            => $this->faker->longitude,
            'opening_time'    => $this->faker->time("H:i:s"),
            'closing_time'    => $this->faker->time("H:i:s"),
            'address'         => $this->faker->address,
            'status'          => RestaurantStatus::ACTIVE,
            'waiter_status'  =>  WaiterStatus::YES,
            'current_status'  => CurrentStatus::YES,
            'delivery_status' => DeliveryStatus::ENABLE,
            'pickup_status'   => PickupStatus::ENABLE,
            'table_status'    => TableStatus::ENABLE,
            'applied'         => false,
            'creator_type'    => 'App\Models\User',
            'creator_id'      => 1,
            'editor_type'     => 'App\Models\User',
            'editor_id'       => 1,
        ];
    }
}

