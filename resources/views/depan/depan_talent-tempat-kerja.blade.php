@include('components.header')
<!-- Start Breadcrumb
    ============================================= -->
<!-- <div class="breadcrumb-area  text-left" style="background-color: #abe1ff;"> -->
<div class="breadcrumb-area  text-left">
    <div class="breadcrum-shape">
        <!-- <img src="assets/img/shape/50.png" alt="Image Not Found"> -->
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h1>Tempat Kerja</h1>
                <ul class="breadcrumb">
                    <li><a href="{{ route('beranda') }}"><i class="fas fa-home"></i> Beranda</a></li>
                    <li>Tempat Kerja</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Blog
            ============================================= -->
<div class="blog-area blog-grid default-padding-bottom">
    <div class="container">
        <div class="services-details-items">
            <div class="row">
                <div class="col-xl-12 col-lg-12 mt-md-120 mt-xs-50 services-sidebar">
                    <div class="single-widget services-list-widget">
                        <h4 class="widget-title">Rekap Data Tempat Kerja</h4>
                        <div class="request-call-back-area secondary text-light default-padding">
                            <div class="container">
                                <div class="row align-center">
                                    <div class="col-lg-6 text-end">
                                        <div class="achivement-counter">
                                            <ul>
                                                <li>
                                                    <div class="icon">
                                                        <i class="flaticon-group"></i>
                                                    </div>
                                                    <div class="fun-fact">
                                                        <div class="counter">
                                                            <div class="timer" data-to="{{ $luarRembangCount ?? 0 }}"
                                                                data-speed="2000">
                                                                {{ $luarRembangCount ?? 0 }}
                                                            </div>
                                                        </div>
                                                        <span class="medium">Bekerja di Luar Rembang</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <i class="flaticon-group"></i>
                                                    </div>
                                                    <div class="fun-fact">
                                                        <div class="counter">
                                                            <div class="timer" data-to="{{ $dalamRembangCount ?? 0 }}"
                                                                data-speed="2000">
                                                                {{ $dalamRembangCount ?? 0 }}
                                                            </div>
                                                        </div>
                                                        <span class="medium">Bekerja di Rembang</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="widget-title mt-5">Rekap Tempat Kerja Berdasarkan Status Bekerja Tenaga Kerja di Nakerbisa</h4>
                        <div id="bar-chart-tempat-kerja" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Services Details Area -->

@include('components.footer')
