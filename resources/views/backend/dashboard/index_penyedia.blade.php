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
                                        <div class="col-sm-12">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">Selamat Datang! 🎉</h5>
                                                <p class="mb-4">
                                                    Terima kasih sudah menggunakan layanan NAKERBISA KABUPATEN REMBANG.
                                                    Selalu segera update status lamaran yang masuk adalah bentuk dukungan
                                                    kepada kami.
                                                </p>

                                                <a href="{{ route('lowongan.index') }}" class="btn btn-sm btn-outline-primary">Update Lamaran Kerja
                                                    Sekarang</a>
                                                @if (!empty($lastGrupWhatsapp?->link_grup))
                                                    <a href="{{ $lastGrupWhatsapp->link_grup }}" target="_blank"
                                                        class="btn btn-sm btn-success">Gabung Grup WhatsApp</a>
                                                @endif
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
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , made with ❤️ by
                                <a href="https://themeselection.com" target="_blank"
                                    class="footer-link fw-bolder">ThemeSelection</a> & <a href="https://themeselection.com"
                                    target="_blank" class="footer-link fw-bolder">PT Ezra Pratama</a>
                            </div>
                            <div>
                                <a href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                                    target="_blank" class="footer-link me-4">V1</a>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

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
