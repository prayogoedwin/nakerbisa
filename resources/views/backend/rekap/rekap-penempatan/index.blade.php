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
                                        </div>
                                        <div class="table-responsive">
                                            <table id="penempatanTable" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Tenaga Kerja</th>
                                                        <th>Judul Lowongan</th>
                                                        <th>Lokasi Penempatan</th>
                                                        <th>Status</th>
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
@endsection


@push('js')
    <script>
        $(document).ready(function() {
            $('#penempatanTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('rekap.penempatan.index') }}', // Sesuaikan dengan rute penempatan
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'pencari_name'
                    },
                    {
                        data: 'lowongan_title'
                    },
                    {
                        data: 'lokasi_penempatan'
                    },
                    {
                        data: 'status_name'
                    }, // Menampilkan status_name dari query
                ]
            });
        });
    </script>
@endpush
