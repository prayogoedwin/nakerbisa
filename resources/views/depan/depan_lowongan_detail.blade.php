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
    <div class="container mt-5">
        <div class="row">
            <!-- Kolom Detail Lowongan -->
            <div class="col-lg-8">
                <div class="single-post">
                    <!-- Foto Perusahaan -->
                    <div class="post-header">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <!-- Cek apakah foto perusahaan tersedia -->
                                @if ($lowongan->perusahaan_foto)
                                    <img src="{{ asset('storage/' . $lowongan->perusahaan_foto) }}"
                                        alt="Logo Perusahaan" class="img-fluid rounded-circle"
                                        style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('assets/nakerbisa_fe/img/logo-perusahaan.png') }}"
                                        alt="Logo Perusahaan" class="img-fluid rounded-circle"
                                        style="width: 80px; height: 80px;">
                                @endif
                            </div>
                            <div class="col-md-10">
                                <h4>{{ $lowongan->judul_lowongan }}</h4>
                                <p class="meta">
                                    <span><i class="fas fa-building"></i> {{ $lowongan->perusahaan_name }}</span><br>
                                    <span><i class="fas fa-map-marker-alt"></i> {{ $kabkota->name }}</span><br>
                                    <span><i class="fas fa-calendar"></i> Dibuka:
                                        {{ \Carbon\Carbon::parse($lowongan->tanggal_start)->locale('id')->translatedFormat('d F Y') }}</span><br>
                                    <span><i class="fas fa-calendar"></i> Ditutup:
                                        {{ \Carbon\Carbon::parse($lowongan->tanggal_end)->locale('id')->translatedFormat('d F Y') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Konten Lowongan -->
                    <div class="content">
                        <p><strong>Lokasi Penempatan: </strong>{{ $lowongan->lokasi_penempatan_text }}</p>
                        <p><strong>Jabatan: </strong>{{ $jabatan->nama }}</p>
                        <p><strong>Sektor: </strong>{{ $sektor->name }}</p>
                        <p><strong>Deskripsi Pekerjaan:</strong></p>
                        <p>{{ $lowongan->deskripsi }}</p>
                    </div>
                </div>
            </div>

            <!-- Kolom Sidebar (Jika perlu) -->
            <div class="col-lg-4">
                <!-- Sidebar atau informasi lainnya jika diperlukan -->
            </div>
        </div>
    </div>
</div>

<!-- End Blog  -->

@include('components.footer')
