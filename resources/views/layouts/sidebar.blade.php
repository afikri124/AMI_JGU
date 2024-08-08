<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme no-print">
    <div class="app-brand demo ">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo" style="margin-left: -20px">
                <img src="{{asset('assets-landing/img/ami-jgu.png')}}" height="70" >
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
                <i class="menu-icon tf-icons bx bx-home-alt"></i>
                <div data-i18n="Dashboards">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'audit_plan' ? 'active' : '' }}">
            <a href="{{ route('audit_plan.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-edit"></i>
                <div data-i18n="Dashboards">Audit Plan</div>
            </a>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'observations' ? 'active' : '' }}">
            <a href="{{ route('observations.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-search"></i>
                <div data-i18n="Dashboards">Auditing</div>
            </a>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'my_audit' ? 'active' : '' }}">
            <a href="{{ route('my_audit.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div data-i18n="Dashboards">My Audit</div>
            </a>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'rtm' ? 'active' : '' }}">
            <a href="{{ route('rtm.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-bookmark"></i>
                <div data-i18n="Dashboards">RTM</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Approve</span>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'lpm' ? 'active' : '' }}">
            <a href="{{ route('lpm.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-copy-alt"></i>
                <div data-i18n="Dashboards">LPM</div>
            </a>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'approver' ? 'active' : '' }}">
            <a href="{{ route('approver.index') }}" class="menu-link">
                <i class="menu-icon tf-icons  bx bx-message-alt-check"></i>
                <div data-i18n="Dashboards">Wakil Rektor</div>
            </a>
        </li>
        {{-- <li class="menu-item {{ request()->segment(1) == 'notif_audit' ? 'active' : '' }}">
            <a href="" class="menu-link">
                <i class="menu-icon tf-icons bx bx-clipboard"></i>
                <div data-i18n="Dashboards">History</div>
            </a>
        </li> --}}

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
                <li class="menu-item {{ request()->segment(2) == 'manage_standard' ? 'open active' : '' }}">
                    <a href="" class="menu-link  menu-toggle">
                        <div>Manage Standard</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->segment(3) == 'category' ? 'active' : '' }}">
                            <a href="{{ route('standard_category.category') }}" class="menu-link">
                                <div>Standard Category</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->segment(3) == 'criteria' ? 'active' : '' }}">
                            <a href="{{ route('standard_criteria.criteria') }}" class="menu-link">
                                <div>Standard Criterias</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item {{ request()->segment(2) == 'manage_unit' ? 'open active' : '' }}">
                            <a href="" class="menu-link  menu-toggle">
                                <div>Manage Unit</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item {{ request()->segment(3) == 'hod_ami' ? 'active' : '' }}">
                                    <a href="{{ route('hod_ami.index') }}" class="menu-link">
                                        <div>HoD AMI</div>
                                    </a>
                                </li>
                                <!-- <li class="menu-item {{ request()->segment(3) == 'criteria' ? 'active' : '' }}">
                                    <a href="" class="menu-link">
                                        <div>Standard Criterias</div>
                                    </a>
                                </li> -->
                        @endcan
                    </ul>
                </li>
                @endcan
            </ul>
            <li class="menu-item {{ request()->segment(1) == 'documentation' ? 'active' : '' }}">
                <a href="{{route('documentation')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file"></i>
                    <div data-i18n="Documentation">Documentation</div>
                </a>
            </li>
</aside>
<!-- / Menu -->
