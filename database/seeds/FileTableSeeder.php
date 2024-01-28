<?php

use App\Models\File;
use Illuminate\Database\Seeder;

class FileTableSeeder extends Seeder
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

        File::create(
            [
                'name' => 'haliku.jpg',
            ]
        );

        File::create(
            [
                'name' => 'loreal.jpg',
            ]
        );

        File::create(
            [
                'name' => 'hedonist.pdf',
            ]
        );

        $this->enableForeignKeys();
    }
}
