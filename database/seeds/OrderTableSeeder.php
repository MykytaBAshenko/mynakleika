<?php

use App\Models\Order;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Cmixin\BusinessDay;

class OrderTableSeeder extends Seeder
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

		$baseList = 'ua-national';
		BusinessDay::enable('Carbon\Carbon', $baseList);

        $order = Order::create(
            [
                'order_ref' => 'Наклейка Haliku',
                'customer_id' => 1,
                'production_status' => Order::SENT,
                'finance_status' => Order::PAID,
                'created_at' => Carbon::now()->subDays(2),
                'end_at' => Carbon::now(),
                'file_id' => 1,
                'format' => '85x85',
                'quantity' => 1500,
                'chromaticity' => 1,
                'lamination' => 1,
                'material_id' => 1,
                'delivery_id' => 1,
                'delivery_cost' => 0,
                'cost' => 256532,
            ]
        );
        $customer1 = $order->customer;
        $customer1->account -= $order->cost;

        $order = Order::create(
            [
                'order_ref' => 'Наклейка Loreal',
                'customer_id' => 1,
                'production_status' => Order::IN_PROGRESS,
                'finance_status' => Order::PAID,
                'created_at' => Carbon::now()->subDays(1),
                'end_at' => Carbon::now()->addDays(1),
                'file_id' => 2,
                'format' => '50x22',
                'quantity' => 1800,
                'chromaticity' => 3,
                'lamination' => 2,
                'material_id' => 2,
                'delivery_id' => 1,
                'delivery_cost' => 0,
                'cost' => 339032,
            ]
        );
		$customer1->account -= $order->cost;

        $order = Order::create(
            [
                'order_ref' => 'Наклейка Hedonist',
                'customer_id' => 1,
                'production_status' => Order::IN_PROGRESS,
                'finance_status' => Order::NOT_PAID,
                'created_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(3),
                'file_id' => 3,
                'format' => '45x45',
                'quantity' => 2500,
                'chromaticity' => 1,
                'lamination' => 1,
                'material_id' => 1,
                'delivery_id' => 1,
                'delivery_cost' => 0,
                'cost' => 1556500,
            ]
        );
		$customer1->account -= $order->cost;

		$order = Order::create(
            [
                'order_ref' => 'Наклейка Terraflu',
                'customer_id' => 1,
                'production_status' => Order::DONE,
                'finance_status' => Order::PAID,
                'created_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(2),
                'file_id' => 2,
                'format' => '45x45',
                'quantity' => 2500,
                'chromaticity' => 1,
                'lamination' => 1,
                'material_id' => 1,
                'delivery_id' => 1,
                'delivery_cost' => 0,
                'cost' => 500000,
            ]
        );
		$customer1->account -= $order->cost;

		$order = Order::create(
            [
                'order_ref' => 'Наклейка Roshen',
                'customer_id' => 1,
                'production_status' => Order::IN_PROGRESS,
                'finance_status' => Order::NOT_PAID,
                'created_at' => Carbon::now()->subDays(1),
                'end_at' => Carbon::now()->addDays(2),
                'file_id' => 1,
                'format' => '88x88',
                'quantity' => 1500,
                'chromaticity' => 1,
                'lamination' => 1,
                'material_id' => 1,
                'delivery_id' => 1,
                'delivery_cost' => 0,
                'cost' => 700000,
            ]
        );
		$customer1->account -= $order->cost;

		$order = Order::create(
            [
                'order_ref' => 'Наклейка LA',
                'customer_id' => 1,
                'production_status' => Order::HOLD,
                'finance_status' => Order::NOT_PAID,
                'created_at' => Carbon::now()->currentOrNextBusinessDay(),
                'end_at' => Carbon::now()->currentOrNextBusinessDay()->addBusinessDays(2),
                'file_id' => 2,
                'format' => '88x88',
                'quantity' => 1500,
                'chromaticity' => 1,
                'lamination' => 1,
                'material_id' => 1,
                'delivery_id' => 1,
                'delivery_cost' => 0,
                'cost' => 80000,
            ]
        );
		$customer1->account -= $order->cost;

		$order = Order::create(
            [
                'order_ref' => 'Наклейка RED',
                'customer_id' => 1,
                'production_status' => Order::HOLD,
                'finance_status' => Order::NOT_PAID,
                'created_at' => Carbon::now()->currentOrNextBusinessDay(),
                'end_at' => Carbon::now()->currentOrNextBusinessDay()->addBusinessDays(1),
                'file_id' => 3,
                'format' => '88x44',
                'quantity' => 1200,
                'chromaticity' => 1,
                'lamination' => 1,
                'material_id' => 1,
                'delivery_id' => 1,
                'delivery_cost' => 0,
                'cost' => 50000,
            ]
        );
		$customer1->account -= $order->cost;

        $customer1->save();

		// 2-nd customer seeds

        $order = Order::create(
            [
                'order_ref' => 'Наклейка Hedonist',
                'customer_id' => 2,
                'production_status' => Order::IN_PROGRESS,
                'finance_status' => Order::NOT_PAID,
                'created_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(2),
                'file_id' => 2,
                'format' => '45x45',
                'quantity' => 2500,
                'chromaticity' => 1,
                'lamination' => 1,
                'material_id' => 1,
                'delivery_id' => 1,
                'delivery_cost' => 0,
                'cost' => 1556500,
            ]
        );

        $customer2 = $order->customer;
        $customer2->account -= $order->cost;

        $order = Order::create(
            [
                'order_ref' => 'Наклейка Yezz',
                'customer_id' => 2,
                'production_status' => Order::SENT,
                'finance_status' => Order::PAID,
                'created_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(3),
                'file_id' => 1,
                'format' => '45x50',
                'quantity' => 2500,
                'chromaticity' => 1,
                'lamination' => 1,
                'material_id' => 1,
                'delivery_id' => 1,
                'delivery_cost' => 0,
                'cost' => 286500,
            ]
        );

		$customer2->account -= $order->cost;
        $customer2->save();

        $this->enableForeignKeys();

    }
}
