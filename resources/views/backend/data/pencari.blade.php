@extends('backend.template.backend')

@section('content')
    <!-- Layout wrapper -->
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
                                        <h1>Data Pencari Kerja</h1>
                                        <div class="table-responsive">
                                            <table id="pencari-table" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nama</th>
                                                        <th>Alamat</th>
                                                        <th>Actions</th>
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
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- Modal for Editing Data Pencari Kerja -->
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Pencari Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId">
                        <div class="form-group">
                            <label for="editName">Nama</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editAlamat">Alamat</label>
                            <input type="text" class="form-control" id="editAlamat" name="alamat" required>
                        </div>
                        <button type="button" class="btn btn-primary mt-3" onclick="updatePencari()">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#pencari-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('data.pencari') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            return `<button class="btn btn-primary btn-sm" onclick="showEditModal(${data})">Edit</button>`;
                        }
                    }
                ],
                language: {
                    emptyTable: "Tidak ada data tersedia di tabel",
                    processing: "Memproses...",
                },
            });
        });

        function showEditModal(id) {
            var detailUrl = "{{ route('data.pencari.detail', ':id') }}".replace(':id', id);
            $.ajax({
                url: detailUrl,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        let data = response.data;
                        $('#editId').val(data.id);
                        $('#editName').val(data.name);
                        $('#editAlamat').val(data.alamat);
                        $('#modal-edit').modal('show');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }

        function updatePencari() {
            var formData = {
                id: $('#editId').val(),
                name: $('#editName').val(),
                alamat: $('#editAlamat').val(),
                _token: "{{ csrf_token() }}"
            };

            $.ajax({
                url: "{{ route('data.pencari.update', ':id') }}".replace(':id', formData.id),
                type: 'PUT',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        $('#modal-edit').modal('hide');
                        $('#pencari-table').DataTable().ajax.reload();
                    } else {
                        alert('Gagal memperbarui data');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    </script>
@endpush
