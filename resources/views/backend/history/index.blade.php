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
                                            <table id="historyTable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Judul Lowongan</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Tanggal Berakhir</th>
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
            $('#historyTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('lowongan.history') }}', // Route untuk mengambil data
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'judul_lowongan',
                        name: 'judul_lowongan'
                    },
                    {
                        data: 'tanggal_start',
                        name: 'tanggal_start'
                    },
                    {
                        data: 'tanggal_end',
                        name: 'tanggal_end'
                    },
                ],
                autoWidth: false,
            });
        });
    </script>
@endpush
