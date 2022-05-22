<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(); // use fakers for random code generation
        Product::insert([
            [
                'name' => 'Рубашка',
                'code' => $faker->ean8(),
            ],
            [
                'name' => 'Брюки',
                'code' => $faker->ean8(),
            ],
        ]);
        
    }
}
