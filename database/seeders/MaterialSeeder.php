<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Material::insert([
            ['name' => 'Ткань'],
            ['name' => 'Пуговица'],
            ['name' => 'Нитка'],
            ['name' => 'Замок'],
        ]);
    }
}
