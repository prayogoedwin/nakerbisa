@extends('backend.template.backend')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-end mb-3">
                                            <div class="col-sm-4">
                                                <label for="filter-pendidikan" class="form-label">Filter Jenjang Pendidikan</label>
                                                <select id="filter-pendidikan" class="form-select">
                                                    <option value="">Semua Jenjang</option>
                                                    @foreach ($pendidikans as $pendidikan)
                                                        <option value="{{ $pendidikan->id }}">{{ $pendidikan->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-8 text-end">
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modal-add"><i class="feather icon-plus"></i> Add
                                                    Jurusan</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="jurusan-table" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Jurusan</th>
                                                        <th>Jenjang Pendidikan</th>
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
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Jurusan</label>
                            <input class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="id_pendidikans">Jenjang Pendidikan</label>
                            <select class="form-select" id="id_pendidikans" name="id_pendidikans" required>
                                <option value="">Pilih Jenjang</option>
                                @foreach ($pendidikans as $pendidikan)
                                    <option value="{{ $pendidikan->id }}">{{ $pendidikan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId">
                        <div class="mb-3">
                            <label class="form-label" for="editNama">Nama Jurusan</label>
                            <input class="form-control" id="editNama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="editPendidikan">Jenjang Pendidikan</label>
                            <select class="form-select" id="editPendidikan" required>
                                <option value="">Pilih Jenjang</option>
                                @foreach ($pendidikans as $pendidikan)
                                    <option value="{{ $pendidikan->id }}">{{ $pendidikan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary" type="button" onclick="updateJurusan()">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let jurusanTable;
        $(document).ready(function() {
            jurusanTable = $('#jurusan-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('jurusan.index') }}',
                    data: function(d) {
                        d.pendidikan_id = $('#filter-pendidikan').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'pendidikan_name',
                        defaultContent: '-'
                    },
                    {
                        data: 'options',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#filter-pendidikan').change(function() {
                jurusanTable.ajax.reload();
            });

            $('#addForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('jurusan.add') }}',
                    data: {
                        nama: $('#nama').val(),
                        id_pendidikans: $('#id_pendidikans').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Berhasil menambahkan data');
                            $('#modal-add').modal('hide');
                            $('#addForm')[0].reset();
                            jurusanTable.ajax.reload();
                        } else {
                            alert('Gagal menambahkan data');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let message = '';
                            $.each(xhr.responseJSON.errors, function(_, val) {
                                message += val[0] + '\n';
                            });
                            alert(message);
                        } else {
                            alert('Terjadi kesalahan');
                        }
                    }
                });
            });
        });

        function showEditModal(id) {
            var detailUrl = "{{ route('jurusan.detail', ':id') }}".replace(':id', id);
            $.ajax({
                url: detailUrl,
                type: 'GET',
                success: function(response) {
                    if (!response.success) {
                        alert(response.message || 'Data tidak ditemukan');
                        return;
                    }
                    let dt = response.data;
                    $('#editId').val(dt.id);
                    $('#editNama').val(dt.nama);
                    $('#editPendidikan').val(dt.id_pendidikans);
                    $('#modal-edit').modal('show');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }

        function updateJurusan() {
            var id = $('#editId').val();
            $.ajax({
                url: "{{ route('jurusan.update', ':id') }}".replace(':id', id),
                type: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    nama: $('#editNama').val(),
                    id_pendidikans: $('#editPendidikan').val()
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#modal-edit').modal('hide');
                        jurusanTable.ajax.reload();
                    } else {
                        alert(response.message || 'Gagal update data');
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let message = '';
                        $.each(xhr.responseJSON.errors, function(_, val) {
                            message += val[0] + '\n';
                        });
                        alert(message);
                    } else {
                        alert('Terjadi kesalahan');
                    }
                }
            });
        }

        function confirmDelete(id) {
            if (!confirm("Yakin hapus data?")) {
                return;
            }
            var deleteUrl = "{{ route('jurusan.delete', ':id') }}".replace(':id', id);
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    alert(response.message);
                    jurusanTable.ajax.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    </script>
@endpush
