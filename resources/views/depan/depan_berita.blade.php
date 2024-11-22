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
                <h1>Berita & Informasi</h1>
                <ul class="breadcrumb">
                    <li><a href="#"><i class="fas fa-home"></i> Beranda</a></li>
                    <li>Berita & Informasi</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Blog
    ============================================= -->
<div class="home-blog-area default-padding-bottom">
    <div class="container">
        <div class="row">
            @foreach ($berita as $item)
                <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                    <div class="blog-style-one solid mb-30">
                        <div class="thumb">
                            <!-- Menampilkan cover gambar berita -->
                            <img src="{{ asset('storage/' . $item->cover) }}" alt="Image Not Found">
                            <div class="tags"><a href="#">Berita</a></div>
                            <div class="info">
                                <div class="blog-meta">
                                    <ul>
                                        <li>
                                            <a href="#"><i class="fas fa-user"></i> ADMIN ETAM KERKA</a>
                                        </li>
                                        <li>
                                            {{ $item->created_at->format('d F, Y') }}
                                        </li>
                                    </ul>
                                </div>
                                <h4>
                                    <!-- Link ke halaman detail berita -->
                                    <a href="#">{{ $item->name }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Menampilkan pagination -->
        <div class="pagination justify-content-center">
            {{ $berita->links('pagination::bootstrap-4') }}
        </div>        
    </div>
</div>
<!-- End Blog  -->

@include('components.footer')
