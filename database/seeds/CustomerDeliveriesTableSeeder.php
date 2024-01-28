<?php

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Delivery;

class CustomerDeliveriesTableSeeder extends Seeder
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

        $this->enableForeignKeys();
    }
}
