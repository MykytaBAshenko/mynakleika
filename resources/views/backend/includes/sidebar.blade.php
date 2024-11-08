<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon icon-speedometer"></i> @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            {{-- App Options submenu --}}

            <li class="nav-title">
                @lang('menus.backend.sidebar.app')
            </li>

            <li class="nav-item ">
               <a class="nav-link {{ active_class(Active::checkUriPattern('admin/material')) }}" href="{{ route('admin.material.index') }}">
                    <i class="nav-icon icon-tag"></i> @lang('menus.backend.material')
                </a>
            </li>

            {{-- <li class="nav-item">
               <a class="nav-link {{ active_class(Active::checkUriPattern('admin/option/print')) }}" href="{{ route('admin.option.print') }}">
                    <i class="nav-icon icon-printer"></i> @lang('menus.backend.options.print_options')
                </a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/option/cost')) }}" href="{{ route('admin.option.cost') }}">
                    <i class="nav-icon icon-printer"></i> @lang('menus.backend.options.cost_options')
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/option/self_legal_entities')) }}" href="{{ route('admin.option.self-legal-entities') }}">
                    <i class="nav-icon icon-printer"></i> @lang('menus.backend.options.self_legal_entities')
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/payers')) }}" href="{{ route('admin.payers') }}">
                    <i class="nav-icon icon-printer"></i> @lang('menus.backend.options.payers')
                </a>
            </li>

            {{-- End App Options submenu --}}

            <li class="nav-title">
                @lang('menus.backend.sidebar.system')
            </li>

            @if ($logged_in_user->isAdmin())
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}" href="#">
                        <i class="nav-icon icon-user"></i> @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="divider"></li>

            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}" href="#">
                    <i class="nav-icon icon-list"></i> @lang('menus.backend.log-viewer.main')
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}" href="{{ route('log-viewer::dashboard') }}">
                            @lang('menus.backend.log-viewer.dashboard')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}" href="{{ route('log-viewer::logs.list') }}">
                            @lang('menus.backend.log-viewer.logs')
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
