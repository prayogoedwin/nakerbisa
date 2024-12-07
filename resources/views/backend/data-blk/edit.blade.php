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
                                                <h4 class="card-title">Edit Data Blk</h4>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample"
                                            style="">
                                            <div class="accordion-body">
                                                <?php
                                                $kabkotas = getKabkota();
                                                ?>
                                                <form class="form form-vertical"
                                                    action="{{ route('data.blk.update', $blk->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="name">Nama Perusahaan</label>
                                                                    <input type="text" id="name"
                                                                        class="form-control" name="name"
                                                                        value="{{ $blk->name }}">
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
                                                                                {{ $blk->id_kota == $kabkot->id ? 'selected' : '' }}>
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
                                                                        value="{{ $blk->alamat }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="kodepos">Kode Pos</label>
                                                                    <input type="text" id="kodepos"
                                                                        class="form-control" name="kodepos"
                                                                        value="{{ $blk->kodepos }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="telpon">Telpon</label>
                                                                    <input type="number" id="telpon"
                                                                        class="form-control" name="telpon"
                                                                        value="{{ $blk->telpon }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="pic">Pic</label>
                                                                    <input type="text" id="pic"
                                                                        class="form-control" name="pic"
                                                                        value="{{ $blk->pic }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="jabatan">Jabatan</label>
                                                                    <input type="text" id="jabatan"
                                                                        class="form-control" name="jabatan"
                                                                        value="{{ $blk->jabatan }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="website">Website</label>
                                                                    <input type="text" id="website"
                                                                        class="form-control" name="website"
                                                                        value="{{ $blk->website }}">
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
            var kabkotaId = "{{ $blk->id_kota }}";
            var kecamatanId = "{{ $blk->id_kecamatan }}";
            var desaId = "{{ $blk->id_desa }}";

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
@endpush
