<?php

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Database\Seeder;

class InvoiceTableSeeder extends Seeder
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

		$invoice1 = Invoice::create([
			'legal_entity_id'   => 1,
			'type'     			=> 'selected_orders',
			'sum'  				=> 595564
		]);

		$invoice2 = Invoice::create([
			'legal_entity_id'   => 1,
			'type'     			=> 'selected_orders',
			'sum'  				=> 1556500
		]);

		$order1 = Order::find(100001);
		$order2 = Order::find(100002);
		$invoice1->orders()->attach($order1);
		$invoice1->orders()->attach($order2);

		$order3 = Order::find(100003);
		$invoice2->orders()->attach($order3);

		$this->enableForeignKeys();
	}
}
