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
                <h1>BLK</h1>
                <ul class="breadcrumb">
                    <li><a href="{{ route('beranda') }}"><i class="fas fa-home"></i> Beranda</a></li>
                    <li>BLK</li>
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
                        <h4 class="widget-title">Daftar BLK Terfadaftar Seluruh Provinsi Kalimantan Timur</h4>
                        <div class="content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama BLK</th>
                                            <th>Alamat</th>
                                            <th>Kodepos</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Kecamatan</th>
                                            <th>Desa</th>
                                            <th>No.Telpon</th>
                                            <th>PIC</th>
                                            <th>Jabatan</th>
                                            <th>Website</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($blkList as $index => $blk)
                                            <tr>
                                                <td>{{ $blkList->firstItem() + $index }}</td>
                                                <td>{{ $blk->name }}</td>
                                                <td>{{ $blk->alamat }}</td>
                                                <td>{{ $blk->kodepos }}</td>
                                                <td>{{ $blk->kabkota_name }}</td>
                                                <td>{{ $blk->kec_name }}</td>
                                                <td>{{ $blk->desa_name }}</td>
                                                <td>{{ $blk->telpon }}</td>
                                                <td>{{ $blk->pic }}</td>
                                                <td>{{ $blk->jabatan }}</td>
                                                <td>{{ $blk->website }}</td>
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
                                {{ $blkList->links('pagination::bootstrap-5') }}
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
