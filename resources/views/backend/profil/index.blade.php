@extends('backend.template.backend')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-xl-12">
                                <h4 class="mb-4">Profile</h4>
                                <a href="{{ route('cetak.cv') }}" class="btn btn-primary">
                                    <i class="feather icon-download"></i> Cetak CV
                                </a>  
                            </div>
                        </div>
                        <!-- Section Dropdown (Update Pendidikan) -->
                        <section class="section mt-3">
                            <div class="card">
                                <div class="accordion accordion-flush" id="accordionFlushPendidikan">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingPendidikan">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapsePendidikan"
                                                aria-expanded="false" aria-controls="flush-collapsePendidikan">
                                                <h4 class="card-title">Pendidikan</h4>
                                            </button>
                                        </h2>
                                        <div id="flush-collapsePendidikan" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingPendidikan"
                                            data-bs-parent="#accordionFlushPendidikan">
                                            <div class="accordion-body">
                                                <!-- Tampilkan Data Pendidikan -->
                                                @if ($pendidikan->isNotEmpty())
                                                    <div class="list-group">
                                                        @foreach ($pendidikan as $item)
                                                            <div class="list-group-item">
                                                                <h5 class="mb-3"><strong>Nama Sekolah:</strong>
                                                                    {{ $item->nama_sekolah }}</h5>
                                                                <p><strong>Alamat Sekolah:</strong>
                                                                    {{ $item->alamat_sekolah }}</p>
                                                                <p><strong>Jurusan:</strong> {{ $item->jurusan_id }}</p>
                                                                <p><strong>Tahun Lulus:</strong> {{ $item->lulus }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="alert alert-warning" role="alert">
                                                        Data pendidikan belum tersedia.
                                                    </div>
                                                @endif

                                                <!-- Button Tambah Data Pendidikan -->
                                                <div class="d-flex justify-content-end mt-4">
                                                    <a href="{{ route('pendidikan.index') }}"
                                                        class="btn btn-success btn-sm btn-round has-ripple">
                                                        <i class="feather icon-plus"></i> Update Data
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Section Dropdown (Update Pengalaman Kerja) -->
                        <!-- Section Dropdown (Update Pengalaman Kerja) -->
                        <section class="section mt-3">
                            <div class="card">
                                <div class="accordion accordion-flush" id="accordionFlushPengalaman">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingPengalaman">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapsePengalaman"
                                                aria-expanded="false" aria-controls="flush-collapsePengalaman">
                                                <h4 class="card-title">Pengalaman Kerja</h4>
                                            </button>
                                        </h2>
                                        <div id="flush-collapsePengalaman" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingPengalaman"
                                            data-bs-parent="#accordionFlushPengalaman">
                                            <div class="accordion-body">
                                                <!-- Tampilkan Data Pengalaman Kerja -->
                                                @if ($pengalaman->isNotEmpty())
                                                    <div class="list-group">
                                                        @foreach ($pengalaman as $item)
                                                            <div class="list-group-item">
                                                                <h5 class="mb-3"><strong>Nama Perusahaan:</strong>
                                                                    {{ $item->nama_perusahaan }}</h5>
                                                                <p><strong>Alamat Perusahaan:</strong>
                                                                    {{ $item->alamat_perusahaan }}</p>
                                                                <p><strong>Jabatan:</strong> {{ $item->jabatan }}</p>
                                                                <p><strong>Mulai Tahun:</strong> {{ $item->mulai_tahun }}
                                                                </p>
                                                                <p><strong>Berhenti Tahun:</strong>
                                                                    {{ $item->berhenti_tahun }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="alert alert-warning" role="alert">
                                                        Data pengalaman kerja belum tersedia.
                                                    </div>
                                                @endif

                                                <!-- Button Tambah Data Pengalaman Kerja -->
                                                <div class="d-flex justify-content-end mt-4">
                                                    <a href="{{ route('pengalaman.index') }}"
                                                        class="btn btn-success btn-sm btn-round has-ripple">
                                                        <i class="feather icon-plus"></i> Update Data
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>


                        <!-- Section Dropdown (Update Keterampilan) -->
                        <section class="section mt-3">
                            <div class="card">
                                <div class="accordion accordion-flush" id="accordionFlushKeterampilan">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingKeterampilan">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseKeterampilan"
                                                aria-expanded="false" aria-controls="flush-collapseKeterampilan">
                                                <h4 class="card-title">Keterampilan</h4>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseKeterampilan" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingKeterampilan"
                                            data-bs-parent="#accordionFlushKeterampilan">
                                            <div class="accordion-body">
                                                <!-- Tampilkan Data Keterampilan -->
                                                @if ($keterampilan->isNotEmpty())
                                                    <div class="list-group">
                                                        @foreach ($keterampilan as $item)
                                                            <div class="list-group-item">
                                                                <h5 class="mb-3"><strong>Lembaga Penyelenggara:</strong>
                                                                    {{ $item->lembaga_penyelenggara }}</h5>
                                                                <p><strong>Alamat Penyelenggara:</strong>
                                                                    {{ $item->alamat_penyelenggara }}</p>
                                                                <p><strong>Tahun Lulus:</strong> {{ $item->lulus_tahun }}
                                                                </p>
                                                                <p><strong>Nomor Sertifikat:</strong>
                                                                    {{ $item->no_sertifikat }}</p>
                                                                <p><strong>Lembaga Penguji:</strong>
                                                                    {{ $item->lembaga_penguji }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="alert alert-warning" role="alert">
                                                        Data keterampilan belum tersedia.
                                                    </div>
                                                @endif

                                                <!-- Button Tambah Data Keterampilan -->
                                                <div class="d-flex justify-content-end mt-4">
                                                    <a href="{{ route('keterampilan.index') }}"
                                                        class="btn btn-success btn-sm btn-round has-ripple">
                                                        <i class="feather icon-plus"></i> Update Data
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- / Content -->
                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
    </div>
@endsection


@push('js')
@endpush
