<?php

use Illuminate\Database\Seeder;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // use DisableForeignKeys;

    public function run()
    {
		// Financial options

		option(['euro_currency' => 30]);
		option(['net_cost' => 3000]);
        option(['speed_index' => json_encode([
            2 => 1.1,
            3 => 1.05,
            4 => 1.02,
            5 => 1,
        ])]);

		option(['print_cost_customer_color' => json_encode(
            [
                '1-5' 	 => 62,
                '6-15'   => 52,
                '16-25'  => 37,
                '26-50'  => 22,
                '51-100' => 17,
                '101-150'=> 12,
                '151-200'=> 7,
                '200-'   => 2,
            ])
        ]);
        option(['print_cost_guest_color' => json_encode(
            [
                '1-5' 	 => 65,
                '6-15'   => 55,
                '16-25'  => 40,
                '26-50'  => 25,
                '51-100' => 20,
                '101-150'=> 15,
                '151-200'=> 10,
                '200-'   => 5,
            ])
        ]);

        option(['print_cost_customer_bw' => json_encode(
            [
                '1-5' 	 => 1,
                '6-15'   => 1.05,
                '16-25'  => 1.1,
                '26-50'  => 1.15,
                '51-100' => 1.2,
                '101-150'=> 1.3,
                '151-200'=> 1.6,
                '200-'   => 1.8,
            ])
        ]);

        option(['print_cost_guest_bw' => json_encode(
            [
                '1-5' 	 => 35,
                '6-15'   => 25,
                '16-25'  => 15,
                '26-50'  => 10,
                '51-100' => 8,
                '101-150'=> 6,
                '151-200'=> 3,
                '200-'   => 1,
            ])
        ]);

		// Layout Canvas Options

		option(['layoutW' => 330]);
		option(['layoutH' => 330]);
		option(['fieldW' => 12.5]);
		option(['fieldH' => 12.5]);
		option(['bleed' => 2.5]);
		option(['minW' => 10]);
        option(['minH' => 10]);


		// Legal Entity Options

		option(['tov' =>
			json_encode([
                'name' 	=> "ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ «СМАРТ ПРИНТ»",
                'type'          => 1,
                'has_e_docflow' => true,
                'alias' 	    => "ТОВ «СМАРТ ПРИНТ»",
                'edrpou'		=> 37451194,
                'is_nds_payer'	=> true,
                'nds_payer_num' => 200122167,
                'bank_name'     => "АТ «ПРОКРЕДИТ БАНК»",
                'bank_account'	=> 'UA163209840000026007210326144',
                'ipn'			=> 374511926565,
                'address'		=> "вул.Новомостицька, 25, ГК «Барвінок», г/б №2303, м.Київ, 04074",
                'tel'			=> "+38 044 361 32 12",
                'stamp_link' 	=> "/storage/self/stamp.png"
            ])
        ]);
        option(['fop' =>
            json_encode([
                'name' 	        => "Фізична особа підприємець Романенко Ганна Стефанівна",
                'type'          => 2,
                'has_e_docflow' => false,
                'alias' 	    => "ФОП Романенко Г.С.",
                'is_nds_payer'	=> false,
                'ipn'			=> "1858903845",
                'address'		=> "28300, м. Олександрія, вул. Міліцейська 131/95",
                'tel'			=> "",
                'stamp_link' 	=> "/storage/self/stamp.png"
            ])
        ]);
    }
}
