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
                        <h4 class="widget-title">Daftar BKK Terdaftar Seluruh Provinsi Kalimantan Timur</h4>
                        <div class="content">
                            @php
                                $jenisBkkMapping = [
                                    'bumd' => 'Badan Usaha Milik Daerah',
                                    'bumn' => 'Badan Usaha Milik Negara',
                                    'cv' => 'Comanditer Venotschaap',
                                    'firma' => 'Firma',
                                    'instansi' => 'Instansi',
                                    'kp' => 'Koperasi',
                                    'pt' => 'Perseroan Terbatas',
                                    'pp' => 'Perusahaan Perorangan',
                                    'po' => 'PO*',
                                    'yayasan' => 'Yayasan',
                                ];
                            @endphp
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama BKK</th>
                                            <th>Penyedia Loker Luar Negeri</th>
                                            <th>Deskripsi</th>
                                            <th>Jenis BKK</th>
                                            <th>NIB</th>
                                            <th>Alamat</th>
                                            <th>Sektor</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Kecamatan</th>
                                            <th>Desa</th>
                                            <th>Jabatan</th>
                                            <th>Website</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($bkkList as $index => $bkk)
                                            <tr>
                                                <td>{{ $bkkList->firstItem() + $index }}</td>
                                                <td>{{ $bkk->name }}</td>
                                                <td>{{ $bkk->luar_negri == 1 ? 'Ya' : 'Tidak' }}</td>
                                                <td>{{ $bkk->deskripsi }}</td>
                                                <td>{{ $jenisBkkMapping[$bkk->jenis_bkk] ?? 'Tidak Diketahui' }}</td>
                                                <td>{{ $bkk->nib }}</td>
                                                <td>{{ $bkk->alamat }}</td>
                                                <td>{{ $bkk->sektor_name }}</td>
                                                <td>{{ $bkk->kabkota_name }}</td>
                                                <td>{{ $bkk->kec_name }}</td>
                                                <td>{{ $bkk->desa_name }}</td>
                                                <td>{{ $bkk->jabatan }}</td>
                                                <td>{{ $bkk->website }}</td>
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
                                {{ $bkkList->links('pagination::bootstrap-5') }}
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
