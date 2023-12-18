<?php

namespace Database\Factories;

use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Factories\Factory;



class CuisineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'         => $faker->name,
            'slug'         => $faker->slug,
            'description'  => $faker->text(100),
            'depth'        => 1,
            'left'         => 2,
            'right'        => 3,
            'parent_id'    => null,
            'status'       => CategoryStatus::ACTIVE,
            'creator_type' => 'App\Models\User',
            'creator_id'   => 1,
            'editor_type'  => 'App\Models\User',
            'editor_id'    => 1,
        ];
    }
}

