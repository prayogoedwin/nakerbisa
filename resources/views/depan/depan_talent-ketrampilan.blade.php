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
                <h1>Keterampilan</h1>
                <ul class="breadcrumb">
                    <li><a href="{{ route('beranda') }}"><i class="fas fa-home"></i> Beranda</a></li>
                    <li>Keterampilan</li>
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
                    <!-- Single Widget -->
                    <div class="single-widget services-list-widget">
                        <h4 class="widget-title">100 Ketrampilan Terbaru di Miliki oleh Tenaga Kerja di Kabupaten Rembang</h4>
                        <div class="content">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Keahlian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($ketrampilan as $index => $item)
                                        <tr>
                                            <td>{{ $ketrampilan->firstItem() + $index }}</td>
                                            <td>{{ $item->keahlian ?? '-' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Data tidak tersedia</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $ketrampilan->links('pagination::bootstrap-5') }}
                            </div>
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
