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
                        @if (session('info'))
                            <div class="alert alert-warning">
                                {{ session('info') }}
                            </div>
                        @endif
                        <!-- Section Dropdown (Update Profil) -->
                        <section class="section mt-3">
                            <div class="card">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                aria-expanded="false" aria-controls="flush-collapseOne">
                                                <h4 class="card-title">Edit Data Bkk</h4>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample"
                                            style="">
                                            <div class="accordion-body">
                                                <?php
                                                $provinsis = getProvinsi();
                                                $sektors = getSektor();
                                                ?>
                                                <form class="form form-vertical"
                                                    action="{{ route('data.bkk.update', $bkk->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="name">Nama Perusahaan</label>
                                                                    <input type="text" id="name"
                                                                        class="form-control" name="name"
                                                                        value="{{ $bkk->name }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6" hidden>
                                                                <div class="form-group">
                                                                    <label for="loker">Penyedia Kerja Luar Negeri</label>
                                                                    <select id="loker" class="form-control"
                                                                        name="luar_negri">
                                                                        <option value="0"
                                                                            {{ $bkk->luar_negri == '0' ? 'selected' : '' }}>
                                                                            Tidak</option>
                                                                        <option value="1"
                                                                            {{ $bkk->luar_negri == '1' ? 'selected' : '' }}>
                                                                            Ya</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6" hidden>
                                                                <div class="form-group">
                                                                    <label for="jenis_bkk" class="form-label">Jenis
                                                                        Perusahaan</label>
                                                                    <select class="form-select" id="jenis_bkk"
                                                                        name="jenis_bkk" required>
                                                                        <option selected disabled>Pilih Jenis</option>
                                                                        <option value="bumd"
                                                                            {{ $bkk->jenis_bkk == 'bumd' ? 'selected' : '' }}>
                                                                            Badan Usaha Milik Daerah</option>
                                                                        <option value="bumn"
                                                                            {{ $bkk->jenis_bkk == 'bumn' ? 'selected' : '' }}>
                                                                            Badan Usaha Milik Negara</option>
                                                                        <option value="cv"
                                                                            {{ $bkk->jenis_bkk == 'cv' ? 'selected' : '' }}>
                                                                            Comanditer Venotschaap</option>
                                                                        <option value="firma"
                                                                            {{ $bkk->jenis_bkk == 'firma' ? 'selected' : '' }}>
                                                                            Firma</option>
                                                                        <option value="instansi"
                                                                            {{ $bkk->jenis_bkk == 'instansi' ? 'selected' : '' }}>
                                                                            Instansi</option>
                                                                        <option value="kp"
                                                                            {{ $bkk->jenis_bkk == 'kp' ? 'selected' : '' }}>
                                                                            Koperasi</option>
                                                                        <option value="pt"
                                                                            {{ $bkk->jenis_bkk == 'pt' ? 'selected' : '' }}>
                                                                            Perseroan Terbatas</option>
                                                                        <option value="pp"
                                                                            {{ $bkk->jenis_bkk == 'pp' ? 'selected' : '' }}>
                                                                            Perusahaan Perorangan</option>
                                                                        <option value="po"
                                                                            {{ $bkk->jenis_bkk == 'po' ? 'selected' : '' }}>
                                                                            PO*</option>
                                                                        <option value="yayasan"
                                                                            {{ $bkk->jenis_bkk == 'yayasan' ? 'selected' : '' }}>
                                                                            Yayasan</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="deskripsi"
                                                                        class="form-label">Nama Sekolah</label>
                                                                    {{-- <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $bkk->deskripsi }}</textarea> --}}
                                                                    <input type="text" id="deskripsi"
                                                                        class="form-control" name="deskripsi"
                                                                        value="{{ $bkk->deskripsi }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="nib">Nomor Daftar BKK</label>
                                                                    <input type="text" id="nib"
                                                                        class="form-control" name="nib"
                                                                        value="{{ $bkk->nib }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6" hidden>
                                                                <div class="form-group">
                                                                    <label for="id_sektor" class="form-label">Sektor</label>
                                                                    <select class="form-select" id="id_sektor"
                                                                        name="id_sektor">
                                                                        <option selected disabled>Pilih Sektor Pekerjaan
                                                                        </option>
                                                                        @foreach ($sektors as $sektor)
                                                                            <option value="{{ $sektor->id }}"
                                                                                {{ $bkk->id_sektor == $sektor->id ? 'selected' : '' }}>
                                                                                {{ $sektor->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="provinsi"
                                                                        class="form-label">Provinsi</label>
                                                                    <select class="form-select" id="provinsi_id"
                                                                        name="provinsi_id" required>
                                                                        <option selected disabled>Pilih Provinsi</option>
                                                                        @foreach ($provinsis as $prov)
                                                                            <option value="{{ $prov->id }}">
                                                                                {{ $prov->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="kabkota" class="form-label">Kabupaten /
                                                                        Kota</label>
                                                                    <select class="form-select" id="kabkota_id"
                                                                        name="kabkota_id" required>
                                                                        <option selected disabled>Pilih Kabupaten/Kota
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="kecamatan"
                                                                        class="form-label">Kecamatan</label>
                                                                    <select class="form-select" id="kecamatan_id"
                                                                        name="kecamatan_id" required>
                                                                        <option selected disabled>Pilih Kecamatan</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="kelurahan" class="form-label">Desa /
                                                                        Kelurahan</label>
                                                                    <select class="form-select" id="desa_id"
                                                                        name="desa_id" required>
                                                                        <option selected disabled>Pilih Desa/Kelurahan
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="alamat">Alamat</label>
                                                                    <input type="text" id="alamat"
                                                                        class="form-control" name="alamat"
                                                                        value="{{ $bkk->alamat }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="kodepos">Kode Pos</label>
                                                                    <input type="text" id="kodepos"
                                                                        class="form-control" name="kodepos"
                                                                        value="{{ $bkk->kodepos }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="telpon">Telpon</label>
                                                                    <input type="number" id="telpon"
                                                                        class="form-control" name="telpon"
                                                                        value="{{ $bkk->telpon }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="jabatan">Jabatan</label>
                                                                    <input type="text" id="jabatan"
                                                                        class="form-control" name="jabatan"
                                                                        value="{{ $bkk->jabatan }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="website">Website</label>
                                                                    <input type="text" id="website"
                                                                        class="form-control" name="website"
                                                                        value="{{ $bkk->website }}">
                                                                </div>
                                                            </div>
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
            // Ambil data ID dari Laravel untuk diisi pada dropdown
            var provinsiId = "{{ $bkk->id_provinsi }}"; // ID provinsi yang sudah dipilih
            var kabkotaId = "{{ $bkk->id_kota }}"; // ID kabupaten/kota yang sudah dipilih
            var kecamatanId = "{{ $bkk->id_kecamatan }}"; // ID kecamatan yang sudah dipilih
            var desaId = "{{ $bkk->id_desa }}"; // ID desa/kelurahan yang sudah dipilih

            // Load data provinsi jika ada (jika ada ID provinsi)
            if (provinsiId) {
                $('#provinsi_id').val(provinsiId); // Set nilai provinsi yang sudah dipilih
                loadKabupaten(provinsiId, kabkotaId); // Muat kabupaten berdasarkan provinsi
            }

            // Muat kecamatan jika ada kabupaten terpilih
            if (kabkotaId) {
                $('#kabkota_id').val(kabkotaId); // Set nilai kabupaten/kota yang sudah dipilih
                loadKecamatan(kabkotaId, kecamatanId); // Muat kecamatan berdasarkan kabupaten
            }

            // Muat desa jika ada kecamatan terpilih
            if (kecamatanId) {
                $('#kecamatan_id').val(kecamatanId); // Set nilai kecamatan yang sudah dipilih
                loadDesa(kecamatanId, desaId); // Muat desa berdasarkan kecamatan
            }

            // Load kabupaten berdasarkan provinsi
            $('#provinsi_id').on('change', function() {
                var provinsiId = $(this).val();
                $('#kabkota_id').empty().append('<option selected disabled>Pilih Kabupaten/Kota</option>');
                $('#kecamatan_id').empty().append('<option selected disabled>Pilih Kecamatan</option>');
                $('#desa_id').empty().append('<option selected disabled>Pilih Desa/Kelurahan</option>');

                if (provinsiId) {
                    loadKabupaten(provinsiId);
                }
            });

            // Load kecamatan berdasarkan kabupaten
            $('#kabkota_id').on('change', function() {
                var kabkotaId = $(this).val();
                $('#kecamatan_id').empty().append('<option selected disabled>Pilih Kecamatan</option>');
                $('#desa_id').empty().append('<option selected disabled>Pilih Desa/Kelurahan</option>');

                if (kabkotaId) {
                    loadKecamatan(kabkotaId);
                }
            });

            // Load desa berdasarkan kecamatan
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                $('#desa_id').empty().append('<option selected disabled>Pilih Desa/Kelurahan</option>');

                if (kecamatanId) {
                    loadDesa(kecamatanId);
                }
            });

            // Fungsi untuk memuat kabupaten berdasarkan provinsi
            function loadKabupaten(provinsiId, selectedId = null) {
                $.ajax({
                    url: "{{ route('get-kabkota-byprov', ':id') }}".replace(':id', provinsiId),
                    type: 'GET',
                    success: function(response) {
                        $.each(response, function(index, kabkota) {
                            $('#kabkota_id').append('<option value="' + kabkota.id + '"' +
                                (kabkota.id == selectedId ? ' selected' : '') + '>' +
                                kabkota.name + '</option>');
                        });
                    }
                });
            }

            // Fungsi untuk memuat kecamatan berdasarkan kabupaten
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

            // Fungsi untuk memuat desa berdasarkan kecamatan
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
@endpush
