<?php

use App\Models\Customer;
use App\Models\Delivery;
use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
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

        $customer1 = Customer::create([
            'user_id'           => 2,
            'customer_name'     => 'Smartprint',
            'customer_city'     => 'Киев',
            'customer_address'  => 'ул Фрунзе, д 10, офис 56',
            'account'           => 0,
            'credit_limit'      => 0,
        ]);

//        $customer2 = Customer::create([
//            'user_id'           => 5,
//            'customer_name'     => 'Fozzy Group',
//            'customer_city'     => 'Вишневое',
//            'customer_address'  => 'ул. Калачевская, 13',
//            'account'           => 0,
//            'credit_limit'      => 0,
//        ]);

        $delivery = Delivery::find(1);
        $customer1->deliveries()->attach($delivery);

        $this->enableForeignKeys();
    }
}
