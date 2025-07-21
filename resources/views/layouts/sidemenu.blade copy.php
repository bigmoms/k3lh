<aside class="page-sidebar">
    <div class="main-sidebar" id="main-sidebar">
        <ul class="sidebar-menu" id="simple-bar">
            <!-- Dashboard -->
            @php
                $dashboardRoutes = [
                    'vendor' => 'vendor.dashboard',
                    'pengawas' => 'pengawas.dashboard',
                    'pemilik_area' => 'pemilik_area.dashboard',
                    'she_officer' => 'she_officer.dashboard',
                    'she_manager' => 'she_manager.dashboard',
                    'admin' => 'admin.dashboard',
                ];

                $userRole = auth()->user()->roles->first()->name;
                $dashboardRoute = $dashboardRoutes[$userRole] ?? 'admin.dashboard';
            @endphp

            <li class="sidebar-list {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route($dashboardRoute) }}">
                    <i class="iconly-Home icli"></i>
                    <h6 class="f-w-600">Dashboard</h6>
                </a>
            </li>

            @if (auth()->user()->hasRole('admin'))
                @php
                    $masterActive =
                        request()->is('admin/vendors*') ||
                        request()->is('admin/users*') ||
                        request()->is('admin/purchase-orders*') ||
                        request()->is('admin/klasifikasi-pekerjaan*');
                @endphp

                <li class="sidebar-list {{ $masterActive ? 'open' : '' }}">
                    <a class="sidebar-link" href="javascript:void(0)">
                        <i class="iconly-Folder icli"></i>
                        <h6 class="f-w-600">Workpermit</h6>
                        <i class="iconly-Arrow-Right-2 icli"></i>
                    </a>
                    <ul class="sidebar-submenu" style="{{ $masterActive ? 'display:block;' : 'display:none;' }}">
                        <li class="{{ request()->is('admin/vendors*') ? 'active' : '' }}">
                            <a class="submenu-title" href="{{ route('admin.vendors.index') }}">Data Vendor</a>
                        </li>
                        <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                            <a class="submenu-title" href="{{ route('admin.users.index') }}">Data User</a>
                        </li>
                        <li class="{{ request()->is('admin/purchase-orders*') ? 'active' : '' }}">
                            <a class="submenu-title" href="{{ route('purchasing.po.index') }}">Data Pekerjaan</a>
                        </li>
                        <li class="{{ request()->is('admin/klasifikasi-pekerjaan*') ? 'active' : '' }}">
                            <a class="submenu-title" href="{{ route('admin.klasifikasi.index') }}">Data Klasifikasi
                                Pekerjaan</a>
                        </li>
                        <li class="{{ request()->is('admin/menus*') ? 'active' : '' }}">
                            <a class="submenu-title" href="{{ route('admin.menus.index') }}">Data Menu</a>
                        </li>
                        <li class="{{ request()->is('admin/roles*') ? 'active' : '' }}">
                            <a class="submenu-title" href="{{ route('admin.roles.index') }}">Roles</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (auth()->user()->hasRole('vendor'))
                <li class="sidebar-list {{ request()->is('vendor/po*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('vendor.po.index') }}">
                        <i class="iconly-Activity icli"></i>
                        <h6 class="f-w-600">Work Permit</h6>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasRole('pengawas'))
                <li class="sidebar-list {{ request()->is('pengawas/po*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('pengawas.po.index') }}">
                        <i class="iconly-Activity icli"></i>
                        <h6 class="f-w-600">Work Permit</h6>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasRole('pemilik_area'))
                <li class="sidebar-list {{ request()->is('pemilik_area/po*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('pemilik_area.po.index') }}">
                        <i class="iconly-Activity icli"></i>
                        <h6 class="f-w-600">Work Permit</h6>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasRole('she_officer'))
                <li class="sidebar-list {{ request()->is('she_officer/po*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('she_officer.po.index') }}">
                        <i class="iconly-Activity icli"></i>
                        <h6 class="f-w-600">Work Permit</h6>
                    </a>
                </li>
            @endif


            @if (auth()->user()->hasRole('she_manager'))
                <li class="sidebar-list {{ request()->is('she_manager/po*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('she_manager.po.index') }}">
                        <i class="iconly-Activity icli"></i>
                        <h6 class="f-w-600">Work Permit</h6>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>
