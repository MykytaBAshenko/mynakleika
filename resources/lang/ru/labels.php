<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Языковые ресурсы названий Labels
    |--------------------------------------------------------------------------
    |
    | Следующие языковые ресурсы используются в названиях
    | Labels всего вашего приложения.
    | Вы можете свободно изменять эти языковые ресурсы в соответствии
    | с требованиями вашего приложения.
    |
    */

    'general' => [
        'all'       => 'Все',
        'yes'       => 'Да',
        'no'        => 'Нет',
        'copyright' => 'Copyright',
        'custom'    => 'Выборочно',
        'actions' => 'Действие',
        'active'  => 'Активирован',
        'buttons' => [
            'save'   => 'Сохранить',
            'update' => 'Обновить',
        ],
        'hide'     => 'Скрыть',
        'inactive' => 'Неактивен',
        'none'              => 'Нет',
        'show'              => 'Показать',
        'toggle_navigation' => 'Навигация',

        'order_table' => [
            'id'                => 'Номер заказа',
            'created_at'        => 'Дата создания',
            'created_at_short'  => 'ДС',
            'end_at'            => 'Дата готовности',
            'end_at_short'      => 'ДГ',
            'customer'          => 'Заказчик',
            'order_ref'         => 'Название',
            'comments'          => 'Комментарии к заказу',
            'preview'           => 'Привью',
            'format'            => 'Формат (мм)',
            'quantity'          => 'Тираж',
            'chromaticity'      => 'Цветность',
            'lamination'        => 'Ламинация',
            'material'          => 'Материал',
            'matglanec'         => 'Ламинация',
            'ps_short'          => 'СП',
            'ps'                => 'Статус производства',
            'fs_short'          => 'ФС',
            'fs'                => 'Финансовый статус',
            'cost'              => 'Сумма',
            'delivery_type'     => 'Тип доставки',
            'address'           => 'Адрес',
            'np_sklad'          => 'Отделение Новой Почты',
            'np_organization'   => 'Получатель',
            'np_payer'          => 'Плательщик',
            'contacts'          => 'Контактное лицо',
            'details'           => 'Детали',
            'actions'           => 'Действия',
            'show'              => 'Показать детали',
            'hide'              => 'Скрыть детали',
        ],

        'invoice_table' => [
            'specification'     => 'Название заказа',
            'measurement'       => 'Единица',
            'amount'            => 'Количество',
            'cost'              => 'Стоимость',
        ],

        'sidebar' => [
            'balance'            => 'Баланс',
            'new_orders'         => 'Новые заказы',
            'in_progress_orders' => 'Заказы в работе',
            'completed_orders'   => 'Выполненные заказы',
            'delivered_orders'   => 'Доставленные заказы',
            'paid_orders'        => 'Оплаченные заказы',
            'unpaid_orders'      => 'Неоплаченные заказы',
            'your_manager'       => 'Ваш менеджер',
            'email'              => 'E-mail:',
            'mobile_phone'       => 'Моб.:',
            'phone'              => 'Тел.:',
        ],
    ],

    'backend'  => [
        'access' => [
            'roles' => [
                'create'     => 'Создать новую роль',
                'edit'       => 'Изменить роль',
                'management' => 'Доступ',
                'table'      => [
                    'number_of_users' => 'Пользователей',
                    'permissions'     => 'Разрешения',
                    'role'            => 'Роль',
                    'sort'            => 'Позиция',
                    'total'           => 'ролей всего|всего ролей',
                ],
            ],
            'users' => [
                'active'              => 'Активные пользователи',
                'all_permissions'     => 'Полный доступ',
                'change_password'     => 'Изменение пароля',
                'change_password_for' => 'Изменить пароль :user',
                'create'              => 'Создать учётную запись',
                'deactivated'         => 'Заблокированные пользователи',
                'deleted'             => 'Удаленные пользователи',
                'edit'                => 'Редактирование учётной записи',
                'management'          => 'Пользователи',
                'no_permissions'      => 'Нет разрешений',
                'no_roles'            => 'Невозможно присвоить роль.',
                'permissions'         => 'Разрешения',
                'table'               => [
                    'confirmed'         => 'Подтверждён',
                    'created'           => 'Создан',
                    'email'             => 'E-mail',
                    'id'                => 'ID',
                    'last_updated'      => 'Обновлён',
                    'name'              => 'Логин',
                    'first_name'        => 'Имя',
                    'last_name'         => 'Фамилия',
                    'no_deactivated'    => 'Нет заблокированных пользователей',
                    'no_deleted'        => 'Нет удаленных пользователей',
                    'other_permissions' => 'Другие Разрешения',
                    'permissions'       => 'Разрешения',
                    'roles'             => 'Роль',
                    'social'            => 'Социальный аккаунт',
                    'total'             => 'пользователей всего|всего пользователей',
                ],
                'tabs'                => [
                    'titles'  => [
                        'history'  => 'История',
                        'overview' => 'Обзор',
                    ],
                    'content' => [
                        'overview' => [
                            'avatar'       => 'Аватар',
                            'confirmed'    => 'Подтверждён',
                            'created_at'   => 'Создан',
                            'deleted_at'   => 'Удалён',
                            'email'        => 'E-mail',
                            'last_login_at' => 'Last Login At',
                            'last_login_ip' => 'Last Login IP',
                            'last_updated' => 'Обновлён',
                            'name'         => 'Логин',
                            'first_name'   => 'Имя',
                            'last_name'    => 'Фамилия',
                            'status'       => 'Статус',
                            'timezone'     => 'Timezone',
                        ],
                    ],
                ],
                'view'                => 'Просмотр учётной записи',
            ],
        ],

        'material' => [
            'name'      => 'Название материала',
            'reference' => 'Описание материала',
            'price'     => 'Цена за лист (в евро)',
            'status'    => 'В наличии',
        ],

        'print_option' => [
            'euro_currency'     => 'Курс Евро',
            'net_cost'          => 'Себестоимость печати (в евро)',
            'print_cost_color'  => 'Стоимость печати 4+0 (в евро) за лист',
            'print_cost_bw'     => 'Стоимость печати 1+0 (в евро) за лист',
            'layout_width'      => 'Ширина области печати (мм)',
            'layout_height'     => 'Высота области печати (мм)',
            'fieldW'            => 'Незапечатываемое поле по ширине х 2 право - лево (мм)',
            'fieldH'            => 'Незапечатываемое поле по высоте х 2 вех - низ (мм)',
            'bleed'             => 'Вылеты макетов (мм)',
        ],
    ],

    'frontend' => [
        'auth' => [
            'login_box_title'    => 'Вход',
            'login_button'       => 'Вход',
            'login_with'         => 'Вход из :social_media',
            'register_box_title' => 'Регистрация',
            'register_button'    => 'Зарегистрироваться',
            'remember_me'        => 'Запомнить меня',
        ],

        'contact' => [
            'box_title' => 'Контакт',
            'button'    => 'Отправить',
        ],

        'passwords' => [
            'expired_password_box_title'      => 'Срок действия изменения пароля истек.',
            'forgot_password'                 => 'Забыли Пароль?',
            'reset_password_box_title'        => 'Сброс Пароля',
            'reset_password_button'           => 'Смена пароля',
            'update_password_button'          => 'Обновить пароль',
            'send_password_reset_link_button' => 'Отправить',
        ],

        'user' => [
            'passwords' => [
                'change' => 'Изменить пароль',
            ],
            'profile'   => [
                'avatar'             => 'Аватар',
                'created_at'         => 'Создан',
                'edit_information'   => 'Редактирование информации',
                'email'              => 'E-mail',
                'last_updated'       => 'Обновлён',
                'name'               => 'Логин',
                'first_name'         => 'Имя',
                'last_name'          => 'Фамилия',
                'update_information' => 'Обновление информации',
            ],
        ],
    ],

    'customer' => [
        'order' => [
            'width'             => 'Ширина (мм)',
            'height'            => 'Высота (мм)',
            'term'              => 'Сроки',
            'date'              => 'Дата',
            'price'             => 'Цена',
            'choose_a_file'     => 'Выберите файл...',
            'delivery_method'   => 'Способ доставки',
        ],

        'profile' => [
            'id'                => 'ID',
            'first_name'        => 'Имя',
            'last_name'         => 'Фамилия',
            'email'             => 'E-mail',
            'tel'               => 'Рабочий телефон',
            'mobile'            => 'Моб. телефон',
            'customer_name'     => 'Организация',
            'customer_city'     => 'Город',
            'customer_address'  => 'Адрес офиса',
            'credit_limit'      => 'Кредитный лимит',
        ],
    ],
];
