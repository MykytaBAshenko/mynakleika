<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Forms Language Lines
    |--------------------------------------------------------------------------
    */
    'required' => [
        'description' => 'Field {_field_} is required',
    ],

    'email' => [
        'description' => 'Field {_field_} must be valid e-mail address',
    ],

    'alpha' => [
        'description' => 'Field {_field_} must contain only letters',
    ],

    'confirmed' => [
        'description' => 'Confirmation must match password',
    ],

    'length' => [
        'description' => 'The {_field_} field must have exactly {length} characters',
    ],

    'size' => [
        'description' => 'File size must be no more than {size} Mb',
    ],

    'numeric' => [
        'description' => 'Field {_field_} must contain only numbers',
    ],

    'min_value' => [
        'description' => 'The value must be at least {min_value}',
    ],

    'max_value' => [
        'description' => 'The value should be no more {max_value}',
    ],

    'register' => [
        'label' => [
            'first_name'            => 'First Name',
            'last_name'             => 'Last Name',
            'email'                 => 'E-mail',
            'mobile'                => 'Mobile Phone',
            'customer_name'         => 'Customer Name',
            'customer_city'         => 'City',
            'customer_address'      => 'Office Address',
            'password'              => 'Password',
            'password_confirmation' => 'Password Confirmation',
        ],

        'placeholder' => [
            'first_name'            => 'First Name',
            'last_name'             => 'Last Name',
            'email'                 => 'E-mail',
            'mobile'                => 'Mobile Phone',
            'customer_name'         => 'Customer Name',
            'customer_city'         => 'City',
            'customer_address'      => 'Office Address',
            'password'              => 'Enter Password',
            'password_confirmation' => 'Confirm Password',
        ],

        'description' => [

        ],
    ],

    'order' => [
        'name' => [
            'file'              => 'File',
            'width'             => 'Width (mm)',
            'height'            => 'Height (mm)',
            'quantity'          => 'Quantity',
            'material'          => 'Material',
            'lamination'        => 'Lamination',
            'chromaticity'      => 'Chromaticity',
            'order_name'        => 'Order Name',
            'method'            => 'Delivery Method',
        ],

        'label' => [
            'file'              => 'File',
            'width'             => 'Width',
            'height'            => 'Height',
            'quantity'          => 'Quantity',
            'material'          => 'Material',
            'lamination'        => 'Lamination',
            'chromaticity'      => 'Chromaticity',
            'order_name'        => 'Order Name',
            'method'            => 'Delivery Method',
        ],

        'placeholder' => [
            'file'              => 'Choose File',
            'order_name'        => 'Order Name',
            'method'            => 'Choose delivery method',
        ],

        'description' => [
            'file'              => 'Максимальный размер: :maxFileSize Mb',
            'width'             => 'Минимальная ширина :minW мм, максимальная :maxW мм',
            'height'            => 'Минимальная высота :minH мм, максимальная :maxH мм',
        ],
    ],

    'delivery' => [
        'label' => [
            'method'            => 'Delivery method',
            'city'              => 'City',
            'warehouse'         => 'Warehouse',
            'receiver'          => 'Receiver',
            'payer'             => 'Payer',
            'contact_person'    => 'Contact person',
            'contact_phone'     => 'Contact phone',
            'address'           => 'Address',
        ],

        'placeholder' => [
            'method'            => 'Choose delivery method',
            'city'              => 'Choose city',
            'warehouse'         => 'Choose warehouse',
        ],

        'description' => [
            'receiver'          => '',
            'contact_phone'     => 'Contact phone',
            'address'           => '',
        ],
    ],

    'invoice' => [
        'label' => [
            'payer'             => 'Payer',
            'receiver'          => 'Receiver',
            'choose_orders'     => 'Choose Orders',
            'free_amount'       => 'Free Amount',
        ],

        'placeholder' => [
            'payer'             => 'Choose Payer',
        ],

        'description' => [
        ],
    ],

    'legal_entity' => [
        'label' => [
            'alias'         => 'Short title',
            'name'          => 'Full title',
            'edrpou'        => 'EDRPOU',
            'director_fio'  => 'Name of Director',
            'nds_payer'     => 'VAT payer',
            'nds_payer_num' => 'VAT Certificate Number',
            'ipn'           => 'ITN',
            'bank_name'     => 'Bank',
            'bank_mfo'      => 'MFI',
            'bank_account'  => 'Payment account',
            'f_index'       => 'Postal index',
            'f_city'        => 'City',
            'f_street'      => 'Street',
            'f_house'       => 'House number',
            'f_office'      => 'Office number',
            'f_tel'         => 'Phone number with area code',
            'l_index'       => 'Postal index',
            'l_city'        => 'City',
            'l_street'      => 'Street',
            'l_house'       => 'House number',
            'l_office'      => 'Office number',
            'acc_email'     => 'Accountant Email',
        ],

        'placeholder' => [

        ],

        'description' => [
            'alias'         => 'Example: ТОВ «СФЕРА»',
            'name'          => 'Example: ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ «СФЕРА»',
            'nds_payer'     => 'Is a legal entity a VAT payer?',
            'ipn'           => 'Individual tax number',
        ],
    ],
];
