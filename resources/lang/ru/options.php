<?php

use App\Models\Delivery;
use App\Models\LegalEntity;
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
        Order::HOLD         => 'ожидает оплаты',
        Order::IN_PROGRESS  => 'в работе',
        Order::SENT         => 'отправлен',
        Order::DONE         => 'выполнен',
        Order::CANCELED     => 'отменен'
    ],

    'finance_status' => [
        Order::NOT_PAID     => 'не оплачен',
        Order::PARTLY_PAID  => 'частично оплачен',
        Order::PAID         => 'оплачен',
    ],

    'lamination_options' => [
        Order::NONE         => 'нет',
        Order::MATT         => 'глянцевая',
        Order::GLOSS        => 'матовая',
    ],

    'chromaticity_options' => [
        Order::COLOR        => '4+0',
        Order::BW           => '1+0',
    ],

    'days_options' => [
        '2' => 'Печать 2 дня',
        '3' => 'Печать 3 дня',
        '4' => 'Печать 4 дня',
    ],

    'delivery_options' => [
        Delivery::TYPE_PICKUP    => 'Самовывоз',
        Delivery::TYPE_COURIER   => 'Курьером по Киеву',
        Delivery::TYPE_SERVICE   => 'Новая Почта',
    ],

    'delivery_payer_options' => [
        Delivery::PAYER_SENDER   => 'Отправитель',
        Delivery::PAYER_RECEIVER => 'Получатель',
    ],

    'payer_verification_status_options' => [
        LegalEntity::VERIFICATION_STATUS_WAITING    => 'Не подтвержден',
        LegalEntity::VERIFICATION_STATUS_APPROVED   => 'Подтвержден',
        LegalEntity::VERIFICATION_STATUS_REJECTED   => 'Отклонен',
    ],
];
