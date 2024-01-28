<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Menus Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in menu items throughout the system.
    | Regardless where it is placed, a menu item can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'backend' => [
        'access' => [
            'title' => 'Access',

            'roles' => [
                'all'        => 'All Roles',
                'create'     => 'Create Role',
                'edit'       => 'Edit Role',
                'management' => 'Role Management',
                'main'       => 'Roles',
            ],

            'users' => [
                'all'             => 'All Users',
                'change-password' => 'Change Password',
                'create'          => 'Create User',
                'deactivated'     => 'Deactivated Users',
                'deleted'         => 'Deleted Users',
                'edit'            => 'Edit User',
                'main'            => 'Users',
                'view'            => 'View User',
            ],
        ],

        'log-viewer' => [
            'main'      => 'Log Viewer',
            'dashboard' => 'Dashboard',
            'logs'      => 'Logs',
        ],

        'material' => 'Materials',

        'options' => [
            'print_options' => 'Print Options',
            'cost_options'  => 'Cost Options',
            'self_legal_entities' => 'Self Legal Entities',
        ],

        'sidebar' => [
            'dashboard' => 'Dashboard',
            'general'   => 'General',
            'history'   => 'History',
            'system'    => 'System',
            'app'       => 'Application Options',
        ],
    ],

    'language-picker' => [
        'language' => 'Language',
        /*
         * Add the new language to this array.
         * The key should have the same language code as the folder name.
         * The string should be: 'Language-name-in-your-own-language (Language-name-in-English)'.
         * Be sure to add the new language in alphabetical order.
         */
        'langs' => [
            'en'    => 'English',
            'ru'    => 'Russian',
            'uk'    => 'Ukrainian',
        ],
    ],

    'customer' => [
        'header' => [
            'orders'   => 'Orders',
            'profile'  => 'Profile',
            'invoices' => 'Invoices',
            'finance'  => 'Finance',
        ],
        'profile' => [
            'customer_profile' => 'Customer Profile',
            'legal_entities'   => 'Legal Entities',
            'deliveries'       => 'Delivery Types',
        ],
        'finance' => [
            'invoices'      => 'Order List',
            'transactions'  => 'Transactions',
            'payments'      => 'Payments',
        ]
    ],
];
