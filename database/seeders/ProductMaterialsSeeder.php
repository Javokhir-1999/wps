<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductMaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_materials')->insert([
            ['product_id' => 1, 'material_id' => 1, 'quantity' => 0.8],
            ['product_id' => 1, 'material_id' => 2, 'quantity' => 5],
            ['product_id' => 1, 'material_id' => 3, 'quantity' => 10],
            ['product_id' => 2, 'material_id' => 1, 'quantity' => 1.4],
            ['product_id' => 2, 'material_id' => 3, 'quantity' => 15],
            ['product_id' => 2, 'material_id' => 4, 'quantity' => 1],

        ]);
    }
}
