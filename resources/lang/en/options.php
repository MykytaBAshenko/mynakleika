<?php

use App\Models\Delivery;
use App\Models\Order;

return [

    /*
    |--------------------------------------------------------------------------
    | Options Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in orders options throughout the system.
    |
    */

    'production_status' => [
		Order::HOLD         => 'hold',
		Order::IN_PROGRESS  => 'in progress',
		Order::SENT         => 'sent',
        Order::DONE         => 'done',
        Order::CANCELED     => 'canceled'
	],

    'finance_status' => [
        Order::NOT_PAID     => 'not paid',
        Order::PARTLY_PAID  => 'partly_paid',
        Order::PAID         => 'paid',
    ],

    'lamination_options' => [
        Order::NONE         => 'none',
        Order::MATT         => 'matt',
        Order::GLOSS        => 'gloss',
    ],

    'chromaticity_options' => [
        Order::COLOR        => '4+0',
        Order::BW           => '1+0',
    ],

    'days_options' => [
        '2' => 'Print 2 days',
        '3' => 'Print 3 days',
        '4' => 'Print 4 days',
    ],

    'delivery_options' => [
        Delivery::TYPE_PICKUP    => 'Pickup',
        Delivery::TYPE_COURIER   => 'Courier',
        Delivery::TYPE_SERVICE   => 'Delivery service',
    ],

    'delivery_payer_options'=> [
        Delivery::PAYER_SENDER   => 'Sender',
        Delivery::PAYER_RECEIVER => 'Receiver',
    ],
];
