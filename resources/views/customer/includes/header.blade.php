<header class="app-header navbar navbar-expand-lg">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="{{ route(home_route()) }}">
        <img class="navbar-brand-full" src="{{ asset('img/backend/brand/logo.svg') }}" width="100" height="30" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="{{ asset('img/backend/brand/sygnet.svg') }}" width="30" height="30" alt="CoreUI Logo">
    </a>

    <button class="sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>

    <button class="btn d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-align-justify" aria-hidden="true"></i>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">

        <ul class="user-menu navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkRoute('customer.dashboard')) }}" href="{{ route('customer.dashboard') }}">
                    <span class="material-icons-outlined">layers</span>{{ __('menus.customer.header.orders') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                    {{ active_class(Active::checkRoute('customer.profile.edit')) }}
                    {{ active_class(Active::checkRoute('customer.deliveries')) }}
                    {{ active_class(Active::checkRoute('customer.legal_entities')) }}"
                    href="{{ route('customer.profile.edit') }}"
                >
                    <span class="material-icons-outlined">manage_accounts</span>{{ __('menus.customer.header.profile') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('customer/finance/*')) }}"
                   href="{{ route('customer.finance.payments') }}">
                    <span class="material-icons-outlined">account_balance_wallet</span>{{ __('menus.customer.header.finance') }}
                </a>
            </li>
            <li class="nav-item dropdown {{ active_class(Active::checkUriPattern('technotes/*')) }}">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="material-icons-outlined">help_outline</span>Помощь
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/technotes/">
                        <span class="material-icons-outlined">picture_as_pdf</span>Требования к макетам
                    </a>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            @if (config('locale.status') && count(config('locale.languages')) > 1)
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownLanguageLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('menus.language-picker.language') }} ({{ strtoupper(app()->getLocale()) }})
                </a>
                @include('includes.partials.lang')
            </li>
            @endif

            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $logged_in_user->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuUser">
                    <a href="{{ route('frontend.auth.logout') }}" class="dropdown-item">{{ __('navs.general.logout') }}</a>
                </div>
            </li>
        </ul>
    </div>
</header>
