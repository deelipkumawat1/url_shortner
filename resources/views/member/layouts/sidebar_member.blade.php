<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('s_admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Url Shortner</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> --}}

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('member.dashboard') }}" class="nav-link{{ request()->routeIs('member.dashboard') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboad
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('member-url.create') }}" class="nav-link{{ request()->routeIs('member-url.create') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-link"></i>
                        <p>
                            Short Url
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ route('user-product.index') }}" class="nav-link{{ Request::is('user/product*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Product
                        </p>
                    </a>
                </li>

                <li class="nav-item{{ Request::is(['user/group-master*', 'user/account-master*', 'user/pos*']) ? ' menu-is-opening menu-open' : '' }}">
                    <a href="javascript:void(0);" class="nav-link{{ Request::is(['user/group-master*', 'user/account-master*', 'user/pos*']) ? ' active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Sales Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user-group-master.index') }}" class="nav-link {{ request()->routeIs('user-group-master.index') || Request::is(['user/group-master/*']) ? ' active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Group Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user-account-master.index') }}" class="nav-link {{ request()->routeIs('user-account-master.index') || Request::is(['user/account-master/*']) ? ' active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Account Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user-pos.index') }}" class="nav-link {{ request()->routeIs('user-pos.index') || Request::is(['user/pos/*']) ? ' active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pos window</p>
                            </a>
                        </li>

                    </ul>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
