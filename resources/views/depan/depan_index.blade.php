@include('components.header-index')
<!-- Start Banner Area
    ============================================= -->
<div class="banner-style-four-area text-light bg-cover"
    style="background-image: url({{ asset('assets/nakerbisa_fe/img/shape/banner-2-5.png') }});">
    <!-- Single Item -->
    <div class="banner-style-four">
        <div class="container">
            <div class="content">

                <div class="row align-center">
                    <div class="col-xl-6 col-lg-7">
                        <div class="information">
                            <h2 class="wow fadeInUp" data-wow-delay="500ms" data-wow-duration="400ms">
                                SELAMAT&nbsp;&nbsp;DATANG<br />
                                DI &nbsp;&nbsp; NAKERBISA REMBANG
                                </span>
                            </h2>
                            <p class="wow fadeInUp" data-wow-delay="900ms" data-wow-duration="400ms">
                                {{-- Sistem Informasi Ketenagakerjaan Kabupaten Rembang --}}
                                Tenaga Kerja Rembang Berani Inovatif Santun dan Akuntabel
                            </p>

                            <div class="button mt-30 wow fadeInUp" data-wow-duration="400ms">
                                <a class="btn-animation" href="#loker_terbaru"><i class="fas fa-arrow-right"></i>
                                    <span>Cari Lowongan Kerja Sekarang</span></a>
                            </div>


                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-5 pl-60 pl-md-15 pl-xs-15">
                        <div class="thumb">
                            <img src="{{ asset('assets/nakerbisa_fe/img/self/mascot_nakerbisa.png') }}" alt="Thumb">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Single Item -->
</div>
<!-- End Banner -->

<!-- Start Pricing
    ============================================= -->
<div class="pricing-style-one-area default-padding bottom-less" id="loker_terbaru">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="site-heading secondary text-center">
                    <!-- <h4 class="sub-heading">Lowongan Terbaru</h4> -->
                    <h2 class="title">Lowongan Kerja Terbaru
                    </h2>
                    <!-- <div class="devider"></div> -->
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <!-- Single Itme -->
            <div class="col-xl-3 col-md-6 mb-30">
                <div class="pricing-style-one"
                    style="background-image: url({{ asset('assets/nakerbisa_fe/img/shape/15.webp') }});">
                    <img src="{{ asset('assets/nakerbisa_fe/img/logo-perusahaan.png') }}" width="100px">
                    <br />
                    <br />
                    <div class="pricing-header">
                        <h4>Dibutuhkan Akunting</h4>
                        <p>
                            Dibutuhkan Akunting Berpengalaman / Fresh Graduete
                        </p>
                    </div>
                    <div class="pricing-content">
                        <ul>
                            <li><i class="fas fa-building"></i> PT Rembang Bersatu</li>
                            <li><i class="fas fa-map"></i> Rembang</li>
                            <li><i class="fas fa-clock"></i> Exp: 10 Desember 2024</li>
                        </ul>
                        <a class="btn mt-25 btn-sm btn-dark animation" href="#">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <!-- End Single Itme -->

            <!-- Single Itme -->
            <div class="col-xl-3 col-md-6 mb-30">
                <div class="pricing-style-one"
                    style="background-image: url({{ asset('assets/nakerbisa_fe/img/shape/15.webp') }});">
                    <img src="{{ asset('assets/nakerbisa_fe/img/logo-perusahaan.png') }}" width="100px">
                    <br />
                    <br />
                    <div class="pricing-header">
                        <h4>Dibutuhkan IT</h4>
                        <p>
                            Dibutuhkan IT Programmer Berpengalaman / Fresh Graduete
                        </p>
                    </div>
                    <div class="pricing-content">
                        <ul>
                            <li><i class="fas fa-building"></i> PT Rembang Permai</li>
                            <li><i class="fas fa-map"></i> Rembang</li>
                            <li><i class="fas fa-clock"></i> Exp: 11 Desember 2024</li>
                        </ul>
                        <a class="btn mt-25 btn-sm btn-dark animation" href="#">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <!-- End Single Itme -->

            <!-- Single Itme -->
            <div class="col-xl-3 col-md-6 mb-30">
                <div class="pricing-style-one"
                    style="background-image: url({{ asset('assets/nakerbisa_fe/img/shape/15.webp') }});">
                    <img src="{{ asset('assets/nakerbisa_fe/img/logo-perusahaan.png') }}" width="100px">
                    <br />
                    <br />
                    <div class="pricing-header">
                        <h4>Dibutuhkan Pramusaji</h4>
                        <p>
                            Dibutuhkan Pramusaji Berpengalaman / Fresh Graduete
                        </p>
                    </div>
                    <div class="pricing-content">
                        <ul>
                            <li><i class="fas fa-building"></i> PT Rembang Resto</li>
                            <li><i class="fas fa-map"></i> Rembang</li>
                            <li><i class="fas fa-clock"></i> Exp: 19 Desember 2024</li>
                        </ul>
                        <a class="btn mt-25 btn-sm btn-dark animation" href="#">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <!-- End Single Itme -->

            <!-- Single Itme -->
            <div class="col-xl-3 col-md-6 mb-30">
                <div class="pricing-style-one"
                    style="background-image: url({{ asset('assets/nakerbisa_fe/img/shape/15.webp') }});">
                    <img src="{{ asset('assets/nakerbisa_fe/img/logo-perusahaan.png') }}" width="100px">
                    <br />
                    <br />
                    <div class="pricing-header">
                        <h4>Dibutuhkan Driver</h4>
                        <p>
                            Dibutuhkan Driver Berpengalaman / Fresh Graduete
                        </p>
                    </div>
                    <div class="pricing-content">
                        <ul>
                            <li><i class="fas fa-building"></i> PT Rembang Expedisi</li>
                            <li><i class="fas fa-map"></i> Rembang</li>
                            <li><i class="fas fa-clock"></i> Exp: 1 Desember 2024</li>
                        </ul>
                        <a class="btn mt-25 btn-sm btn-dark animation" href="#">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <!-- End Single Itme -->


            <!-- Single Itme -->
            <div class="col-xl-3 col-md-6 mb-30">
                <div class="pricing-style-one"
                    style="background-image: url({{ asset('assets/nakerbisa_fe/img/shape/15.webp') }});">
                    <img src="{{ asset('assets/nakerbisa_fe/img/logo-perusahaan.png') }}" width="100px">
                    <br />
                    <br />
                    <div class="pricing-header">
                        <h4>Dibutuhkan Akunting</h4>
                        <p>
                            Dibutuhkan Akunting Berpengalaman / Fresh Graduete
                        </p>
                    </div>
                    <div class="pricing-content">
                        <ul>
                            <li><i class="fas fa-building"></i> PT Rembang Bersatu</li>
                            <li><i class="fas fa-map"></i> Rembang</li>
                            <li><i class="fas fa-clock"></i> Exp: 10 Desember 2024</li>
                        </ul>
                        <a class="btn mt-25 btn-sm btn-dark animation" href="#">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <!-- End Single Itme -->

            <!-- Single Itme -->
            <div class="col-xl-3 col-md-6 mb-30">
                <div class="pricing-style-one"
                    style="background-image: url({{ asset('assets/nakerbisa_fe/img/shape/15.webp') }});">
                    <img src="{{ asset('assets/nakerbisa_fe/img/logo-perusahaan.png') }}" width="100px">
                    <br />
                    <br />
                    <div class="pricing-header">
                        <h4>Dibutuhkan IT</h4>
                        <p>
                            Dibutuhkan IT Programmer Berpengalaman / Fresh Graduete
                        </p>
                    </div>
                    <div class="pricing-content">
                        <ul>
                            <li><i class="fas fa-building"></i> PT Rembang Permai</li>
                            <li><i class="fas fa-map"></i> Rembang</li>
                            <li><i class="fas fa-clock"></i> Exp: 11 Desember 2024</li>
                        </ul>
                        <a class="btn mt-25 btn-sm btn-dark animation" href="#">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <!-- End Single Itme -->

            <!-- Single Itme -->
            <div class="col-xl-3 col-md-6 mb-30">
                <div class="pricing-style-one"
                    style="background-image: url({{ asset('assets/nakerbisa_fe/img/shape/15.webp') }});">
                    <img src="{{ asset('assets/nakerbisa_fe/img/logo-perusahaan.png') }}" width="100px">
                    <br />
                    <br />
                    <div class="pricing-header">
                        <h4>Dibutuhkan Pramusaji</h4>
                        <p>
                            Dibutuhkan Pramusaji Berpengalaman / Fresh Graduete
                        </p>
                    </div>
                    <div class="pricing-content">
                        <ul>
                            <li><i class="fas fa-building"></i> PT Rembang Resto</li>
                            <li><i class="fas fa-map"></i> Rembang</li>
                            <li><i class="fas fa-clock"></i> Exp: 19 Desember 2024</li>
                        </ul>
                        <a class="btn mt-25 btn-sm btn-dark animation" href="#">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <!-- End Single Itme -->

            <!-- Single Itme -->
            <div class="col-xl-3 col-md-6 mb-30">
                <div class="pricing-style-one"
                    style="background-image: url({{ asset('assets/nakerbisa_fe/img/shape/15.webp') }});">
                    <img src="{{ asset('assets/nakerbisa_fe/img/logo-perusahaan.png') }}" width="100px">
                    <br />
                    <br />
                    <div class="pricing-header">
                        <h4>Dibutuhkan Driver</h4>
                        <p>
                            Dibutuhkan Driver Berpengalaman / Fresh Graduete
                        </p>
                    </div>
                    <div class="pricing-content">
                        <ul>
                            <li><i class="fas fa-building"></i> PT Rembang Expedisi</li>
                            <li><i class="fas fa-map"></i> Rembang</li>
                            <li><i class="fas fa-clock"></i> Exp: 1 Desember 2024</li>
                        </ul>
                        <a class="btn mt-25 btn-sm btn-dark animation" href="#">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <!-- End Single Itme -->
        </div>

        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="load-more-info secondary text-center mt-60">
                    <p>
                        Lihat lowongan kerja lebih banyak lagi? <a href="{{ route('depan.lowongan-kerja') }}">Klik disini</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End Pricng -->


<!-- Start Check SEO
    ============================================= -->
<div class="request-call-back-area secondary text-light default-padding">
    <div class="container">
        <div class="row align-center">
            <div class="col-lg-6">
                <h2 class="title">Cari Lowongan Kerja <br> Paling Sesuai</h2>
                <form action="{{ url('depan/lowongan-kerja') }}" method="GET">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="judul_lowongan">Judul Lowongan</label>
                                <input class="form-control" id="judul_lowongan" name="judul_lowongan"
                                    placeholder="Ketik Judul Lowongan" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
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

                        <div class="col-lg-6">
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
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="button btn btn-success"
                                style="background-color: #fff !important; color:grey">
                                Cari Lowongan Kerja
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-6 text-end">
                <div class="achivement-counter">
                    <ul>
                        <li>
                            <div class="icon">
                                <i class="flaticon-stats"></i>
                            </div>
                            <div class="fun-fact">
                                <div class="counter">
                                    <div class="timer" data-to="{{ $lowonganTerbaruCount ?? '-'  }}" data-speed="2000">{{ $lowonganTerbaruCount ?? '-'  }}</div>
                                </div>
                                <span class="medium">Lowongan Terbaru</span>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <i class="flaticon-group"></i>
                            </div>
                            <div class="fun-fact">
                                <div class="counter">
                                    <div class="timer" data-to="{{ $lowonganAktifCount ?? '-'  }}" data-speed="2000">{{ $lowonganAktifCount ?? '-'  }}</div>
                                </div>
                                <span class="medium">Lowongan Aktif</span>
                            </div>
                        </li>
                    </ul>
                </div>                
            </div>
        </div>
    </div>
</div>
<!-- End Check SEO  -->



<!-- Start Faq
    ============================================= -->
<div class="faq-style-one-area relative">


    <div class="container">
        <div class="row align-center">

            <div class="col-lg-6">
                <div class="faq-style-one default-padding">
                    <h4 class="sub-heading">FAQ</h4>
                    <h2 class="title mb-30">Jenis Pertanyaan Umum <br></h2>
                    <div class="accordion" id="faqAccordion">
                        @if ($faq->count())
                            @foreach ($faq as $index => $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{ $index }}">
                                        <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $index }}"
                                            aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                            aria-controls="collapse-{{ $index }}">
                                            {{ $faq->name }}
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ $index }}"
                                        class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                        aria-labelledby="heading-{{ $index }}" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>
                                                {!! $faq->description !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Belum ada pertanyaan yang tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-5 offset-lg-1 mt-120 mt-md-50 mt-xs-30">
                <div class="faq-thumb">
                    <img src="{{ asset('assets/nakerbisa_fe/img/self/mascot_mikir.png') }}" alt="Image Not Found">
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Faq -->


<!-- Start Partner
    ============================================= -->
<div class="partner-style-two-area overflow-hidden bg-gray text-light default-padding">
    <div class="partner-shape"></div>
    <div class="container">
        <div class="row align-center">
            <div class="col-lg-4">
                <div class="partner-heading">
                    <h3>Didukung dan<br><strong>Terintegrasi</strong> dengan</h3>
                </div>
            </div>
            <div class="col-lg-7 offset-lg-1">

                <div class="clients-style-two-carousel swiper">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">


                        <!-- Single Item -->
                        <div class="swiper-slide">
                            <img src="{{ asset('assets/nakerbisa_fe/img/client/logo-pemkab-rembang.webp') }}"
                                alt="Thumb">
                        </div>
                        <!-- End Single Item -->

                        <!-- Single Item -->
                        <div class="swiper-slide">
                            <img src="{{ asset('assets/nakerbisa_fe/img/client/emakaryo_white.png') }}"
                                alt="Thumb">
                        </div>
                        <!-- End Single Item -->

                        <!-- Single Item -->
                        <div class="swiper-slide">
                            <img src="{{ asset('assets/nakerbisa_fe/img/client/karirhub-lower.svg') }}"
                                alt="Thumb">
                        </div>
                        <!-- End Single Item -->

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Partner -->



<!-- Start Blog
    ============================================= -->
<div class="home-blog-area default-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="site-heading text-center">
                    <h4 class="sub-heading">Terbaru</h4>
                    <h2 class="title">Berita & Informasi</h2>
                    <div class="devider"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <!-- Single Item -->
          

            @if ($beritaTerbaru->count())
            @foreach ($beritaTerbaru as $bindex => $beritaTerbaru)
            <div class="col-lg-6 mt-md-30 mt-xs-30">
                <div class="blog-style-one solid">
                    <div class="thumb">
                        <img src="{{ asset('storage/' . $beritaTerbaru->cover) }}" alt="Image Not Found">
                        <a href="{{ route('berita.show', ['id' => encode_url($beritaTerbaru->id)]) }}">Berita</a>
                        <div class="info">
                            <div class="blog-meta">
                                <ul>
                                    <li>
                                        <a href="{{ route('berita.show', ['id' => encode_url($beritaTerbaru->id)]) }}"><i class="fas fa-user"></i> ADMIN NAKERBISA</a>
                                    </li>
                                    <li>
                                        {{ date('d F, Y', strtotime($beritaTerbaru->created_at)) }}
                                    </li>
                                </ul>
                            </div>
                            <h4>
                                <a href="{{ route('berita.show', ['id' => encode_url($beritaTerbaru->id)]) }}">{{ $beritaTerbaru->name }}</a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Item -->
            @endforeach
            @else
                <p>Belum ada pertanyaan yang tersedia.</p>
            @endif

            


        </div>
    </div>
</div>
<!-- End Blog  -->

@include('components.footer')
