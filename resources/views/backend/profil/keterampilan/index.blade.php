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
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('profil.index') }}">Profil</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah Data Keterampilan</li>
                            </ol>
                        </nav>
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
                                                        <th>Lembaga Penyelenggara</th>
                                                        <th>Alamat Penyelenggara</th>
                                                        <th>Tahun Lulus</th>
                                                        <th>No Sertifikat</th>
                                                        <th>Lembaga Penguji</th>
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

    <div class="modal fade" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Keterampilan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="floating-label" for="lembaga_penyelenggara">Lembaga Penyelenggara</label>
                                    <input type="text" class="form-control" id="lembaga_penyelenggara"
                                        name="lembaga_penyelenggara">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="floating-label" for="alamat_penyelenggara">Alamat Penyelenggara</label>
                                    <input type="text" class="form-control" id="alamat_penyelenggara"
                                        name="alamat_penyelenggara">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="floating-label" for="lulus_tahun">Lulus Tahun</label>
                                    <input type="number" class="form-control" id="lulus_tahun" name="lulus_tahun">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="floating-label" for="no_sertifikat">No Sertifikat</label>
                                    <input type="number" class="form-control" id="no_sertifikat" name="no_sertifikat">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="floating-label" for="lembaga_penguji">Lembaga Penguji</label>
                                    <input type="text" class="form-control" id="lembaga_penguji" name="lembaga_penguji">
                                </div>
                            </div>

                            <div class="col-sm-12 text-end">
                                <button class="btn btn-primary mt-3">Submit</button>
                                <button type="reset" class="btn btn-danger mt-3">Clear</button>
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
                    <h5 class="modal-title" id="modalEditLabel">Edit Keterampilan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editKeterampilanForm">
                        <input type="hidden" id="editId">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="floating-label" for="editLembagaPenyelenggara">Lembaga Penyelenggara</label>
                                <input type="text" class="form-control" id="editLembagaPenyelenggara"
                                    name="lembaga_penyelenggara">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="floating-label" for="editAlamatPenyelenggara">Alamat Penyelenggara</label>
                                <input type="text" class="form-control" id="editAlamatPenyelenggara"
                                    name="alamat_penyelenggara">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="floating-label" for="editLulusTahun">Lulus Tahun</label>
                                <input type="number" class="form-control" id="editLulusTahun" name="lulus_tahun">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="floating-label" for="editNoSertifikat">No Sertifikat</label>
                                <input type="number" class="form-control" id="editNoSertifikat" name="no_sertifikat">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="floating-label" for="editLembagaPenguji">Lembaga Penguji</label>
                                <input type="text" class="form-control" id="editLembagaPenguji"
                                    name="lembaga_penguji">
                            </div>
                        </div>

                        <div class="col-sm-12 text-end">
                            <button type="button" class="btn btn-primary mt-3"
                                onclick="updateKeterampilan()">Submit</button>
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
                ajax: '{{ route('keterampilan.index') }}',
                autoWidth: false,
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'lembaga_penyelenggara'
                    },
                    {
                        data: 'alamat_penyelenggara'
                    },
                    {
                        data: 'lembaga_penguji'
                    },
                    {
                        data: 'lulus_tahun'
                    },
                    {
                        data: 'no_sertifikat'
                    },
                    {
                        data: 'options',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>


    <script>
        // Handle add form submission
        $('#registerForm').submit(function(e) {
            e.preventDefault();
            var formData = {
                lembaga_penyelenggara: $('#lembaga_penyelenggara').val(),
                alamat_penyelenggara: $('#alamat_penyelenggara').val(),
                lulus_tahun: $('#lulus_tahun').val(),
                no_sertifikat: $('#no_sertifikat').val(),
                lembaga_penguji: $('#lembaga_penguji').val(),
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                type: 'POST',
                url: '{{ route('keterampilan.add') }}',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert('Berhasil menambahkan data keterampilan');
                        $('#modal-report').modal('hide');
                        location.reload();
                    } else {
                        alert('Gagal menambahkan data keterampilan');
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });
        });
    </script>

    <script>
        function showEditModal(id) {
            var detailUrl = "{{ route('keterampilan.detail', ':id') }}".replace(':id', id);
            $.ajax({
                url: detailUrl,
                type: 'GET',
                success: function(response) {
                    var dt = response.data;

                    // Populate the form with the current data
                    $('#editId').val(dt.id);
                    $('#editLembagaPenyelenggara').val(dt.lembaga_penyelenggara);
                    $('#editAlamatPenyelenggara').val(dt.alamat_penyelenggara);
                    $('#editLulusTahun').val(dt.lulus_tahun);
                    $('#editNoSertifikat').val(dt.no_sertifikat);
                    $('#editLembagaPenguji').val(dt.lembaga_penguji);

                    // Show the modal
                    $('#modal-edit').modal('show');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }

        function updateKeterampilan() {
            var id = $('#editId').val();
            var formData = {
                lembaga_penyelenggara: $('#editLembagaPenyelenggara').val(),
                alamat_penyelenggara: $('#editAlamatPenyelenggara').val(),
                lulus_tahun: $('#editLulusTahun').val(),
                no_sertifikat: $('#editNoSertifikat').val(),
                lembaga_penguji: $('#editLembagaPenguji').val(),
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: "{{ route('keterampilan.update', ':id') }}".replace(':id', id),
                type: 'PUT',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert('Keterampilan berhasil diperbarui');
                        $('#modal-edit').modal('hide');
                        location.reload();
                    } else {
                        alert('Gagal memperbarui keterampilan');
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });
        }
    </script>


    <script>
        function confirmDelete(id) {
            var deleteUrl = "{{ route('keterampilan.softdelete', ':id') }}".replace(':id', id);
            if (confirm("Yakin hapus data?")) {
                // Send a request to the server to soft delete the record
                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        alert(response.message);
                        // Reload the table or list after deletion
                        $('#simpletable').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            }
        }
    </script>
@endpush
