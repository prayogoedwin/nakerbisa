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
        <style>
            .job-card {
                border: 1px solid #eef2f7;
                border-radius: 14px;
                transition: all 0.2s ease;
                min-height: 100%;
                background: #fff;
            }

            .job-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 24px rgba(34, 72, 140, 0.08);
            }

            .job-logo {
                width: 92px;
                height: 72px;
                object-fit: contain;
            }

            .job-address {
                color: #6a7688;
                font-size: 13px;
                line-height: 1.45;
                margin: 2px 0 2px;
            }

            .job-region {
                color: #6a7688;
                font-size: 13px;
                line-height: 1.45;
                margin: 0 0 4px;
            }

            .job-expire {
                color: #3b455a;
                font-size: 12px;
                margin-bottom: 0;
            }

            .job-title a {
                color: #111;
                font-size: 20px;
                line-height: 1.25;
                font-weight: 700;
            }

            .job-card .thumb {
                margin-bottom: 8px;
            }

            .job-card .info {
                padding-top: 0;
            }

            .job-card .blog-meta ul {
                margin-bottom: 2px;
            }

            .job-title {
                margin-top: 6px;
                margin-bottom: 4px;
            }
        </style>
        <div class="esitmate-form2 mt-40">
            <form action="{{ route('depan.lowongan-kerja') }}" method="GET">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="name">Judul Lowongan</label>
                            <input class="form-control" id="name" name="judul_lowongan"
                                value="{{ request('judul_lowongan') }}"
                                placeholder="Cari Judul Lowongan Kerja" type="text">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="pendidikan_id">Pendidikan</label>
                            <select id="pendidikan_id" name="pendidikan_id" class="form-control">
                                <option value="">Pilih Pendidikan</option>
                                <option value="1" {{ request('pendidikan_id') == '1' ? 'selected' : '' }}>SD
                                </option>
                                <option value="2" {{ request('pendidikan_id') == '2' ? 'selected' : '' }}>SMP
                                </option>
                                <option value="3" {{ request('pendidikan_id') == '3' ? 'selected' : '' }}>SMA / SMK
                                </option>
                                <option value="4" {{ request('pendidikan_id') == '4' ? 'selected' : '' }}>D1
                                </option>
                                <option value="5" {{ request('pendidikan_id') == '5' ? 'selected' : '' }}>D2
                                </option>
                                <option value="6" {{ request('pendidikan_id') == '6' ? 'selected' : '' }}>D3
                                </option>
                                <option value="7" {{ request('pendidikan_id') == '7' ? 'selected' : '' }}>D4
                                </option>
                                <option value="8" {{ request('pendidikan_id') == '8' ? 'selected' : '' }}>S1
                                </option>
                                <option value="9" {{ request('pendidikan_id') == '9' ? 'selected' : '' }}>S2
                                </option>
                                <option value="10" {{ request('pendidikan_id') == '10' ? 'selected' : '' }}>S3
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="kabkota_id">Lokasi Perusahaan</label>
                            <select id="kabkota_id" name="kabkota_id" class="form-control">
                                <option value="">Pilih Lokasi</option>
                                @foreach (getKabkota() as $kabkota)
                                    <option value="{{ $kabkota->id }}"
                                        {{ request('kabkota_id') == (string) $kabkota->id ? 'selected' : '' }}>
                                        {{ $kabkota->name }}
                                    </option>
                                @endforeach
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
                        <div class="blog-style-one job-card">
                            <div class="thumb">
                                <a href="#">
                                    @if ($lowongan->perusahaan_foto)
                                        <img src="{{ asset('storage/' . $lowongan->perusahaan_foto) }}"
                                            alt="Thumb" class="img-fluid logo-circle job-logo"
                                            onerror="this.onerror=null;this.src='{{ asset('assets/nakerbisa_fe/img/800x600.png') }}';">
                                    @else
                                        <img src="{{ asset('assets/nakerbisa_fe/img/800x600.png') }}"
                                            alt="Thumb" class="img-fluid logo-circle job-logo">
                                    @endif
                                </a>
                            </div>
                            <div class="info">
                                <div class="blog-meta">
                                    <ul>
                                        <li class="sub-title">{{ $lowongan->perusahaan_name ?: '-' }}</li>
                                    </ul>
                                    <div class="job-address">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ trim($lowongan->perusahaan_alamat ?? '-') }}
                                    </div>
                                    <div class="job-region">
                                        Kec. {{ $lowongan->perusahaan_kecamatan ?: '-' }},
                                        Kab. {{ $lowongan->perusahaan_kabupaten ?: '-' }}
                                    </div>
                                </div>
                                <h3 class="job-title">
                                    <a
                                        href="{{ route('lowongan.show', encode_url($lowongan->id)) }}">{{ $lowongan->judul_lowongan }}</a>
                                </h3>
                                <div class="job-expire">Info expired:
                                    {{ \Carbon\Carbon::parse($lowongan->tanggal_end)->format('d F, Y') }}</div>
                                {{-- <a href="{{ route('lowongan.show', $lowongan->id) }}" class="btn-simple"><i class="fas fa-angle-right"></i> Read more</a> --}}
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
