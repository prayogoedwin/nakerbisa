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
                                                <label for="filter-tipe-grup" class="form-label">Filter Tipe Grup</label>
                                                <select id="filter-tipe-grup" class="form-select">
                                                    <option value="">Semua Tipe</option>
                                                    @foreach ($tipeGrupOptions as $value => $label)
                                                        <option value="{{ $value }}">{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-8 text-end">
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modal-add"><i class="feather icon-plus"></i> Add
                                                    Grup</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="grup-whatsapp-table" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>ID</th>
                                                        <th>Tipe Grup</th>
                                                        <th>Link Grup</th>
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
                    <h5 class="modal-title">Tambah Grup WhatsApp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="mb-3">
                            <label class="form-label" for="tipe_grup">Tipe Grup</label>
                            <select class="form-select" id="tipe_grup" name="tipe_grup" required>
                                <option value="">Pilih Tipe Grup</option>
                                @foreach ($tipeGrupOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="link_grup">Link Grup</label>
                            <input class="form-control" id="link_grup" name="link_grup" type="url" required>
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
                    <h5 class="modal-title">Edit Grup WhatsApp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId">
                        <div class="mb-3">
                            <label class="form-label" for="editTipeGrup">Tipe Grup</label>
                            <select class="form-select" id="editTipeGrup" required>
                                <option value="">Pilih Tipe Grup</option>
                                @foreach ($tipeGrupOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="editLinkGrup">Link Grup</label>
                            <input class="form-control" id="editLinkGrup" type="url" required>
                        </div>
                        <button class="btn btn-primary" type="button" onclick="updateGrupWhatsapp()">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let grupWhatsappTable;

        $(document).ready(function() {
            grupWhatsappTable = $('#grup-whatsapp-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('grup-whatsapp.index') }}',
                    data: function(d) {
                        d.tipe_grup = $('#filter-tipe-grup').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id'
                    },
                    {
                        data: 'tipe_grup'
                    },
                    {
                        data: 'link_grup',
                        render: function(data) {
                            return `<a href="${data}" target="_blank">${data}</a>`;
                        }
                    },
                    {
                        data: 'options',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#filter-tipe-grup').change(function() {
                grupWhatsappTable.ajax.reload();
            });

            $('#addForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('grup-whatsapp.add') }}',
                    data: {
                        tipe_grup: $('#tipe_grup').val(),
                        link_grup: $('#link_grup').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Berhasil menambahkan data');
                            $('#modal-add').modal('hide');
                            $('#addForm')[0].reset();
                            grupWhatsappTable.ajax.reload();
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
            var detailUrl = "{{ route('grup-whatsapp.detail', ':id') }}".replace(':id', id);
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
                    $('#editTipeGrup').val(dt.tipe_grup);
                    $('#editLinkGrup').val(dt.link_grup);
                    $('#modal-edit').modal('show');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }

        function updateGrupWhatsapp() {
            var id = $('#editId').val();
            $.ajax({
                url: "{{ route('grup-whatsapp.update', ':id') }}".replace(':id', id),
                type: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    tipe_grup: $('#editTipeGrup').val(),
                    link_grup: $('#editLinkGrup').val()
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#modal-edit').modal('hide');
                        grupWhatsappTable.ajax.reload();
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
            var deleteUrl = "{{ route('grup-whatsapp.delete', ':id') }}".replace(':id', id);
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    alert(response.message);
                    grupWhatsappTable.ajax.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    </script>
@endpush
