@extends('backend.template.backend')

@section('content')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-lg-12 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-7">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">Selamat Datang Admin! 🎉</h5>
                                                <p class="mb-4">
                                                    Ada setidaknya <span class="fw-bold">72</span> lowongan baru belum di
                                                    verifikasi hari ini. Mohon segera diverifikasi agar dapat segera
                                                    terlihat disisi pencari kerja.
                                                </p>

                                                <a href="javascript:;" class="btn btn-sm btn-outline-primary">Verifikasi
                                                    Sekarang</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-5 text-center text-sm-left">
                                            <div class="card-body pb-0 px-0 px-md-4">
                                                <!-- <img
                                                                      src="../assets/img/illustrations/man-with-laptop-light.png"
                                                                      height="140"
                                                                      alt="View Badge User"
                                                                      data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                                                      data-app-light-img="illustrations/man-with-laptop-light.png"
                                                                    /> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-4 order-1">
                                <div class="row">

                                    <div class="col-lg-3 col-md-12 col-4 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title d-flex align-items-start justify-content-between">
                                                    <div class="avatar flex-shrink-0">
                                                        <img src="{{ asset('assets/nakerbisa_be/img/icons/unicons/chart-success.png') }}"
                                                            alt="chart success" class="rounded" />
                                                    </div>
                                                </div>
                                                <span class="fw-semibold d-block mb-1">Tenaga Kerja</span>
                                                <h3 class="card-title mb-2">{{ $pencariKerjaCount }}</h3>
                                                <!-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12 col-4 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title d-flex align-items-start justify-content-between">
                                                    <div class="avatar flex-shrink-0">
                                                        <img src="{{ asset('assets/nakerbisa_be/img/icons/unicons/chart-success.png') }}"
                                                            alt="chart success" class="rounded" />
                                                    </div>
                                                </div>
                                                <span class="fw-semibold d-block mb-1">Penyedia Kerja</span>
                                                <h3 class="card-title mb-2">{{ $penyediaKerjaCount }}</h3>
                                                <!-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12 col-4 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title d-flex align-items-start justify-content-between">
                                                    <div class="avatar flex-shrink-0">
                                                        <img src="{{ asset('assets/nakerbisa_be/img/icons/unicons/chart-success.png') }}"
                                                            alt="chart success" class="rounded" />
                                                    </div>
                                                </div>
                                                <span class="fw-semibold d-block mb-1">Lowongan Aktif</span>
                                                <h3 class="card-title mb-2">{{ $lowonganAktifCount }}</h3>
                                                <!-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12 col-4 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title d-flex align-items-start justify-content-between">
                                                    <div class="avatar flex-shrink-0">
                                                        <img src="{{ asset('assets/nakerbisa_be/img/icons/unicons/chart-success.png') }}"
                                                            alt="chart success" class="rounded" />
                                                    </div>
                                                </div>
                                                <span class="fw-semibold d-block mb-1">Lamaran Dalam Proses</span>
                                                <h3 class="card-title mb-2">{{ $lamaranDalamProsesCount }}</h3>
                                                <!-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small> -->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
@endsection
