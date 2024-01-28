<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Forms Language Lines
    |--------------------------------------------------------------------------
    */
    'required' => [
        'description' => 'Поле {_field_} является обязательным',
    ],

    'email' => [
        'description' => 'Поле {_field_} должно быть действительным электронным адресом',
    ],

    'alpha' => [
        'description' => 'Поле {_field_} должно содержать только буквы',
    ],

    'confirmed' => [
        'description' => 'Подтверждение должно совпадать с паролем',
    ],

    'length' => [
        'description' => 'Поле {_field_} должно содержать {length} символов',
    ],

    'size' => [
        'description' => 'Размер файла не должен превышать {size} Mb',
    ],

    'numeric' => [
        'description' => 'Поле {_field_} должно содержать только цифры',
    ],

    'min_value' => [
        'description' => 'Значение должно быть не меньше {min_value}',
    ],

    'max_value' => [
        'description' => 'Значение должно быть не больше {max_value}',
    ],

    'register' => [
        'label' => [
            'first_name'            => 'Имя',
            'last_name'             => 'Фамилия',
            'email'                 => 'E-mail',
            'mobile'                => 'Телефон',
            'customer_name'         => 'Организация',
            'customer_city'         => 'Город',
            'customer_address'      => 'Адрес',
            'password'              => 'Пароль',
            'password_confirmation' => 'Подтверждение пароля',
        ],

        'placeholder' => [
            'first_name'            => 'Имя',
            'last_name'             => 'Фамилия',
            'email'                 => 'E-mail',
            'mobile'                => 'Номер телефона',
            'customer_name'         => 'Название организации',
            'customer_city'         => 'Город',
            'customer_address'      => 'Адрес офиса',
            'password'              => 'Введите пароль',
            'password_confirmation' => 'Подтвердите пароль',
        ],

        'description' => [

        ],
    ],

    'order' => [
        'name' => [
            'file'              => 'Файл',
            'width'             => 'Ширина',
            'height'            => 'Высота',
            'quantity'          => 'Тираж',
            'material'          => 'Материал',
            'matglanec'         => 'Ламинация',
            'lamination'        => 'Ламинация',
            'chromaticity'      => 'Цветность',
            'order_name'        => 'Название',
            'method'            => 'Способ доставки',
        ],

        'label' => [
            'file'              => 'Файл',
            'width'             => 'Ширина (мм)',
            'height'            => 'Высота (мм)',
            'quantity'          => 'Тираж',
            'material'          => 'Материал',
            'matglanec'         => 'Ламинация',
            'lamination'        => 'Ламинация',
            'chromaticity'      => 'Цветность',
            'order_name'        => 'Название',
            'method'            => 'Способ доставки',
        ],

        'placeholder' => [
            'file'              => 'Выберите файл',
            'order_name'        => 'Название заказа',
            'material'          => 'Выберите материал',
            'matglanec'         => 'Выбирите ламинацию',
            'lamination'        => 'Выбирите ламинацию',
            'method'            => 'Выберите способ доставки',
        ],

        'description' => [
            'file'              => 'Максимальный размер: :maxFileSize Mb',
            'width'             => 'Минимальная ширина :minW мм, максимальная :maxW мм',
            'height'            => 'Минимальная высота :minH мм, максимальная :maxH мм',
            'quantity'          => 'Минимальный тираж - 1 шт.',
        ],
    ],

    'delivery' => [
        'label' => [
            'method'            => 'Способ доставки',
            'city'              => 'Город',
            'warehouse'         => 'Отделение',
            'receiver'          => 'Получатель',
            'payer'             => 'Плательщик',
            'contact_person'    => 'Контактное лицо',
            'contact_phone'     => 'Телефон',
            'address'           => 'Адрес доставки',
        ],

        'placeholder' => [
            'method'            => 'Выберите способ доставки',
            'city'              => 'Выберите город',
            'warehouse'         => 'Выберите отделение',
        ],

        'description' => [
            'receiver'          => 'Физ. лицо, ФОП, ПП или ТОВ',
            'contact_phone'     => 'Контактный телефон',
            'address'           => 'Укажите улицу, дом, номер офиса или квартиры',
        ],
    ],

    'invoice' => [
        'label' => [
            'payer'             => 'Плательщик',
            'receiver'          => 'Получатель',
            'choose_orders'     => 'Выбрать заказы',
            'free_amount'       => 'Свободная сумма',
        ],

        'placeholder' => [
            'payer'             => 'Выберите плательщика',
        ],

        'description' => [
        ],
    ],

    'income' => [
        'label' => [
            'legal-entity'  => 'Контрагент',
            'invoice'       => 'Номер счета',
            'payment_date'  => 'Дата оплаты',
            'number'        => 'Номер платежного сообщения',
            'sum'           => 'Сумма',
            'description'   => 'Назначение платежа',
        ],

        'placeholder' => [
            'legal-entity'  => 'Выберите контрагента',
            'invoice'       => 'Выберите номер счета',
        ],

        'description' => [
        ],
    ],

    'legal_entity' => [
        'label' => [
            'type'          => 'Плательщик',
            'alias'         => 'Краткое название',
            'name'          => 'Полное название',
            'edrpou'        => 'ЕГРПОУ',
            'director_fio'  => 'ФИО директора',
            'is_nds_payer'  => 'Плательщик НДС',
            'nds_payer_num' => 'Номер свидетельства НДС',
            'ipn'           => 'ИНН',
            'has_e_docflow' => 'Документооборот',
            'legal_address' => 'Юридический адрес',
            'actual_address'=> 'Фактический адрес',
            'tel'           => 'Номер телефона',
            'bank_name'     => 'Банк',
            'bank_mfo'      => 'МФО',
            'bank_account'  => 'Расчетный Счет',
            'f_index'       => 'Индекс',
            'f_city'        => 'Город',
            'f_street'      => 'Улица',
            'f_house'       => 'Номер дома',
            'f_office'      => 'Номер офиса',
            'f_tel'         => 'Номер телефона с кодом города',
            'l_index'       => 'Индекс',
            'l_city'        => 'Город',
            'l_street'      => 'Улица',
            'l_house'       => 'Номер дома',
            'l_office'      => 'Номер офиса',
            'acc_email'     => 'Электронная почта бухгалтера',
        ],

        'placeholder' => [
            'type'          => 'Выберите...',
            'is_nds_payer'  => 'Выберите...',
            'has_e_docflow' => 'Выберите...',
        ],

        'description' => [
            'type'          => 'Предприятие или ФОП',
            'alias'         => 'Пример: ТОВ «СФЕРА»',
            'name'          => 'Пример: ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ «СФЕРА»',
            'is_nds_payer'  => 'Является ли юридическое лицо плательщиком НДС?',
            'ipn'           => 'Индивидуальний налоговый номер',
            'has_e_docflow' => 'Электронный документооборот (M.E.Doc) или бумажные документы',
        ],
    ],

    'entrepreneur' => [
        'label' => [
            'alias'         => 'Краткое название',
            'name'          => 'Полное название',
            'edrpou'        => 'ЕГРПОУ',
            'director_fio'  => 'ФИО директора',
            'is_nds_payer'  => 'Плательщик НДС',
            'nds_payer_num' => 'Номер свидетельства НДС',
            'ipn'           => 'ИНН',
            'has_e_docflow' => 'Документооборот',
            'legal_address' => 'Юридический адрес',
            'actual_address'=> 'Фактический адрес',
            'tel'           => 'Номер телефона',
            'bank_name'     => 'Банк',
            'bank_mfo'      => 'МФО',
            'bank_account'  => 'Расчетный Счет',
            'f_index'       => 'Индекс',
            'f_city'        => 'Город',
            'f_street'      => 'Улица',
            'f_house'       => 'Номер дома',
            'f_office'      => 'Номер офиса',
            'f_tel'         => 'Номер телефона с кодом города',
            'l_index'       => 'Индекс',
            'l_city'        => 'Город',
            'l_street'      => 'Улица',
            'l_house'       => 'Номер дома',
            'l_office'      => 'Номер офиса',
            'acc_email'     => 'Электронная почта бухгалтера',
        ],

        'placeholder' => [
            'is_nds_payer'  => 'Выберите...',
        ],

        'description' => [
            'alias'         => 'Пример: ФОП Коваленко І. П.',
            'name'          => 'Пример: ФОП Коваленко Іван Пертович',
            'is_nds_payer'  => 'Является ли плательщиком НДС?',
            'ipn'           => 'Индивидуальний налоговый номер',
        ],
    ],
];
