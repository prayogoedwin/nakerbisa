<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/nakerbisa_be/img/nakerbisa-rembang.png') }}" width="200px">
            </span>
            <!-- <span class="app-brand-text demo menu-text fw-bolder ms-2">NAKERBISA</span> -->
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
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        <li class="menu-item {{ request()->routeIs('lowongan.*') || request()->routeIs('penempatan') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Layouts">Lowongan Kerja</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('lowongan.index') ? 'active' : '' }}">
                    <a href="{{ route('lowongan.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Lowongan Kerja</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">History Loker</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('penempatan') ? 'active' : '' }}">
                    <a href="{{ route('penempatan') }}" class="menu-link">
                        <div data-i18n="Without navbar">Penempatan</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
