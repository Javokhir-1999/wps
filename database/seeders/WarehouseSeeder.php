<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Warehouse::insert([
            ['material_id' => 1, 'remainder' => 12, 'price' => 1500],
            ['material_id' => 1, 'remainder' => 200, 'price' => 1600],
            ['material_id' => 3, 'remainder' => 40, 'price' => 500],
            ['material_id' => 3, 'remainder' => 300, 'price' => 550],
            ['material_id' => 2, 'remainder' => 500, 'price' => 300],
            ['material_id' => 4, 'remainder' => 1000, 'price' => 2000],

        ]);
    }
}
