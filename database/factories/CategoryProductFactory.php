<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;



class CategoryProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::get()->pluck('id')->random(),
            'product_id'  => Product::get()->pluck('id')->random(),
        ];
    }
}
