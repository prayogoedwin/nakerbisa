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
                                                        <th>Judul</th>
                                                        <th>Cover</th>
                                                        <th>Status</th>
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



    <!-- Modal Add -->
    <div class="modal fade" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">Judul</label>
                                    <textarea class="form-control" id="name" name="name" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="cover">Cover</label>
                                    <input type="file" class="form-control" id="cover" name="cover">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary mt-3">Submit</button>
                                <button type="reset" class="btn btn-danger mt-3">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit-id">
                        <div class="row">
                            <!-- Judul -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="edit-name">Judul</label>
                                    <textarea class="form-control" id="edit-name" name="name" rows="2"></textarea>
                                </div>
                            </div>

                            <!-- Cover -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="edit-cover">Cover</label>
                                    <input type="file" class="form-control" id="edit-cover" name="cover">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="edit-description">Description</label>
                                    <textarea class="form-control" id="edit-description" name="description"></textarea>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="edit-status">Status</label>
                                    <select class="form-control" id="edit-status" name="status">
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>
                                <!-- Buttons -->
                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                <button type="reset" class="btn btn-danger mt-3">Clear</button>
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
        // ADD
        $(document).ready(function() {
            $('#description').summernote({
                height: 300, // Tinggi editor
                callbacks: {
                    onImageUpload: function(files) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            $('#description').summernote('insertImage', e.target.result);
                        };
                        reader.readAsDataURL(files[0]);
                    }
                }
            });

            $('#registerForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('berita.add') }}', // Sesuaikan dengan rute
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            alert('Berhasil menambahkan data');
                            $('#modal-report').modal('hide');
                            location.reload();
                        } else {
                            alert('Error: ' + JSON.stringify(response.errors));
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
        $(document).ready(function() {
            // Initialize Summernote
            $('#edit-description').summernote({
                height: 300,
                callbacks: {
                    onImageUpload: function(files) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            $('#edit-description').summernote('insertImage', e.target.result);
                        };
                        reader.readAsDataURL(files[0]);
                    }
                }
            });

            // Show Edit Modal and populate fields
            window.showEditModal = function(id) {
                const url = '{{ route('berita.edit', ':id') }}'.replace(':id', id);
                $.get(url, function(response) {
                    $('#edit-id').val(response.data.id);
                    $('#edit-name').val(response.data.name);
                    $('#edit-description').summernote('code', response.data.description);
                    $('#edit-status').val(response.data.status);
                    $('#modal-edit').modal('show');
                });
            };

            // Handle form submission for editing
            $('#editForm').submit(function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const id = $('#edit-id').val();
                const url = '{{ route('berita.update', ':id') }}'.replace(':id', id);

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            alert('Data berhasil diperbarui');
                            $('#modal-edit').modal('hide');
                            location.reload();
                        } else {
                            alert('Error: ' + JSON.stringify(response.errors));
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
        $(document).ready(function() {
            $('#simpletable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('berita.index') }}',
                autoWidth: false,
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'cover',
                        render: function(data) {
                            return data ?
                                `<a href="/storage/${data}" target="_blank">View File</a>` :
                                'No File';
                        }
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            return data == 1 ? 'Aktif' : 'Nonaktif';
                        }
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
        function confirmDelete(id) {
            if (confirm('Yakin hapus data?')) {
                var deleteUrl = "{{ route('berita.destroy', ':id') }}".replace(':id', id);

                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            }
        }
    </script>
@endpush
