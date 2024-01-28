<header class="app-header navbar navbar-expand-lg">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="{{ asset('img/backend/brand/logo.svg') }}" width="89" height="25" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="{{ asset('img/backend/brand/sygnet.svg') }}" width="30" height="30" alt="CoreUI Logo">
    </a>
    
    <button class="sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>

    <button class="btn d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-align-justify" aria-hidden="true"></i>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent"> 

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
