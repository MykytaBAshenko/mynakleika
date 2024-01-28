<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Alert Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain alert messages for various scenarios
    | during CRUD operations. You are free to modify these language lines
    | according to your application's requirements.
    |
    */

    'backend' => [
        'roles' => [
            'created' => 'The role was successfully created.',
            'deleted' => 'The role was successfully deleted.',
            'updated' => 'The role was successfully updated.',
        ],

        'users' => [
            'cant_resend_confirmation' => 'The application is currently set to manually approve users.',
            'confirmation_email'  => 'A new confirmation e-mail has been sent to the address on file.',
            'confirmed'              => 'The user was successfully confirmed.',
            'created'             => 'The user was successfully created.',
            'deleted'             => 'The user was successfully deleted.',
            'deleted_permanently' => 'The user was deleted permanently.',
            'restored'            => 'The user was successfully restored.',
            'session_cleared'      => "The user's session was successfully cleared.",
            'social_deleted' => 'Social Account Successfully Removed',
            'unconfirmed' => 'The user was successfully un-confirmed',
            'updated'             => 'The user was successfully updated.',
            'updated_password'    => "The user's password was successfully updated.",
        ],

        'material' => [
            'created' => 'New material was successfully created.',
            'updated' => 'Material was successfully updated.',
            'deleted' => 'Material was successfully deleted.',
        ],

        'options' => [
            'updated'     => 'Options was successfully updated.',
            'not_updated' => 'Something went wrong.',
        ],
    ],

    'frontend' => [
        'contact' => [
            'sent' => 'Your information was successfully sent. We will respond back to the e-mail provided as soon as we can.',
        ],
        'order' => [
            'created' => 'The order has been successfully created. It remains to register, after which you can make a payment in the user\'s account and the work will be sent to production.',
        ]
    ],

    'customer' => [
        'created'               => 'Order was successfully added.',
        'deleted'               => 'Order was successfully deleted.',
        'uploaded'              => 'File was successfully uploaded.',
        'error'                 => 'Error',
        'errors'                => 'Errors',
        'process_success'       => 'File processed successfully',
        'process_warning'       => 'ATTENTION: there are comments on the work! The work can be made, but the following may affect the quality. Correct the file and upload a new one, otherwise, saving the work, you will instruct to ignore the following: ',
        'process_error'         => 'Errors while processing file',
        'processing_timeout'    => 'Processing timeout',
        'file_load_error'       => 'Error while uploading file',
        'ftp_connection_error'  => 'File server temporary not available',
    ],

    'payments' => [
        'created' => 'Payment successfully created',
        'error'   => 'Error while payment',
    ],

    'pitstop' => [
        'errors' => [
            'width'  => 'Layout exceeds maximum width ',
            'height' => 'Layout exceeds maximum height ',
        ],
    ],
];
