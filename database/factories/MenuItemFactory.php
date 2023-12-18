<?php

namespace Database\Factories;

use App\Enums\MenuItemStatus;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'restaurant_id' => 1,
            'name'          => $this->faker->company,
            'description'   => $this->faker->text(100),
            'unit_price'    => random_int(10, 100),
            'status'        => MenuItemStatus::ACTIVE,
            'creator_type'  => 'App\Models\User',
            'creator_id'    => User::get()->pluck('id')->random(),
            'editor_type'   => 'App\Models\User',
            'editor_id'     => User::get()->pluck('id')->random(),
        ];
    }
}

