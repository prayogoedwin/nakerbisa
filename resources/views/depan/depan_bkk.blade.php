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
                <h1>BKK</h1>
                <ul class="breadcrumb">
                    <li><a href="{{ route('beranda') }}"><i class="fas fa-home"></i> Beranda</a></li>
                    <li>BKK</li>
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



                <div class="col-xl-12 col-lg-5 mt-md-120 mt-xs-50 services-sidebar">
                    <!-- Single Widget -->
                    <div class="single-widget services-list-widget">
                        <h4 class="widget-title">Daftar BKK Terfadaftar Seluruh Provinsi Kalimantan Timur</h4>
                        <div class="content">
                            <table class="table">
                                <tr>
                                    <th>No</th>
                                    <th>Nama BKK</th>
                                    <th>Alamat</th>
                                    <th>Jurusan</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>BKK SMK 1 BERAU</td>
                                    <td>Jl. Permai 11 Kabupaten Berap </td>
                                    <td>Teknik Mesin, Teknik Otomotif, Tekniik Kendaraan Ringan</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>BKK SMK 1 SAMARINDA</td>
                                    <td>Jl. Elok 20 Kota Samarinda </td>
                                    <td>Teknik Komputer Jaringan, Rekayasa Perangkat Lunak</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>BKK SMK 1 BALIKPAPAN</td>
                                    <td>Jl. Pahlawan 7 Kota Balikpapan </td>
                                    <td>Desai Grafis</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- End Single Widget -->

                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Services Details Area -->

@include('components.footer')
