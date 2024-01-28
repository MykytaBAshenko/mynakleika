<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Языковые ресурсы названий менюшек
    |--------------------------------------------------------------------------
    |
    | Следующие языковые ресурсы используются в названиях
    | менюшек всего вашего приложения.
    | Вы можете свободно изменять эти языковые ресурсы в соответствии
    | с требованиями вашего приложения.
    |
    */

    'backend'         => [
        'access'     => [
            'title' => 'Администрирование',
            'roles' => [
                'all'        => 'Все роли',
                'create'     => 'Создать роль',
                'edit'       => 'Редактировать роль',
                'management' => 'Управление доступом',
                'main'       => 'Роли',
            ],
            'users' => [
                'all'             => 'Все пользователи',
                'change-password' => 'Изменить пароль',
                'create'          => 'Создать пользователя',
                'deactivated'     => 'Заблокированные пользователи',
                'deleted'         => 'Удаленные пользователи',
                'edit'            => 'Редактирование учётной записи',
                'main'            => 'Пользователи',
                'view'            => 'Просмотр учётной записи',
            ],
        ],

        'log-viewer' => [
            'main'      => 'Журнал ошибок',
            'dashboard' => 'Обзор',
            'logs'      => 'Все записи',
        ],

        'material' => 'Материалы',

        'options' => [
            'print_options' => 'Опции печати',
            'cost_options'  => 'Опции стоимости',
            'self_legal_entities' => 'Реквизиты',
            'payers'        => 'Контрагенты',
        ],

        'sidebar'    => [
            'dashboard' => 'Системная панель',
            'general'   => 'Главная',
            'system'    => 'Система',
            'app'       => 'Настройки приложения',
        ],
    ],

    'language-picker' => [
        'language' => 'Язык',
        /*
         * Add the new language to this array.
         * The key should have the same language code as the folder name.
         * The string should be: 'Language-name-in-your-own-language (Language-name-in-English)'.
         * Be sure to add the new language in alphabetical order.
         */
        'langs'    => [
            'en'    => 'Английский',
            'ru'    => 'Русский',
            'uk'    => 'Украинский',
        ],
    ],

    'customer' => [
        'header' => [
            'orders'    => 'Список заказов',
            'profile'   => 'Профиль',
            'invoices'  => 'Счета',
            'finance'   => 'Финансы',
        ],
        'profile' => [
            'customer_profile' => 'Личные данные',
            'legal_entities'   => 'Плательщики',
            'deliveries'       => 'Способы доставки',
        ],
        'finance' => [
            'invoices'      => 'Список счетов',
            'transactions'  => 'Журнал операций',
            'payments'      => 'Оплата',
        ]
    ],
];
