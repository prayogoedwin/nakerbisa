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
                                                        <th>File</th>
                                                        <th>Description</th>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="registerForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">Judul</label>
                                    <textarea class="form-control" id="name" name="name" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="cover">Upload File</label>
                                    <input type="file" class="form-control" id="cover" name="cover">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="2"></textarea>
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
                                <button class="btn btn-danger mt-3">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" enctype="multipart/form-data">
                        <input type="hidden" id="editId" name="id">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="editName">Judul</label>
                                    <textarea class="form-control" id="editName" name="name" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="editPathFile">Upload File</label>
                                    <input type="file" class="form-control" id="editPathFile" name="cover">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="editDescription">Description</label>
                                    <textarea class="form-control" id="editDescription" name="description" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="editStatus">Status</label>
                                    <select class="form-control" id="editStatus" name="status">
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary mt-3" type="submit">Submit</button>
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
            $('#description').summernote({
                height: 300, // set the height of the editor
                callbacks: {
                    onImageUpload: function(files) {
                        var editor = $(this);
                        sendFile(files[0], editor);
                    }
                }
            });

            // Function to send the image to the server
            function sendFile(file, editor) {
                var data = new FormData();
                data.append("file", file);
                data.append("_token", "{{ csrf_token() }}"); // Menambahkan CSRF Token

                $.ajax({
                    url: '{{ route('berita.uploadImage') }}', // URL untuk menangani upload gambar
                    method: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            var imageUrl = response.image_url;
                            // Menambahkan gambar ke dalam Summernote
                            editor.summernote('insertImage', imageUrl);
                        } else {
                            alert('Gagal mengupload gambar');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan saat mengupload gambar');
                    }
                });
            }
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
                        data: 'description'
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

        $('#registerForm').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: 'POST',
                url: '{{ route('berita.add') }}',
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
    </script>

    <script>
        function showEditModal(id) {
            var editUrl = "{{ route('berita.edit', ':id') }}".replace(':id', id);
            $.ajax({
                url: editUrl,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#editId').val(data.id);
                        $('#editName').val(data.name);
                        $('#editStatus').val(data.status);
                        $('#editDescription').summernote('code', data
                            .description); // Menetapkan deskripsi ke editor Summernote
                        $('#editModal').modal('show');
                    } else {
                        alert('Error: ' + response.message);
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
