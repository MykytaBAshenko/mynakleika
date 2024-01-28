<?php

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    use DisableForeignKeys;

    public function run()
    {
        $this->disableForeignKeys();

        Material::create([
            'material_name'  => 'Бумага',
            'material_ref'   => '',
            'material_price' => 0.38,
            'in_stock'       => true,
            'layoutW'        => 200,
            'layoutH'        => 700,
            'cost_printing'  => json_encode([
                1 => 80,
                6 => 52,
                16 => 37,
                26 => 22,
                51 => 17,
                101 => 12,
                151 => 10,
                200 => 5
            ]),
            'cost_cut'  => json_encode([
                1 => 80,
                6 => 52,
                16 => 37,
                26 => 22,
                51 => 17,
                101 => 12,
                151 => 10,
                200 => 5
            ]),
            'quantity_factor' => json_encode([
                1 => 1,
                6 => 1.2,
                16 => 1.5,
                26 => 1.6,
                51 => 1.7,
                101 => 1.8,
                151 => 1.9,
                200 => 2
            ]),
            'mat_glanec_covering' => json_encode([
                1 => [1, 1],
                6 => [2, 5],
                16 => [2, 5],
                26 => [2, 5],
                51 => [2, 5],
                101 => [2, 5],
                151 => [21, 45],
                200 => [56, 10]
            ])
        ]);

        Material::create([
            'material_name'  => 'Пленка',
            'material_ref'   => '',
            'material_price' => 0.50,
            'in_stock'       => true,
            'layoutW'        => 400,
            'layoutH'        => 800,
            'cost_printing'  => json_encode([
                1 => 80,
                6 => 52,
                16 => 37,
                26 => 22,
                51 => 17,
                101 => 12,
                151 => 10,
                200 => 5
            ]),
            'cost_cut'  => json_encode([
                1 => 80,
                6 => 52,
                16 => 37,
                26 => 22,
                51 => 17,
                101 => 12,
                151 => 10,
                200 => 5
            ]),
            'quantity_factor' => json_encode([
                1 => 1,
                6 => 1.2,
                16 => 1.5,
                26 => 1.6,
                51 => 1.7,
                101 => 1.8,
                151 => 1.9,
                200 => 2
            ]),
            'mat_glanec_covering' => json_encode([
                1 => [1, 1],
                6 => [2, 5],
                16 => [2, 5],
                26 => [2, 5],
                51 => [2, 5],
                101 => [2, 5],
                151 => [21, 45],
                200 => [56, 10]
            ])
        ]);

        $this->enableForeignKeys();
    }
}
