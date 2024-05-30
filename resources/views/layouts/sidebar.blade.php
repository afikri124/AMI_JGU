<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme no-print">
    <div class="app-brand demo ">
        <a href="{{ route('index') }}" class="app-brand-link">
            <span class="app-brand-logo demo" style="margin-left: -10px">
                <img src="{{asset('assets/img/CIS.png')}}" height="100" >
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto bg-dark">
            <i class="bx bx-transfer-alt bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Main Menu</span>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'audit_plan' ? 'active' : '' }}">
            <a href="{{ route('audit_plan.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Dashboards">Audit Plans</div>
            </a>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'audit_status' ? 'active' : '' }}">
            <a href="{{ route('audit_status.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div data-i18n="Dashboards">Observation</div>
            </a>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'notif_audit' ? 'active' : '' }}">
            <a href="{{ route('notification.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-clipboard"></i>
                <div data-i18n="Dashboards">History</div>
            </a>
        </li>

        @can('control panel.read')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Control Panel</span>
        </li>
        @endcan
        @can('setting.read')
        <li class="menu-item {{ request()->segment(1) == 'setting' ? 'open active' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div>Settings</div>
            </a>
            <ul class="menu-sub">
                @can('setting/manage_account.read')
                <li class="menu-item {{ request()->segment(2) == 'manage_account' ? 'open active' : '' }}">
                    <a href="" class="menu-link menu-toggle">
                        <div>Manage Account</div>
                    </a>
                    <ul class="menu-sub">
                        @can('setting/manage_account/users.read')
                        <li class="menu-item {{ request()->segment(3) == 'users' ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}" class="menu-link">
                                <div>Users</div>
                            </a>
                        </li>
                        @endcan
                        @can('setting/manage_account/roles.read')
                        <li class="menu-item {{ request()->segment(3) == 'roles' ? 'active' : '' }}">
                            <a href="{{ route('roles.index') }}" class="menu-link">
                                <div>Roles</div>
                            </a>
                        </li>
                        @endcan
                        @can('setting/manage_account/permissions.read')
                        <li class="menu-item {{ request()->segment(3) == 'permissions' ? 'active' : '' }}">
                            <a href="{{ route('permissions.index') }}" class="menu-link">
                                <div>Permissions</div>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                <li class="menu-item {{ request()->segment(2) == 'standard_audit' ? 'active' : '' }}">
                    <a href="" class="menu-link  menu-toggle">
                        <div>Manage Standard</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->segment(3) == 'standard' ? 'active' : '' }}">
                            <a href="{{ route('standard_audit.index') }}" class="menu-link">
                                <div>Standard Audit</div>
                            </a>
                        </li>
                    </ul>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->segment(3) == 'standard' ? 'active' : '' }}">
                            <a href="{{ route('departement.index') }}" class="menu-link">
                                <div>Departement</div>
                            </a>
                        </li>_
                    </ul>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
    </ul>
</aside>
<!-- / Menu -->
