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
                                @if (auth()->user()->roles[0]['name'] != 'super-admin')
                                    <li class="breadcrumb-item"><a href="{{ route('profil.index') }}">Profil</a></li>
                                @endif
                                <li class="breadcrumb-item active" aria-current="page">Tambah Data Keahlian & Keterampilan
                                </li>
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
                                                        <th>Keahlian</th>
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
                    <h5 class="modal-title">Tambah Keahlian & Keterampilan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        <div class="row">
                            <!-- Cek jika super-admin, tampilkan user_id -->
                            @if (auth()->user()->roles[0]['name'] == 'super-admin')
                                <input type="hidden" id="user_id" name="user_id" value="{{ request()->route('id') }}">
                            @else
                                <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
                            @endif
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="floating-label" for="keahlian">Keahlian</label>
                                    <input type="text" class="form-control" id="keahlian" name="keahlian">
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
                    <h5 class="modal-title" id="modalEditLabel">Edit Keahlian & Keterampilan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editKeterampilanForm">
                        <input type="hidden" id="editId">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="floating-label" for="edtiKeahlian">Keahlian</label>
                                <input type="text" class="form-control" id="edtiKeahlian" name="keahlian">
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
            var url = window.location.href; // Ambil URL saat ini
            var id = url.split('/').pop(); // Ambil id dari URL
            $('#simpletable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('dapur/profil/keahlian-keterampilan') }}/' + id, // Kirim id dari URL ke server
                autoWidth: false,
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'keahlian'
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
                keahlian: $('#keahlian').val(),
                _token: '{{ csrf_token() }}',
                user_id: $('#user_id').val() // Ambil nilai user_id dari input tersembunyi
            };

            $.ajax({
                type: 'POST',
                url: '{{ route('keahlian-keterampilan.add') }}',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert('Berhasil menambahkan data keahlian & keterampilan');
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
            var detailUrl = "{{ route('keahlian-keterampilan.detail', ':id') }}".replace(':id', id);
            $.ajax({
                url: detailUrl,
                type: 'GET',
                success: function(response) {
                    var dt = response.data;

                    // Populate the form with the current data
                    $('#editId').val(dt.id);
                    $('#edtiKeahlian').val(dt.keahlian);

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
                keahlian: $('#edtiKeahlian').val(),
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: "{{ route('keahlian-keterampilan.update', ':id') }}".replace(':id', id),
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
            var deleteUrl = "{{ route('keahlian-keterampilan.softdelete', ':id') }}".replace(':id', id);
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
