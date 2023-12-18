<?php

namespace Database\Seeders;

use App\Models\Cuisine;
use Illuminate\Database\Seeder;

class CuisineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Cuisine::class, 10)->create();
    }
}
