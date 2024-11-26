@extends('backend.template.backend')

@section('content')
    <?php
    $pendidikans = getPendidikan();
    ?>
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
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center m-l-0">
                                            <div class="col-sm-6">
                                            </div>
                                            <div class="col-sm-6 text-end">
                                                <button class="btn btn-success btn-sm btn-round has-ripple"
                                                    data-bs-toggle="modal" data-bs-target="#modal-report"><i
                                                        class="feather icon-plus"></i> Add
                                                    Data</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="simpletable" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Pendidikan</th>
                                                        <th>Jurusan</th>
                                                        <th>Nama Sekolah</th>
                                                        <th>Alamat Sekolah</th>
                                                        <th>Tahun Lulus</th>
                                                        <th>Options</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
    </div>

    <div class="modal fade" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Data Pendidikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pendidikan_id">Pendidikan</label>
                                    <select class="form-control" id="pendidikan_id" name="pendidikan_id" required>
                                        <option selected disabled>Pilih Pendidikan</option>
                                        @foreach ($pendidikans as $pend)
                                            <option value="{{ $pend->id }}">{{ $pend->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="jurusan_id">Jurusan</label>
                                    <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                                        <option selected disabled>Pilih Jurusan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nama_sekolah">Nama Sekolah</label>
                                    <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah"
                                        placeholder="Masukkan Nama Sekolah" required>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="alamat_sekolah">Alamat Sekolah</label>
                                    <textarea class="form-control" id="alamat_sekolah" name="alamat_sekolah" rows="2"
                                        placeholder="Masukkan Alamat Sekolah" required></textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="lulus">Tahun Lulus</label>
                                    <input type="number" class="form-control" id="lulus" name="lulus"
                                        placeholder="Masukkan Tahun Lulus" min="1900" max="{{ date('Y') }}"
                                        required>
                                </div>
                            </div>

                            <div class="col-sm-12 text-end mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-danger">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Data Pendidikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="editPendidikanId">Pendidikan</label>
                                    <select class="form-control" id="editPendidikanId" name="pendidikan_id" required>
                                        <option selected disabled>Pilih Pendidikan</option>
                                        @foreach ($pendidikans as $pend)
                                            <option value="{{ $pend->id }}">{{ $pend->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="editJurusanId">Jurusan</label>
                                    <select class="form-control" id="editJurusanId" name="jurusan_id" required>
                                        <option selected disabled>Pilih Jurusan</option>
                                        <!-- Tambahkan pilihan jurusan -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="editNamaSekolah">Nama Sekolah</label>
                                    <input type="text" class="form-control" id="editNamaSekolah" name="nama_sekolah"
                                        placeholder="Masukkan Nama Sekolah" required>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="editAlamatSekolah">Alamat Sekolah</label>
                                    <textarea class="form-control" id="editAlamatSekolah" name="alamat_sekolah" rows="2"
                                        placeholder="Masukkan Alamat Sekolah" required></textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="editLulus">Tahun Lulus</label>
                                    <input type="number" class="form-control" id="editLulus" name="lulus"
                                        placeholder="Masukkan Tahun Lulus" min="1900" max="{{ date('Y') }}"
                                        required>
                                </div>
                            </div>

                            <div class="col-sm-12 text-end mt-3">
                                <button type="button" class="btn btn-primary"
                                    onclick="updatePendidikan()">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(function() {
            $('#simpletable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('pendidikan.index') }}', // Rute mengambil data
                autoWidth: false,
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    }, // No
                    {
                        data: 'pendidikan_id'
                    }, // ID Pendidikan
                    {
                        data: 'jurusan_id'
                    }, // ID Jurusan
                    {
                        data: 'nama_sekolah'
                    }, // Nama Sekolah
                    {
                        data: 'alamat_sekolah'
                    }, // Alamat Sekolah
                    {
                        data: 'lulus'
                    }, // Tahun Lulus
                    {
                        data: 'options',
                        orderable: false,
                        searchable: false
                    } // Tombol aksi
                ]
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#registerForm').submit(function(e) {
                e.preventDefault();

                // Clear error messages
                $('#errorMessages').html('').addClass('d-none');

                var formData = {
                    pendidikan_id: $('#pendidikan_id').val(),
                    jurusan_id: $('#jurusan_id').val(),
                    nama_sekolah: $('#nama_sekolah').val(),
                    alamat_sekolah: $('#alamat_sekolah').val(),
                    lulus: $('#lulus').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    type: 'POST',
                    url: '{{ route('pendidikan.add') }}',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert('Data berhasil ditambahkan');
                            $('#modal-report').modal('hide');
                            $('#simpletable').DataTable().ajax.reload();
                        } else {
                            alert('Gagal menambahkan data');
                            if (response.errors) {
                                let errorMessages = '';
                                $.each(response.errors, function(key, value) {
                                    errorMessages += value + '\n';
                                });
                                alert('Error:\n' + errorMessages);
                            }
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>


    <script>
        function showEditModal(id) {
            var detailUrl = "{{ route('pendidikan.detail', ':id') }}".replace(':id', id);

            $.ajax({
                url: detailUrl,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        let dt = response.data;
                        $('#editId').val(dt.id);
                        $('#editPendidikanId').val(dt.pendidikan_id); // Set pendidikan_id

                        // Setelah pendidikan dipilih, update dropdown jurusan
                        var pendidikanId = dt.pendidikan_id;
                        $('#editPendidikanId').trigger('change'); // Trigger change untuk update jurusan

                        $('#editJurusanId').val(dt.jurusan_id); // Set jurusan_id
                        $('#editNamaSekolah').val(dt.nama_sekolah);
                        $('#editAlamatSekolah').val(dt.alamat_sekolah);
                        $('#editLulus').val(dt.lulus);

                        $('#modal-edit').modal('show');
                    } else {
                        alert('Gagal memuat data');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    </script>

    <script>
        $('#editPendidikanId').on('change', function() {
            var pendidikanId = this.value;

            // Panggil API untuk mendapatkan jurusan berdasarkan pendidikan_id
            $.ajax({
                url: "{{ route('get-jurusan-bypendidikan', ':id') }}".replace(':id',
                    pendidikanId), // Panggil API
                type: 'GET',
                success: function(response) {
                    // Kosongkan dropdown jurusan sebelumnya
                    $('#editJurusanId').empty();

                    // Tambahkan opsi default
                    $('#editJurusanId').append('<option selected disabled>Pilih Jurusan</option>');

                    // Loop data jurusan dan tambahkan ke dropdown
                    $.each(response, function(index, jurusan) {
                        $('#editJurusanId').append('<option value="' + jurusan.id + '">' +
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
        function updatePendidikan() {
            var id = $('#editId').val();
            var formData = {
                pendidikan_id: $('#editPendidikanId').val(),
                jurusan_id: $('#editJurusanId').val(),
                nama_sekolah: $('#editNamaSekolah').val(),
                alamat_sekolah: $('#editAlamatSekolah').val(),
                lulus: $('#editLulus').val(),
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: "{{ route('pendidikan.update', ':id') }}".replace(':id', id),
                type: 'PUT',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#modal-edit').modal('hide');
                        $('#simpletable').DataTable().ajax.reload();
                    } else {
                        alert('Gagal memperbarui data');
                        if (response.errors) {
                            let errorMessages = '';
                            $.each(response.errors, function(key, value) {
                                errorMessages += value + '\n';
                            });
                            alert('Error:\n' + errorMessages);
                        }
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    </script>

    <script>
        function confirmDelete(id) {
            var deleteUrl = "{{ route('pendidikan.softdelete', ':id') }}".replace(':id', id);

            if (confirm("Yakin hapus data?")) {
                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#simpletable').DataTable().ajax.reload();
                        } else {
                            alert('Gagal menghapus data');
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            }
        }
    </script>

    <script>
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
@endpush
