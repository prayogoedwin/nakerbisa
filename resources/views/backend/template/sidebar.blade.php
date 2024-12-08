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

        <li class="menu-item {{ request()->routeIs('statistik') ? 'active' : '' }}">
            <a href="{{ route('statistik') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-pie-chart"></i>
                <div data-i18n="Analytics">Statistik</div>
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
                {{-- <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without menu">Banner</div>
                    </a>
                </li> --}}
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
        <li class="menu-item {{ request()->routeIs('admin.*') || request()->routeIs('userpencari.*') || request()->routeIs('userpenyedia.*') || request()->routeIs('userbkk.*') || request()->routeIs('userblk.*') ? 'active open' : '' }}">
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
                {{-- <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">Officers</div>
                    </a>
                </li> --}}
                <li class="menu-item {{ request()->routeIs('userpenyedia.index') ? 'active' : '' }}">
                    <a href="{{ route('userpenyedia.index') }}" class="menu-link" class="menu-link">
                        <div data-i18n="Without navbar">Perusahaan</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('userpencari.index') ? 'active' : '' }}">
                    <a href="{{ route('userpencari.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Pencari Kerja</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('userbkk.index') ? 'active' : '' }}">
                    <a href="{{ route('userbkk.index') }}" class="menu-link" class="menu-link">
                        <div data-i18n="Without navbar">Bkk</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('userblk.index') ? 'active' : '' }}">
                    <a href="{{ route('userblk.index') }}" class="menu-link" class="menu-link">
                        <div data-i18n="Without navbar">Blk</div>
                    </a>
                </li>
                <!-- <li class="menu-item">
            <a href="#" class="menu-link">
              <div data-i18n="Without navbar">BKK</div>
            </a>
          </li> -->

            </ul>
        </li>

        <li class="menu-item {{ request()->routeIs('data.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div data-i18n="Data">Data</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('data.pencari') ? 'active' : '' }}">
                    <a href="{{ route('data.pencari') }}" class="menu-link">
                        <div data-i18n="Without menu">Pencari</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('data.penyedia') ? 'active' : '' }}">
                    <a href="{{ route('data.penyedia') }}" class="menu-link">
                        <div data-i18n="Without menu">Penyedia</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('data.bkk') ? 'active' : '' }}">
                    <a href="{{ route('data.bkk') }}" class="menu-link">
                        <div data-i18n="Without menu">BKK</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('data.blk') ? 'active' : '' }}">
                    <a href="{{ route('data.blk') }}" class="menu-link">
                        <div data-i18n="Without menu">BLK/BLKK/LPK/LPKS</div>
                    </a>
                </li>
            </ul>
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

                <li class="menu-item {{ request()->routeIs('lowongan.history') ? 'active' : '' }}">
                    <a href="{{ route('lowongan.history') }}" class="menu-link">
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


        <!-- Layouts -->
        <li class="menu-item {{ request()->routeIs('ak1.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Layouts">AK1</div>
            </a>

            <ul class="menu-sub">
                <!-- Trigger Menu Item -->
                <li
                    class="menu-item {{ request()->routeIs('ak1.existing') || request()->routeIs('ak1.new') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link" data-bs-toggle="modal"
                        data-bs-target="#ak1Modal">
                        <div data-i18n="Without menu">Cetak AK1</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('ak1.data') ? 'active' : '' }}">
                    <a href="{{ route('ak1.data') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-file"></i>
                        <div data-i18n="Data AK1">Data AK1</div>
                    </a>
                </li>

            </ul>
        </li>

        <!-- Layouts -->
        <li  class="menu-item {{ request()->routeIs('rekap.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-copy"></i>
                <div data-i18n="Layouts">Rekap</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('rekap.tenaga-kerja.index') ? 'active' : '' }}">
                    <a href="{{ route('rekap.tenaga-kerja.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Tenaga Kerja</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">Penyedia</div>
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
                
            </ul>
        </li>
    </ul>
</aside>
<!-- / Menu -->
