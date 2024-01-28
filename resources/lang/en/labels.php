<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Labels Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in labels throughout the system.
    | Regardless where it is placed, a label can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'general' => [
        'all'     => 'All',
        'yes'     => 'Yes',
        'no'      => 'No',
        'copyright' => 'Copyright',
        'custom'  => 'Custom',
        'actions' => 'Actions',
        'active'  => 'Active',
        'buttons' => [
            'save'   => 'Save',
            'update' => 'Update',
        ],
        'hide'              => 'Hide',
        'inactive'          => 'Inactive',
        'none'              => 'None',
        'show'              => 'Show',
        'toggle_navigation' => 'Toggle Navigation',
        'create_new'        => 'Create New',
        'toolbar_btn_groups' => 'Toolbar with button groups',
        'more'              => 'More',
        'none'              => 'None',

        'order_table' => [
            'id'                => 'ID',
            'created_at'        => 'Start Time',
            'created_at_short'  => 'ST',
            'end_at'            => 'End Time',
            'end_at_short'      => 'ET',
            'customer'          => 'Customer',
            'order_ref'         => 'Order Reference',
            'comments'          => 'Order Comments',
            'preview'           => 'Preview',
            'format'            => 'Format',
            'quantity'          => 'Quantity',
            'chromaticity'      => 'Chromaticity',
            'lamination'        => 'Lamination',
            'material'          => 'Material',
            'ps_short'          => 'PS',
            'ps'                => 'Production Status',
            'fs_short'          => 'FS',
            'fs'                => 'Financial Status',
            'cost'              => 'Cost',
            'delivery_type'     => 'Delivery Type',
            'address'           => 'Address',
            'np_sklad'          => 'NP Department',
            'np_organization'   => 'Receiver',
            'np_payer'          => 'Payer',
            'contacts'          => 'Contact Person',
            'details'           => 'Details',
            'actions'           => 'Actions',
            'show'              => 'Show Details',
            'hide'              => 'Hide Details',
        ],

        'invoice_table' => [
            'specification'     => 'Order Specification',
            'measurement'       => 'Measurement',
            'amount'            => 'Amount',
            'cost'              => 'Cost',
        ],

        'sidebar' => [
            'balance'            => 'Balance',
            'new_orders'         => 'New Orders',
            'in_progress_orders' => 'Orders in Work',
            'completed_orders'   => 'Сompleted Orders',
            'delivered_orders'   => 'Delivered Orders',
            'paid_orders'        => 'Paid Orders',
            'unpaid_orders'      => 'Unpaid Orders',
            'your_manager'       => 'Your Manager',
            'email'              => 'E-mail:',
            'mobile_phone'       => 'Mobile:',
            'phone'              => 'Phone:',
        ],
    ],

    'backend' => [
        'access' => [
            'roles' => [
                'create'     => 'Create Role',
                'edit'       => 'Edit Role',
                'management' => 'Role Management',

                'table' => [
                    'number_of_users' => 'Number of Users',
                    'permissions'     => 'Permissions',
                    'role'            => 'Role',
                    'sort'            => 'Sort',
                    'total'           => 'role total|roles total',
                ],
            ],

            'users' => [
                'active'              => 'Active Users',
                'all_permissions'     => 'All Permissions',
                'change_password'     => 'Change Password',
                'change_password_for' => 'Change Password for :user',
                'create'              => 'Create User',
                'deactivated'         => 'Deactivated Users',
                'deleted'             => 'Deleted Users',
                'edit'                => 'Edit User',
                'management'          => 'User Management',
                'no_permissions'      => 'No Permissions',
                'no_roles'            => 'No Roles to set.',
                'permissions'         => 'Permissions',
                'user_actions'        => 'User Actions',

                'table' => [
                    'confirmed'      => 'Confirmed',
                    'created'        => 'Created',
                    'email'          => 'E-mail',
                    'id'             => 'ID',
                    'last_updated'   => 'Last Updated',
                    'name'           => 'Name',
                    'first_name'     => 'First Name',
                    'last_name'      => 'Last Name',
                    'no_deactivated' => 'No Deactivated Users',
                    'no_deleted'     => 'No Deleted Users',
                    'other_permissions' => 'Other Permissions',
                    'permissions'    => 'Permissions',
                    'abilities'      => 'Abilities',
                    'roles'          => 'Roles',
                    'social'         => 'Social',
                    'total'          => 'user total|users total',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Overview',
                        'history'  => 'History',
                    ],

                    'content' => [
                        'overview' => [
                            'avatar'       => 'Avatar',
                            'confirmed'    => 'Confirmed',
                            'created_at'   => 'Created At',
                            'deleted_at'   => 'Deleted At',
                            'email'        => 'E-mail',
                            'last_login_at' => 'Last Login At',
                            'last_login_ip' => 'Last Login IP',
                            'last_updated' => 'Last Updated',
                            'name'         => 'Name',
                            'first_name'   => 'First Name',
                            'last_name'    => 'Last Name',
                            'status'       => 'Status',
                            'timezone'     => 'Timezone',
                        ],
                    ],
                ],

                'view' => 'View User',
            ],
        ],

        'material' => [
            'name'      => 'Material Name',
            'reference' => 'Material Specification',
            'price'     => 'Material Price',
            'status'    => 'Availability Status',
        ],

        'print_option' => [
            'euro_currency'     => 'Euro Currency',
            'net_cost'          => 'Net Cost',
            'print_cost_color'  => 'Print cost 4+0 (in euro)',
            'print_cost_bw'     => 'Print cost 1+0 (in euro)',
            'layout_width'      => 'Layout Width',
            'layout_height'     => 'Layout Height',
            'fieldW'            => 'Field Width of Layout',
            'fieldH'            => 'Field Height of Layout',
            'bleed'             => 'Artworks Bleed',
        ],
    ],

    'frontend' => [

        'auth' => [
            'login_box_title'    => 'Login',
            'login_button'       => 'Login',
            'login_with'         => 'Login with :social_media',
            'register_box_title' => 'Register',
            'register_button'    => 'Register',
            'remember_me'        => 'Remember Me',
        ],

        'contact' => [
            'box_title' => 'Contact Us',
            'button' => 'Send Information',
        ],

        'passwords' => [
            'expired_password_box_title' => 'Your password has expired.',
            'forgot_password'                 => 'Forgot Your Password?',
            'reset_password_box_title'        => 'Reset Password',
            'reset_password_button'           => 'Reset Password',
            'update_password_button'           => 'Update Password',
            'send_password_reset_link_button' => 'Send Password Reset Link',
        ],

        'user' => [
            'passwords' => [
                'change' => 'Change Password',
            ],

            'profile' => [
                'avatar'             => 'Avatar',
                'created_at'         => 'Created At',
                'edit_information'   => 'Edit Information',
                'email'              => 'E-mail',
                'last_updated'       => 'Last Updated',
                'name'               => 'Name',
                'first_name'         => 'First Name',
                'last_name'          => 'Last Name',
                'update_information' => 'Update Information',
            ],
        ],

    ],

    'customer' => [
        'order' => [
            'width'             => 'Width (mm)',
            'height'            => 'Height (mm)',
            'term'              => 'Term',
            'date'              => 'Date',
            'price'             => 'Price',
            'choose_a_file'     => 'Choose a file...',
            'delivery_method'   => 'Delivery Method',
        ],

        'profile' => [
            'id'                => 'ID',
            'first_name'        => 'First Name',
            'last_name'         => 'Last Name',
            'email'             => 'E-mail',
            'tel'               => 'Phone',
            'mobile'            => 'Mobile Phone',
            'customer_name'     => 'Customer Name',
            'customer_city'     => 'City',
            'customer_address'  => 'Office Address',
            'credit_limit'      => 'Credit Limit',
        ],
    ],
];
