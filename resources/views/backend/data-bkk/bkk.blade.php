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
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h1>Data Bkk</h1>
                                        <a href="#" id="export-csv" class="btn btn-success">Export CSV</a>
                                        <div class="table-responsive">
                                            <table id="bkk-table" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nama</th>
                                                        <th>Penyedia Loker Luar Negeri</th>
                                                        <th>Deskripsi</th>
                                                        <th>Jenis BKk</th>
                                                        <th>Nomor Induk Berusaha</th>
                                                        <th>Sektor</th>
                                                        <th>Kota</th>
                                                        <th>Kecamatan</th>
                                                        <th>Desa</th>
                                                        <th>Alamat</th>
                                                        <th>Kodepos</th>
                                                        <th>Telpon</th>
                                                        <th>Jabatan</th>
                                                        <th>Website</th>
                                                        <th>Aksi</th>
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
            let table = $('#bkk-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('data.bkk') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'luar_negri',
                        name: 'luar_negri'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                    {
                        data: 'jenis_bkk',
                        name: 'jenis_bkk'
                    },
                    {
                        data: 'nib',
                        name: 'nib'
                    },
                    {
                        data: 'sektor',
                        name: 'sektor'
                    },
                    {
                        data: 'kota',
                        name: 'kota'
                    },
                    {
                        data: 'kecamatan',
                        name: 'kecamatan'
                    },
                    {
                        data: 'desa',
                        name: 'desa'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'kodepos',
                        name: 'kodepos'
                    },
                    {
                        data: 'telpon',
                        name: 'telpon'
                    },
                    
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                    {
                        data: 'website',
                        name: 'website'
                    },
                    {
                        data: 'options',
                        name: 'options',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    emptyTable: "Tidak ada data tersedia di tabel",
                    processing: "Memproses...",
                }
            });

            $('#export-csv').on('click', function(e) {
                e.preventDefault();
                let searchValue = table.search();

                let url = '{{ route('data.bkk.export') }}';
                url += '?search=' + encodeURIComponent(searchValue);

                window.location.href = url;
            });
        });
    </script>
@endpush
