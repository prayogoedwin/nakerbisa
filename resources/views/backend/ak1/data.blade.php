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
                                        <h1>Data AK1</h1>
                                        <div class="table-responsive">
                                            <table id="ak1table" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Tenaga Kerja</th>
                                                        <th>Tanggal Cetak</th>
                                                        <th>Status Cetak</th>
                                                        <th>Berhenti Berlaku</th>
                                                        <th>QR Code</th>
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
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#ak1table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('ak1.data') }}',
                autoWidth: false,
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_tenaga_kerja',
                        name: 'user.name'
                    },
                    {
                        data: 'tanggal_cetak',
                        name: 'tanggal_cetak'
                    },
                    {
                        data: 'status_cetak',
                        name: 'status_cetak'
                    },
                    {
                        data: 'berlaku_hingga',
                        name: 'berlaku_hingga'
                    },
                    {
                        data: 'qr_code',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
