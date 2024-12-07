@include('components.header')
<!-- Start Breadcrumb
    ============================================= -->
<div class="breadcrumb-area text-left">
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
<div class="home-blog-area default-padding-bottom">
    <!-- tampilan detail berita -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="single-post">
                    <div class="info">
                        <h4>{{ $lowongan->judul_lowongan }}</h4>
                        <p class="meta">
                            <span><i class="fas fa-map-marker-alt"></i> {{ $kabkota->name }}</span><br>
                            <span><i class="fas fa-calendar"></i> Dibuka:
                                {{ \Carbon\Carbon::parse($lowongan->tanggal_start)->locale('id')->translatedFormat('d F Y') }}</span><br>
                            <span><i class="fas fa-calendar"></i> Ditutup:
                                {{ \Carbon\Carbon::parse($lowongan->tanggal_end)->locale('id')->translatedFormat('d F Y') }}</span>
                        </p>
                        <div class="content">
                            <p><strong>Lokasi Penempatan: </strong>{{ $lowongan->lokasi_penempatan_text }}</p>
                            <p><strong>Jabatan: </strong>{{ $jabatan->nama }}</p>
                            <p><strong>Sektor: </strong>{{ $sektor->name }}</p>
                            <p><strong>Deskripsi Pekerjaan:</strong></p>
                            <p>{{ $lowongan->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Blog  -->

@include('components.footer')
