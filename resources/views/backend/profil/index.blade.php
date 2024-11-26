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
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-xl-12">
                                <h4 class="mb-4">Profile</h4>
                                <a href="{{ route('cetak.cv') }}" class="btn btn-primary">
                                    <i class="feather icon-download"></i> Cetak CV
                                </a>
                            </div>
                        </div>
                        @auth
                            <section class="section mt-3">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="card">
                                            <div class="card-body py-4 px-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xl" style="border-radius:60px">
                                                        <span>
                                                            <i class="bi bi-person-fill" style="font-size: 50px"></i>
                                                        </span>
                                                    </div>
                                                    <div class="ms-3 name">
                                                        <h5 class="font-bold fs-6 m-1">Name</h5>
                                                        <h6 class="text-muted mb-0 fs-6">{{ auth()->user()->name }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="card">
                                            <div class="card-body py-4 px-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xl" style="border-radius:60px">
                                                        <span>
                                                            <i class="bi bi-envelope-fill" style="font-size: 50px"></i>
                                                        </span>
                                                    </div>
                                                    <div class="ms-3 name">
                                                        <h5 class="font-bold fs-6 m-1">Email</h5>
                                                        <h6 class="text-muted mb-0 fs-6">{{ auth()->user()->email }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Section Dropdown (Update User) -->
                            <section class="section mt-3">
                                <div class="card">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                    aria-expanded="false" aria-controls="flush-collapseOne">
                                                    <h4 class="card-title">Update User</h4>
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample"
                                                style="">
                                                <div class="accordion-body">

                                                    <form class="form form-vertical"
                                                        action="{{ route('admin.update-user', auth()->user()->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="first-name-vertical text-black">Name</label>
                                                                        <input type="text" id="first-name-vertical"
                                                                            class="form-control" name="name"
                                                                            placeholder="Name"
                                                                            value="{{ auth()->user()->name }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="email-id-vertical text-black">Email</label>
                                                                        <input type="email" id="email-id-vertical"
                                                                            class="form-control" name="email"
                                                                            placeholder="Email"
                                                                            value="{{ auth()->user()->email }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="password-vertical text-black">Password</label>
                                                                        <input type="password" id="password"
                                                                            class="form-control" name="password"
                                                                            placeholder="Password">
                                                                        <input type="checkbox" id="show-password"><small>Lihat
                                                                            Kata Sandi</small>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 d-flex justify-content-end">
                                                                    <button type="submit"
                                                                        class="btn btn-primary me-1 mb-1 mt-3">
                                                                        Update
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endauth
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
                                                                <p><strong>Pendidikan:</strong> {{ $item->pendidikan_name }}
                                                                </p>
                                                                <p><strong>Jurusan:</strong>
                                                                    {{ $item->jurusan_name ?? 'Tidak Ada Jurusan' }}</p>
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
    <script>
        $(document).ready(function() {
            $("#show-password").change(function() {
                $(this).prop("checked") ? $("#password").prop("type", "text") : $("#password").prop("type",
                    "password");
            });
        });
    </script>
@endpush
