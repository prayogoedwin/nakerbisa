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
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif


                        <div class="row">
                            <div class="col-xl-12">
                                <h4 class="mb-4">Profile</h4>
                                <a href="{{ route('cetak.cv') }}" class="btn btn-primary">
                                    <i class="feather icon-download"></i> Cetak CV ATS
                                </a>
                            </div>
                        </div>
                        @auth

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
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="first-name-vertical text-black">Name</label>
                                                                        <input type="text" id="first-name-vertical"
                                                                            class="form-control" name="name"
                                                                            placeholder="Name"
                                                                            value="{{ auth()->user()->name }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="email-id-vertical text-black">Email</label>
                                                                        <input type="email" id="email-id-vertical"
                                                                            class="form-control" name="email"
                                                                            placeholder="Email"
                                                                            value="{{ auth()->user()->email }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="whatsapp-id-vertical text-black">Whatsapp</label>
                                                                        <input type="text" id="whatsapp-id-vertical"
                                                                            class="form-control" name="whatsapp"
                                                                            placeholder="whatsapp"
                                                                            value="{{ auth()->user()->whatsapp }}">
                                                                    </div>
                                                                </div>


                                                                <div class="col-6">
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

                        <!-- Section Dropdown (Update Profil) -->
                        <section class="section mt-3">
                            <div class="card">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                aria-expanded="false" aria-controls="flush-collapseOne">
                                                <h4 class="card-title">Update Profil</h4>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample"
                                            style="">
                                            <div class="accordion-body">
                                                <?php
                                                $kabkotas = getKabkota();
                                                $pendidikans = getPendidikan();
                                                $maritals = getMarital();
                                                $agamas = getAgama();
                                                $sektors = getSektor();
                                                $statusKerjas = getStatusKerja();
                                                ?>
                                                <form class="form form-vertical"
                                                    action="{{ route('admin.update-profil', auth()->user()->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="name">Nama</label>
                                                                    <input type="text" id="name"
                                                                        class="form-control" name="name"
                                                                        value="{{ $profil->name }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="ktp">KTP</label>
                                                                    <input type="text" id="ktp"
                                                                        class="form-control" name="ktp"
                                                                        value="{{ $profil->ktp }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="tempat_lahir">Tempat Lahir</label>
                                                                    <input type="text" id="tempat_lahir"
                                                                        class="form-control" name="tempat_lahir"
                                                                        value="{{ $profil->tempat_lahir }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                                                    <input type="date" id="tanggal_lahir"
                                                                        class="form-control" name="tanggal_lahir"
                                                                        value="{{ $profil->tanggal_lahir }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="gender">Jenis Kelamin</label>
                                                                    <select id="gender" class="form-control"
                                                                        name="gender">
                                                                        <option value="L"
                                                                            {{ $profil->gender == 'L' ? 'selected' : '' }}>
                                                                            Laki-laki</option>
                                                                        <option value="P"
                                                                            {{ $profil->gender == 'P' ? 'selected' : '' }}>
                                                                            Perempuan</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="kabkota" class="form-label">Kabupaten /
                                                                        Kota</label>
                                                                    <select class="form-select" id="kabkota_id"
                                                                        name="kabkota_id" required>
                                                                        <option disabled>Pilih Kabupaten/Kota</option>
                                                                        @foreach ($kabkotas as $kabkot)
                                                                            <option value="{{ $kabkot->id }}"
                                                                                {{ $profil->id_kota == $kabkot->id ? 'selected' : '' }}>
                                                                                {{ $kabkot->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="kecamatan"
                                                                        class="form-label">Kecamatan</label>
                                                                    <select class="form-select" id="kecamatan_id"
                                                                        name="kecamatan_id" required>
                                                                        <option disabled>Pilih Kecamatan</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="kelurahan" class="form-label">Desa /
                                                                        Kelurahan</label>
                                                                    <select class="form-select" id="desa_id"
                                                                        name="desa_id" required>
                                                                        <option disabled>Pilih Desa/Kelurahan</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="alamat">Alamat</label>
                                                                    <input type="text" id="alamat"
                                                                        class="form-control" name="alamat"
                                                                        value="{{ $profil->alamat }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="kodepos">Kode Pos</label>
                                                                    <input type="text" id="kodepos"
                                                                        class="form-control" name="kodepos"
                                                                        value="{{ $profil->kodepos }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="pendidikan_id">Pendidikan</label>
                                                                    <select class="form-control" id="pendidikan_id"
                                                                        name="pendidikan_id" required>
                                                                        <option selected disabled>Pilih Pendidikan</option>
                                                                        @foreach ($pendidikans as $pend)
                                                                            <option value="{{ $pend->id }}"
                                                                                {{ $profil->id_pendidikan == $pend->id ? 'selected' : '' }}>
                                                                                {{ $pend->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="jurusan_id">Jurusan</label>
                                                                    <select class="form-control" id="jurusan_id"
                                                                        name="jurusan_id" required>
                                                                        <option selected disabled>Pilih Jurusan</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="tahun_lulus">Tahun Lulus</label>
                                                                    <input type="text" id="tahun_lulus"
                                                                        class="form-control" name="tahun_lulus"
                                                                        value="{{ $profil->tahun_lulus }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="stsperkawinan" class="form-label">Status
                                                                        Perkawinan</label>
                                                                    <select class="form-select" id="status_perkawinan_id"
                                                                        name="status_perkawinan_id" required>
                                                                        <option selected disabled>Pilih Status</option>
                                                                        @foreach ($maritals as $marit)
                                                                            <option value="{{ $marit->id }}"
                                                                                {{ $profil->id_status_perkawinan == $marit->id ? 'selected' : '' }}>
                                                                                {{ $marit->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="agama" class="form-label">Agama</label>
                                                                    <select class="form-select" id="agama_id"
                                                                        name="agama_id" required>
                                                                        <option selected disabled>Pilih Agama</option>
                                                                        @foreach ($agamas as $ag)
                                                                            <option value="{{ $ag->id }}"
                                                                                {{ $profil->id_agama == $ag->id ? 'selected' : '' }}>
                                                                                {{ $ag->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="medsos">medsos</label>
                                                                    <input type="text" id="medsos"
                                                                        class="form-control" name="medsos"
                                                                        value="{{ $profil->medsos }}">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="statusKerja" class="form-label">Status Kerja</label>
                                                                    <select class="form-select" id="status_kerja_id"
                                                                        name="status_kerja_id" required onchange="togglePekerjaanFields(this.value)">
                                                                        <option selected disabled>Pilih Status Kerja</option>
                                                                        @foreach ($statusKerjas as $kerja)
                                                                            <option value="{{ $kerja->id }}"
                                                                                {{ $profil->status_saat_ini == $kerja->id ? 'selected' : '' }}>
                                                                                {{ $kerja->status }}</option>
                                                                        @endforeach
                                                                    </select>
                                                            </div>
                                                            <div id="pekerjaan-fields" style="display: none;">
                                                                <div class="mb-3">
                                                                    <label for="sektor_pekerjaan_saat_ini"
                                                                        class="form-label">Sektor Pekerjaan Saat
                                                                        Ini</label>
                                                                    <select class="form-select"
                                                                        id="sektor_pekerjaan_saat_ini"
                                                                        name="sektor_pekerjaan_saat_ini">
                                                                        <option selected disabled>Pilih Sektor Pekerjaan
                                                                        </option>
                                                                        @foreach ($sektors as $sektor)
                                                                            <option value="{{ $sektor->id }}" {{ $profil->sektor_pekerjaan_saat_ini == $sektor->id ? 'selected' : '' }}>
                                                                                {{ $sektor->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="jam_kerja" class="form-label">Jam Kerja
                                                                        (per hari)</label>
                                                                    <input type="number" class="form-control"
                                                                        id="jam_kerja" name="jam_kerja" value="{{ $profil->jam_kerja }}">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="gaji" class="form-label">Gaji (per
                                                                        hari)</label>
                                                                    <input type="number" step="0.01"
                                                                        class="form-control" id="gaji"
                                                                        name="gaji" value="{{ $profil->gaji }}">
                                                                </div>
                                                            </div>
                                                            <!-- Tambahkan input lainnya sesuai kebutuhan -->

                                                            <div class="col-12 d-flex justify-content-end">
                                                                <button type="submit"
                                                                    class="btn btn-primary me-1 mb-1 mt-3">Update</button>
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
                                        <div id="flush-collapsePendidikan" class="accordion-collapse collapse show"
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
                                                                <p><strong>Pendidikan:</strong>
                                                                    {{ $item->pendidikan_name }}
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
                                        <div id="flush-collapsePengalaman" class="accordion-collapse collapse show"
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
                                        <div id="flush-collapseKeterampilan" class="accordion-collapse collapse show"
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

    <script>
        function togglePekerjaanFields(status) {
            const pekerjaanFields = document.getElementById('pekerjaan-fields');
            pekerjaanFields.style.display = (status === '1') ? 'block' : 'none';
        }
    </script>

    <script>
        $(document).ready(function() {
            var kabkotaId = "{{ $profil->id_kota }}";
            var kecamatanId = "{{ $profil->id_kecamatan }}";
            var desaId = "{{ $profil->id_desa }}";

            // Muat data kecamatan jika ada kabkota terpilih
            if (kabkotaId) {
                loadKecamatan(kabkotaId, kecamatanId);
            }

            // Muat data desa jika ada kecamatan terpilih
            if (kecamatanId) {
                loadDesa(kecamatanId, desaId);
            }

            $('#kabkota_id').on('change', function() {
                var kabkotaId = $(this).val();
                $('#kecamatan_id').empty().append('<option disabled>Pilih Kecamatan</option>');
                $('#desa_id').empty().append('<option disabled>Pilih Desa/Kelurahan</option>');

                if (kabkotaId) {
                    loadKecamatan(kabkotaId);
                }
            });

            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                $('#desa_id').empty().append('<option disabled>Pilih Desa/Kelurahan</option>');

                if (kecamatanId) {
                    loadDesa(kecamatanId);
                }
            });

            function loadKecamatan(kabkotaId, selectedId = null) {
                $.ajax({
                    url: "{{ route('get-kecamatan-bykabkota', ':id') }}".replace(':id', kabkotaId),
                    type: 'GET',
                    success: function(response) {
                        $.each(response, function(index, kecamatan) {
                            $('#kecamatan_id').append('<option value="' + kecamatan.id + '"' +
                                (kecamatan.id == selectedId ? ' selected' : '') + '>' +
                                kecamatan.name + '</option>');
                        });
                    }
                });
            }

            function loadDesa(kecamatanId, selectedId = null) {
                $.ajax({
                    url: "{{ route('get-desa-bykecamatan', ':id') }}".replace(':id', kecamatanId),
                    type: 'GET',
                    success: function(response) {
                        $.each(response, function(index, desa) {
                            $('#desa_id').append('<option value="' + desa.id + '"' +
                                (desa.id == selectedId ? ' selected' : '') + '>' +
                                desa.name + '</option>');
                        });
                    }
                });
            }
        });
    </script>

    <script>
        $('#kabkota_id').on('change', function() {
            // console.log(this.value);
            var kd = this.value

            // Panggil API untuk mendapatkan kecamatan berdasarkan kabkota_id
            $.ajax({
                url: "{{ route('get-kecamatan-bykabkota', ':id') }}".replace(':id', kd), // Panggil API
                type: 'GET',
                success: function(response) {
                    // Kosongkan dropdown kecamatan sebelumnya
                    $('#kecamatan_id').empty();

                    $('#desa_id').empty();
                    $('#desa_id').append('<option selected disabled>Pilih Desa/Kelurahan</option>');

                    // Tambahkan opsi default
                    $('#kecamatan_id').append('<option selected disabled>Pilih Kecamatan</option>');

                    // Loop data kecamatan dan tambahkan ke dropdown
                    $.each(response, function(index, kecamatan) {
                        $('#kecamatan_id').append('<option value="' + kecamatan.id + '">' +
                            kecamatan.name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        });


        $('#kecamatan_id').on('change', function() {
            // console.log(this.value);
            var kd = this.value

            // Panggil API untuk mendapatkan kecamatan berdasarkan kabkota_id
            $.ajax({
                url: "{{ route('get-desa-bykecamatan', ':id') }}".replace(':id', kd), // Panggil API
                type: 'GET',
                success: function(response) {
                    // Kosongkan dropdown kecamatan sebelumnya
                    $('#desa_id').empty();

                    // Tambahkan opsi default
                    $('#desa_id').append('<option selected disabled>Pilih Desa/Kelurahan</option>');

                    // Loop data kecamatan dan tambahkan ke dropdown
                    $.each(response, function(index, kecamatan) {
                        $('#desa_id').append('<option value="' + kecamatan.id + '">' +
                            kecamatan.name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        });

        $('#pendidikan_id').on('change', function() {
            // console.log(this.value);
            var kd = this.value

            // Panggil API untuk mendapatkan kecamatan berdasarkan kabkota_id
            $.ajax({
                url: "{{ route('get-jurusan-bypendidikan', ':id') }}".replace(':id', kd), // Panggil API
                type: 'GET',
                success: function(response) {
                    // Kosongkan dropdown kecamatan sebelumnya
                    $('#jurusan_id').empty();

                    // Tambahkan opsi default
                    $('#jurusan_id').append('<option selected disabled>Pilih Jurusan</option>');

                    // Loop data kecamatan dan tambahkan ke dropdown
                    $.each(response, function(index, jurusan) {
                        $('#jurusan_id').append('<option value="' + jurusan.id + '">' +
                            jurusan.nama + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        });
    </script>

    <script>
        $('#provinsi_id').on('change', function() {
            // console.log(this.value);
            var kd = this.value

            // Panggil API untuk mendapatkan kecamatan berdasarkan kabkota_id
            $.ajax({
                url: "{{ route('get-kabkota-byprov', ':id') }}".replace(':id', kd), // Panggil API
                type: 'GET',
                success: function(response) {
                    // Kosongkan dropdown kecamatan sebelumnya
                    $('#kabkota_id').empty();

                    // Tambahkan opsi default
                    $('#kabkota_id').append('<option selected disabled>Pilih Kabupaten/Kota</option>');

                    // Loop data kecamatan dan tambahkan ke dropdown
                    $.each(response, function(index, kabkota) {
                        $('#kabkota_id').append('<option value="' + kabkota.id + '">' +
                            kabkota.name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var pendidikanId = "{{ $profil->id_pendidikan }}";
            var jurusanId = "{{ $profil->id_jurusan }}";

            // Jika ada pendidikan terpilih, muat jurusan terkait
            if (pendidikanId) {
                loadJurusan(pendidikanId, jurusanId);
            }

            $('#pendidikan_id').on('change', function() {
                var pendidikanId = $(this).val();
                $('#jurusan_id').empty().append('<option selected disabled>Pilih Jurusan</option>');

                if (pendidikanId) {
                    loadJurusan(pendidikanId);
                }
            });

            function loadJurusan(pendidikanId, selectedId = null) {
                $.ajax({
                    url: "{{ route('get-jurusan-bypendidikan', ':id') }}".replace(':id', pendidikanId),
                    type: 'GET',
                    success: function(response) {
                        $.each(response, function(index, jurusan) {
                            $('#jurusan_id').append('<option value="' + jurusan.id + '"' +
                                (jurusan.id == selectedId ? ' selected' : '') + '>' +
                                jurusan.nama + '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            }
        });
    </script>
@endpush
