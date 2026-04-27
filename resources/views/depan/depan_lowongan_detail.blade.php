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
        <style>
            .job-detail-card {
                background: #fff;
                border: 1px solid #e9eef5;
                border-radius: 14px;
                padding: 24px;
                box-shadow: 0 8px 24px rgba(16, 24, 40, 0.05);
            }

            .job-detail-logo {
                width: 82px;
                height: 82px;
                object-fit: contain;
                border-radius: 12px;
                border: 1px solid #eef2f7;
                padding: 8px;
                background: #fff;
            }

            .job-detail-title {
                font-size: 30px;
                line-height: 1.2;
                margin-bottom: 8px;
            }

            .job-detail-company {
                color: #157ec5;
                font-weight: 700;
                margin-bottom: 6px;
            }

            .job-detail-meta {
                color: #4b5565;
                font-size: 14px;
                line-height: 1.6;
                margin-bottom: 0;
            }

            .job-detail-meta i {
                width: 18px;
                color: #6b7280;
            }

            .job-detail-section {
                margin-top: 18px;
                border-top: 1px solid #eef2f7;
                padding-top: 16px;
            }

            .job-detail-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px 16px;
            }

            .job-detail-item {
                background: #f8fafc;
                border: 1px solid #edf2f7;
                border-radius: 10px;
                padding: 10px 12px;
            }

            .job-detail-item small {
                display: block;
                font-size: 12px;
                color: #6b7280;
                margin-bottom: 2px;
            }

            .job-detail-item strong {
                font-size: 14px;
                color: #1f2937;
            }

            .job-detail-desc-title {
                font-size: 16px;
                margin-bottom: 8px;
            }

            .job-detail-desc {
                color: #374151;
                line-height: 1.7;
                white-space: pre-line;
                margin-bottom: 0;
            }

            @media (max-width: 767px) {
                .job-detail-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
        <div class="row">
            <div class="col-lg-10">
                <div class="single-post job-detail-card">
                    <div class="post-header">
                        <div class="row align-items-center g-3">
                            <div class="col-md-2 col-3">
                                @if ($lowongan->perusahaan_foto)
                                    <img src="{{ asset('storage/' . $lowongan->perusahaan_foto) }}"
                                        alt="Logo Perusahaan" class="img-fluid job-detail-logo">
                                @else
                                    <img src="{{ asset('assets/nakerbisa_fe/img/logo-perusahaan.png') }}"
                                        alt="Logo Perusahaan" class="img-fluid job-detail-logo">
                                @endif
                            </div>
                            <div class="col-md-10 col-9">
                                <h2 class="job-detail-title">{{ $lowongan->judul_lowongan }}</h2>
                                <div class="job-detail-company">{{ $lowongan->perusahaan_name }}</div>
                                <p class="job-detail-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> {{ $kabkota->name ?? '-' }}</span><br>
                                    <span><i class="fas fa-calendar-alt"></i> Dibuka:
                                        {{ \Carbon\Carbon::parse($lowongan->tanggal_start)->locale('id')->translatedFormat('d F Y') }}</span><br>
                                    <span><i class="fas fa-calendar-times"></i> Ditutup:
                                        {{ \Carbon\Carbon::parse($lowongan->tanggal_end)->locale('id')->translatedFormat('d F Y') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="job-detail-section">
                        <div class="job-detail-grid">
                            <div class="job-detail-item">
                                <small>Lokasi Penempatan</small>
                                <strong>{{ $lowongan->lokasi_penempatan_text ?: '-' }}</strong>
                            </div>
                            <div class="job-detail-item">
                                <small>Jabatan</small>
                                <strong>{{ $jabatan->nama ?? '-' }}</strong>
                            </div>
                            <div class="job-detail-item">
                                <small>Sektor</small>
                                <strong>{{ $sektor->name ?? '-' }}</strong>
                            </div>
                            <div class="job-detail-item">
                                <small>Status Lowongan</small>
                                <strong>Aktif</strong>
                            </div>
                        </div>
                    </div>

                    <div class="job-detail-section">
                        <h5 class="job-detail-desc-title">Deskripsi Pekerjaan</h5>
                        <p class="job-detail-desc">{{ $lowongan->deskripsi ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Blog  -->

@include('components.footer')
