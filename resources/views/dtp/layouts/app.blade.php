<!DOCTYPE html>
    <html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description')">
    @yield('meta')

    {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
    @stack('before-styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet">
    {{ style(mix('css/coreui.css')) }}
    {{ style(mix('css/backend.css')) }}

    @stack('after-styles')
</head>

<body class="{{ config('backend.body_classes') }}">
    @include('dtp.includes.header')

    <div id="app" class="app-body">

        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="content-header">
                    @yield('page-header')
                </div><!--content-header-->

                @include('includes.partials.messages')
                @yield('content')
            </div><!--animated-->
        </div><!--container-fluid-->

    </div><!--app-body-->

    <!-- Scripts -->
    @stack('before-scripts')
    @routes
    <script src="/js/lang.js"></script>
    {!! script(mix('js/manifest.js')) !!}
    {!! script(mix('js/vendor.js')) !!}
    {!! script(mix('js/backend.js')) !!}
    {!! script(mix('js/dtp-app.js')) !!}
    @stack('after-scripts')
</body>
</html>
