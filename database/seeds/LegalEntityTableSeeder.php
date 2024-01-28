<?php

use App\Models\LegalEntity;
use Illuminate\Database\Seeder;

class LegalEntityTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        LegalEntity::create([
            'name' 	        => "ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ «СФЕРА»",
            'alias'			=> "ТОВ «СФЕРА»",
            'is_nds_payer'  => true,
            'nds_payer_num' => 456456,
            'ipn'			=> 15151551,
            'bank_name'		=> "АТ «Альфа-Банк»",
            'edrpou'		=> 18848999,
            'bank_account'	=> 'UA657658568653334562384378323',
            'director_fio'	=> "Ковальов Д.О.",
            'f_index'		=> 22222,
            'f_city'		=> "Київ",
            'f_street'		=> "вул. Межигірська",
            'f_house'		=> "25",
            'f_office'		=> "313",
            'f_tel'			=> "+380443232125",
            'acc_email'		=> "buh@gmail.com",
            'l_index'		=> 22222,
            'l_city'		=> "Київ",
            'l_street'		=> "вул. Межигірська",
            'l_house'		=> "25",
            'l_office'		=> "313",
            'customer_id'	=> 1,
        ]);

        LegalEntity::create([
            'name' 	        => "ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ «КЕРНЕЛ»",
            'alias'			=> "ТОВ «КЕРНЕЛ»",
            'is_nds_payer'	=> true,
            'nds_payer_num' => 326456,
            'ipn'			=> 89515522,
            'bank_name'		=> "АТ «УкрЭксім Банк»",
            'edrpou'		=> 34654754,
            'bank_account'	=> 'UA657658568653334562384378345',
            'director_fio'	=> "Петров Д.О.",
            'f_index'		=> 12121,
            'f_city'		=> "Київ",
            'f_street'		=> "вул. Будівельників",
            'f_house'		=> "13",
            'f_office'		=> "103",
            'f_tel'			=> "+380441531525",
            'acc_email'		=> "buh@pp.ua",
            'l_index'		=> 23232,
            'l_city'		=> "Київ",
            'l_street'		=> "вул. Межигірська",
            'l_house'		=> "25",
            'l_office'		=> "313",
            'customer_id'	=> 1,
        ]);

        LegalEntity::create([
            'name'          => "ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ «УкрБуд»",
            'alias'         => "ТОВ «УкрБУД»",
            'is_nds_payer'  => true,
            'nds_payer_num' => 326456,
            'ipn'           => 89515522,
            'bank_name'     => "АТ «УкрЭксім Банк»",
            'edrpou'        => 34654754,
            'bank_account'  => 'UA657658568653334562384378345',
            'director_fio'  => "Петров Д.О.",
            'f_index'       => 12121,
            'f_city'        => "Київ",
            'f_street'      => "вул. Будівельників",
            'f_house'       => "13",
            'f_office'      => "103",
            'f_tel'         => "+380441531525",
            'acc_email'     => "buh@ukrbud.ua",
            'l_index'       => 23232,
            'l_city'        => "Київ",
            'l_street'      => "вул. Межигірська",
            'l_house'       => "25",
            'l_office'      => "313",
            'customer_id'   => 2,
        ]);

        $this->enableForeignKeys();
    }
}
