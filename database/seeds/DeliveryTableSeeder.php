<?php

use App\Models\Delivery;
use Illuminate\Database\Seeder;

class DeliveryTableSeeder extends Seeder
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

		Delivery::create([
			'type' => Delivery::TYPE_PICKUP,
		]);

		$this->enableForeignKeys();
	}
}
