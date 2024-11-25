<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Consua - Consulting Business Template">

    <!-- ========== Page Title ========== -->
    <title>Nakerbisa - Tenaga Kerja Rembang Berani Inovatif Santun dan Akuntabel</title>

    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="{{ asset('assets/nakerbisa_fe/img/self/icon-nakerbisa.png') }}" type="image/x-icon">

    <!-- ========== Start Stylesheet ========== -->
    <link href="{{ asset('assets/nakerbisa_fe/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/nakerbisa_fe/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/nakerbisa_fe/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/nakerbisa_fe/css/elegant-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/nakerbisa_fe/css/flaticon-set.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/nakerbisa_fe/css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/nakerbisa_fe/css/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/nakerbisa_fe/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/nakerbisa_fe/css/validnavs.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/nakerbisa_fe/css/helper.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/nakerbisa_fe/css/unit-test.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/nakerbisa_fe/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/nakerbisa_fe/style.css') }}" rel="stylesheet">
    <!-- ========== End Stylesheet ========== -->

</head>

<body>

    <!-- Start Preloader
    ============================================= -->
    <div id="preloader">
        <div id="consua-preloader" class="consua-preloader secondary">
            <div class="animation-preloader">
                <div class="spinner"></div>
                <div class="txt-loading">
                    <span data-text-preloader="N" class="letters-loading">
                        N
                    </span>
                    <span data-text-preloader="A" class="letters-loading">
                        A
                    </span>
                    <span data-text-preloader="K" class="letters-loading">
                        K
                    </span>
                    <span data-text-preloader="R" class="letters-loading">
                        R
                    </span>
                    <span data-text-preloader="B" class="letters-loading">
                        B
                    </span>
                    <span data-text-preloader="I" class="letters-loading">
                        I
                    </span>
                    <span data-text-preloader="S" class="letters-loading">
                        S
                    </span>
                    <span data-text-preloader="A" class="letters-loading">
                        A
                    </span>
                </div>
            </div>
            <div class="loader">
                <div class="row">
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Preloader -->


    <!-- Header
    ============================================= -->
    <header>
        <!-- Start Navigation -->
        <nav
            class="navbar secondary mobile-sidenav navbar-sticky navbar-default validnavs navbar-fixed white no-background">

            <div class="container d-flex justify-content-between align-items-center">


                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <!-- Logo khusus hanya untuk halaman index -->
                        <img src="{{ asset('assets/nakerbisa_fe/img/self/nakerbisa_white.png') }}"class="logo logo-display"
                            alt="Logo">
                        <img src="{{ asset('assets/nakerbisa_fe/img/self/nakerbisa-rembang.png') }}"
                            class="logo logo-scrolled" alt="Logo">

                    </a>

                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">

                    <div class="collapse-header">
                        <img src="{{ asset('assets/nakerbisa_fe/img/logo.png') }}" alt="Logo">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>

                    <ul class="nav navbar-nav navbar-center" data-in="fadeInDown" data-out="fadeOutUp">

                        <li><a href="{{ url('/') }}">Beranda</a></li>


                        <!-- <li class="dropdown">
                            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" >Home</a>
                            <ul class="dropdown-menu">
                                <li><a href="index.html">Consulting Business</a></li>
                                <li><li><a href="index-2.html">Corporate Business</a></li>
                                <li><li><a href="marketing-agency.html">Marketing Agency</a></li>
                                <li><li><a href="insurance.html">Insurance</a></li>
                                <li><li><a href="solar-energy.html">Solar Energy</a></li>
                                <li><li><a href="software-landing.html">Software Landing</a></li>
                            </ul>
                        </li> -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Karir</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/depan/lowongan-kerja') }}">Lowongan Kerja</a></li>
                                <li><a href="{{ url('/depan/lowongan-kerja-ema') }}">Lowongan Emakaryo</a></li>
                                <li><a href="https://karirhub.kemnaker.go.id/">Lowongan Karirhub</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Talent</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/depan/bkk') }}">Wilayah</a></li>
                                <li><a href="{{ url('/depan/blk') }}">Tempat Kerja</a></li>
                                <li><a href="{{ url('/depan/blk') }}">Pendidikan</a></li>
                                <li><a href="{{ url('/depan/blk') }}">Ketrampilan</a></li>
                                
                            </ul>
                        </li>

                        <!-- <li><a href="bkk.html">BKK</a></li> -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Skill</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/depan/bkk') }}">BKK</a></li>
                                <li><a href="{{ url('/depan/blk') }}">BLK/BLKK/LPK/LPKS</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Informasi</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/depan/infografis') }}">Infografis</a></li>
                                <li><a href="{{ url('/depan/galeri') }}">Galeri</a></li>
                                <li><a href="{{ url('/depan/berita') }}">Pengumuman</a></li>
                                <li><a href="{{ url('/depan/berita') }}">Ketentuan</a></li>
                                <!-- <li><a href="kontak.html">Kontak</a></li> -->
                            </ul>
                        </li>

                        <li><a href="{{ url('/login') }}">Login</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->

                <div class="attr-right">
                    <!-- Start Atribute Navigation -->
                    <div class="attr-nav">
                        <ul>
                            <li class="button light">
                                <a href="#" onclick="askRoleRegister()">Daftar Sekarang</a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Atribute Navigation -->
                </div>

            </div>
            <!-- Overlay screen for menu -->
            <div class="overlay-screen"></div>
            <!-- End Overlay screen for menu -->
        </nav>
        <!-- End Navigation -->
    </header>
    <!-- End Header -->
