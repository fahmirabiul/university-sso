<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">SSO</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Beranda</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Manajemen Sistem</span>
        </li>
        
        <!-- OAuth Clients -->
        <li class="menu-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
            <a href="{{ route('clients.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-server"></i>
                <div>Aplikasi Klien</div>
            </a>
        </li>

        <!-- Users -->
        <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Pengguna</div>
            </a>
        </li>

        <!-- Roles -->
        <li class="menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <a href="{{ route('roles.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                <div>Peran Akses</div>
            </a>
        </li>
    </ul>
</aside>
