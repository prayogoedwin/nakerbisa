<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/nakerbisa_be/img/nakerbisa-rembang.png') }}" width="150px">
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
        <li
            class="menu-item {{ request()->routeIs('roles.*') || request()->routeIs('faq.*') || request()->routeIs('infografis.*') || request()->routeIs('galeri.*') || request()->routeIs('berita.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Setting</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Roles</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without menu">Banner</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('infografis.index') ? 'active' : '' }}">
                    <a href="{{ route('infografis.index') }}" class="menu-link">
                        <div data-i18n="Infografis">Infografis</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('galeri.index') ? 'active' : '' }}">
                    <a href="{{ route('galeri.index') }}" class="menu-link">
                        <div data-i18n="galeri">Galeri</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('berita.index') ? 'active' : '' }}">
                    <a href="{{ route('berita.index') }}" class="menu-link">
                        <div data-i18n="berita">Berita</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('faq.index') ? 'active' : '' }}">
                    <a href="{{ route('faq.index') }}" class="menu-link">
                        <div data-i18n="FAQ">FAQ</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Layouts -->
        <li class="menu-item {{ request()->routeIs('admin.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                <div data-i18n="Layouts">Users</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Admins</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">Officers</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">Perusahaan</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">Pencari Kerja</div>
                    </a>
                </li>
                <!-- <li class="menu-item">
            <a href="#" class="menu-link">
              <div data-i18n="Without navbar">BKK</div>
            </a>
          </li> -->

            </ul>
        </li>


        <!-- Layouts -->
        <li class="menu-item {{ request()->routeIs('lowongan.admin.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Layouts">Lowongan Kerja</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('lowongan.admin.index') ? 'active' : '' }}">
                    <a href="{{ route('lowongan.admin.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Lowongan Kerja</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">History Loker</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">Penempatan</div>
                    </a>
                </li>


            </ul>
        </li>


        <!-- Layouts -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Layouts">AK1</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="layouts-without-menu.html" class="menu-link">
                        <div data-i18n="Without menu">Cetak AK1</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-without-navbar.html" class="menu-link">
                        <div data-i18n="Without navbar">Data AK1</div>
                    </a>
                </li>
            </ul>
        </li>


        <!-- Layouts -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-copy"></i>
                <div data-i18n="Layouts">Rekap</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without menu">Pencari Kerja</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">Perusahaan</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">Lowongan Kerja</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">Penempatan</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">BKK</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
<!-- / Menu -->
