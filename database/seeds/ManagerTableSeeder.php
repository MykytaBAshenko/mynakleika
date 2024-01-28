<?php

use App\Models\Manager;
use Illuminate\Database\Seeder;

class ManagerTableSeeder extends Seeder
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

        Manager::create([
            'user_id'  => 2,
        ]);

        Manager::create([
            'user_id'  => 3,
        ]);

        $this->enableForeignKeys();
    }
}
