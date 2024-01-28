<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'cache',
            'jobs',
            'sessions',
        ]);

        $this->call(AuthTableSeeder::class);
        $this->call(MaterialTableSeeder::class);

        $this->call(DeliveryTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
//        $this->call(FileTableSeeder::class);
//        $this->call(OrderTableSeeder::class);
        $this->call(OptionTableSeeder::class);
//        $this->call(LegalEntityTableSeeder::class);
//        $this->call(InvoiceTableSeeder::class);

        Model::reguard();
    }
}
