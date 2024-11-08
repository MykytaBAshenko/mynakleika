<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Nakleika '.app()->version()),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'https://nakleika.com.ua'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | PHP Locale Code
    |--------------------------------------------------------------------------
    |
    | The PHP locale determines the default locale that will be used
    | by the Carbon library when setting Carbon's localization.
    |
    */
	'locale_php' => env('APP_LOCALE_PHP', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | File config parameters, in kB
    |--------------------------------------------------------------------------
    */

    'max_upload_file_size' => 102400,

    /*
    |--------------------------------------------------------------------------
    | Invoice config parameters
    |--------------------------------------------------------------------------
    */

	'invoice_date_prefix' => 'dmy',

	'invoice_daystart_num' => 50,

	'invoice_prefix' => 'СФ',

    /*
    |--------------------------------------------------------------------------
    | FTP config parameters
    |--------------------------------------------------------------------------
    */

    'ftp_root_directory'            => env('FTP_ROOT_DIRECTORY', '/'),
    'ftp_in_directory'              => env('FTP_IN_DIRECTORY', 'IN'),
    'ftp_out_directory'             => env('FTP_OUT_DIRECTORY', 'OUT'),
    'ftp_imposition_in_directory'   => env('FTP_IMPOSITION_IN_DIRECTORY', 'imp/in'),
    'ftp_imposition_out_directory'  => env('FTP_IMPOSITION_OUT_DIRECTORY', 'imp/out'),
    'ftp_imposition_done_directory' => env('FTP_IMPOSITION_DONE_DIRECTORY', 'imp/done'),
    'ftp_work_directory'            => env('FTP_WORK_DIRECTORY', 'work'),
    'ftp_archive_directory'         => env('FTP_ARCHIVE_DIRECTORY', 'arch'),

    /*
    |--------------------------------------------------------------------------
    | Payment gate parameters
    |--------------------------------------------------------------------------
    */

    'portmone_payee_id'             => env('PORTMONE_PAYEE_ID', 28811),
    'portmone_gateway_url'          => env('PORTMONE_GATEWAY_URL', 'https://www.portmone.com.ua/gateway/'),
    'portmone_success_url'          => env('PORTMONE_SUCCESS_URL', 'https://nakleika.com.ua/customer/finance/payment/success'),
    'portmone_failure_url'          => env('PORTMONE_FAILURE_URL', 'https://nakleika.com.ua/customer/finance/payment/failure'),
    'portmone_encoding'             => env('PORTMONE_ENCODING', 'UTF-8'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers that aren't auto-discover...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BladeServiceProvider::class,
        App\Providers\BroadcastServiceProvider::class,
        App\Providers\ComposerServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\ObserverServiceProvider::class,
		App\Providers\RouteServiceProvider::class,

		Appstract\Options\OptionsServiceProvider::class,
        Barryvdh\DomPDF\ServiceProvider::class,
        Propaganistas\LaravelPhone\PhoneServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
		'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,

        /*
         * Package Aliases
         */
        'Active' => HieuLe\Active\Facades\Active::class,
		'Gravatar' => Creativeorange\Gravatar\Facades\Gravatar::class,
        'Hashids' => Vinkla\Hashids\Facades\Hashids::class,
		'Option' => Appstract\Options\OptionFacade::class,
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,
        'PDF' => Barryvdh\DomPDF\Facade::class,
        'Yaml' => Symfony\Component\Yaml\Yaml::class,
    ],

];
