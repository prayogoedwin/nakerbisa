<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>NAKERBISA</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="{{ asset('assets/nakerbisa_fe/img/self/icon-nakerbisa.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/nakerbisa_be/vendor/fonts/boxicons.css') }}" />

    <!-- Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/nakerbisa_be/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/nakerbisa_be/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/nakerbisa_be/css/demo.css') }}" />

    <!-- include libraries(jQuery, bootstrap) summernote -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('assets/nakerbisa_be/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }} " />

    <link rel="stylesheet" href="{{ asset('assets/nakerbisa_be/vendor/libs/apex-charts/apex-charts.css') }} " />


    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/nakerbisa_be/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/nakerbisa_be/js/config.js') }}"></script>
    <!-- Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 38px;
            border: 1px solid #d9dee3;
            border-radius: 0.375rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            padding-left: 0.75rem;
            color: #697a8d;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-dropdown {
            z-index: 1090;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<div class="layout-page">
    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <!-- <div class="navbar-nav align-items-center">
                      <div class="nav-item d-flex align-items-center">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input
                          type="text"
                          class="form-control border-0 shadow-none"
                          placeholder="Search..."
                          aria-label="Search..."
                        />
                      </div>
                    </div> -->
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3">
                    <!-- <a
                          class="github-button"
                          href="https://github.com/themeselection/sneat-html-admin-template-free"
                          data-icon="octicon-star"
                          data-size="large"
                          data-show-count="true"
                          aria-label="Star themeselection/sneat-html-admin-template-free on GitHub"
                          >Star</a
                        > -->
                    {{ Auth::check() ? Auth::user()->name : 'Guest' }} |
                    {{ Auth::check() && Auth::user()->roles->isNotEmpty() ? Auth::user()->roles[0]->name : '-' }}

                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            {{-- <img src="{{ asset('assets/nakerbisa_be/img/avatars/1.png') }}" alt
                                class="w-px-40 h-auto rounded-circle" /> --}}
                                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            {{-- <img src="{{ asset('assets/nakerbisa_be/img/avatars/1.png') }}" alt
                                                class="w-px-40 h-auto rounded-circle" /> --}}
                                                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block"> {{ Auth::check() ? Auth::user()->name : 'Guest' }}</span>
                                        <small class="text-muted"> {{ Auth::check() && Auth::user()->roles->isNotEmpty() ? Auth::user()->roles[0]->name : '-' }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        @if (Auth::check() &&
                                (Auth::user()->roles[0]['name'] == 'tenaga-kerja' 
                                || Auth::user()->roles[0]['name'] == 'super-admin' 
                                || Auth::user()->roles[0]['name'] == 'penyedia-kerja'
                                // || Auth::user()->roles[0]['name'] == 'admin-bkk'
                                // || Auth::user()->roles[0]['name'] == 'admin-blk'
                                
                                ))
                            <li>
                                <a class="dropdown-item" href="{{ route('profil.index') }}">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">Profil</span>
                                </a>
                            </li>
                        @endif


                        @if (Auth::check())
                            <li>
                                <a href="{{ route('logout') }}" class="dropdown-item" href="#">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">Log Out</span>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="dropdown-item">
                                    <i class="bx bx-log-in me-2"></i>
                                    <span class="align-middle">Login</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>
    </nav>
</div>


<!-- [ Header ] end -->
