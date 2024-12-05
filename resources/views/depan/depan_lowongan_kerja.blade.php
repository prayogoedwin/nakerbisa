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
                <h1>Lowongan Kerja</h1>
                <ul class="breadcrumb">
                    <li><a href="{{ route('beranda') }}"><i class="fas fa-home"></i> Beranda</a></li>
                    <li>Lowongan Kerja</li>
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
        <div class="esitmate-form2 mt-40">
            <form action="{{ route('depan.lowongan-kerja') }}" method="GET">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="name">Judul Lowongan</label>
                            <input class="form-control" id="name" name="judul_lowongan"
                                placeholder="Cari Judul Lowongan Kerja" type="text">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="pendidikan_id">Pendidikan</label>
                            <select id="pendidikan_id" name="pendidikan_id" class="form-control">
                                <option value="">Pilih Pendidikan</option>
                                <option value="1">SD</option>
                                <option value="2">SMP</option>
                                <option value="3">SMA / SMK</option>
                                <option value="4">D1</option>
                                <option value="5">D2</option>
                                <option value="6">D3</option>
                                <option value="7">D4</option>
                                <option value="8">S1</option>
                                <option value="9">S2</option>
                                <option value="10">S3</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="kabkota_id">Lokasi Perusahaan</label>
                            <select id="kabkota_id" name="kabkota_id" class="form-control">
                                <option value="">Pilih Lokasi</option>
                                <option value="1">Kabupaten Berau</option>
                                <option value="2">Kabupaten Kutai Barat</option>
                                <option value="3">Kabupaten Kutai Kartanegara</option>
                                <option value="4">Kabupaten Kutai Timur</option>
                                <option value="5">Kabupaten Mahakam Ulu</option>
                                <option value="6">Kabupaten Paser</option>
                                <option value="7">Kabupaten Penajam Paser Utara</option>
                                <option value="8">Kota Balikpapan</option>
                                <option value="9">Kota Bontang</option>
                                <option value="10">Kota Samarinda</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-success">
                            Cari Lowongan Kerja
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="blog-item-box">
            <div class="row">
                @forelse ($lowonganDisetujui as $lowongan)
                    <div class="col-xl-4 col-md-6 single-item">
                        <div class="blog-style-one">
                            <div class="thumb">
                                <a href="#">
                                    <img src="{{ asset('assets/nakerbisa_fe/img/800x600.png') }}" alt="Thumb">

                                </a>
                            </div>
                            <div class="info">
                                <div class="blog-meta">
                                    <ul>
                                        <li class="sub-title">Perusahaan</li>
                                    </ul>
                                    <ul>
                                        <li>Expire in:
                                            {{ \Carbon\Carbon::parse($lowongan->tanggal_end)->format('d F, Y') }}</li>
                                    </ul>
                                </div>
                                <h3>
                                    <a href="{{ route('lowongan.show', $lowongan->id) }}">{{ $lowongan->judul_lowongan }}</a>
                                </h3>
                                <a href="{{ route('lowongan.show', $lowongan->id) }}" class="btn-simple"><i class="fas fa-angle-right"></i> Read more</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Tidak ada lowongan yang sesuai dengan pencarian.</p>
                    </div>
                @endforelse
            </div>
            <div class="pagination justify-content-center">
                {{ $lowonganDisetujui->links('pagination::bootstrap-4') }}
            </div>
        </div>
        <!-- End Pagination -->
    </div>
</div>
<!-- End Blog -->

@include('components.footer')
