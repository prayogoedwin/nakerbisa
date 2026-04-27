@extends('backend.template.backend')

@section('content')
    <style>
        .pencari-toolbar .form-label {
            font-size: 12px;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .pencari-toolbar .form-control {
            height: 38px;
            font-size: 14px;
        }

        .pencari-toolbar .btn {
            height: 38px;
            padding: 0 14px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .pencari-toolbar .btn-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
    </style>
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
                                        <h1>Data Tenaga Kerja</h1>
                                        <div class="row g-2 align-items-end mb-3 pencari-toolbar">
                                            <div class="col-md-3">
                                                <label for="start-date" class="form-label">Start Date</label>
                                                <input type="date" id="start-date" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="end-date" class="form-label">End Date</label>
                                                <input type="date" id="end-date" class="form-control">
                                            </div>
                                            <div class="col-md-6 btn-wrap">
                                                <a href="#" id="apply-filter" class="btn btn-primary">Filter</a>
                                                <a href="#" id="reset-filter" class="btn btn-outline-secondary">Reset</a>
                                                <a href="#" id="export-csv" class="btn btn-success">Export CSV</a>
                                                <a href="#" id="export-excel" class="btn btn-success">Export Excel</a>
                                                <a href="#" id="export-excel-ayokerjo" class="btn btn-success">Export Excel (Ayokerjo)</a>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="pencari-table" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>KTP</th>
                                                        <th>Nama</th>
                                                        <th>Alamat</th>
                                                        <th>Tempat Lahir</th>
                                                        <th>Tanggal Lahir</th>
                                                        <th>Gender</th>
                                                        <th>Kodepos</th>
                                                        <th>Tahun Lulus</th>
                                                        <th>Medsos</th>
                                                        <th>Status Perkawinan</th>
                                                        <th>Agama</th>
                                                        <th>Pendidikan</th>
                                                        <th>Jurusan</th>
                                                        <th>Kota</th>
                                                        <th>Kecamatan</th>
                                                        <th>Desa</th>
                                                        <th>Status Saat Ini</th>
                                                        <th>Sektor Pekerjaan Saat Ini</th>
                                                        <th>Jam Kerja</th>
                                                        <th>Gaji</th>
                                                        <th>Tanggal Input</th>
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
            let table = $('#pencari-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('data.pencari') }}',
                    data: function(d) {
                        d.start_date = $('#start-date').val();
                        d.end_date = $('#end-date').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'ktp',
                        name: 'ktp'
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
                        data: 'tempat_lahir',
                        name: 'tempat_lahir'
                    },
                    {
                        data: 'tanggal_lahir',
                        name: 'tanggal_lahir'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'kodepos',
                        name: 'kodepos'
                    },
                    {
                        data: 'tahun_lulus',
                        name: 'tahun_lulus'
                    },
                    {
                        data: 'medsos',
                        name: 'medsos'
                    },
                    {
                        data: 'marital',
                        name: 'marital'
                    },
                    {
                        data: 'agama',
                        name: 'agama'
                    },
                    {
                        data: 'pendidikan',
                        name: 'pendidikan'
                    },
                    {
                        data: 'jurusan',
                        name: 'jurusan'
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'sektor',
                        name: 'sektor'
                    },
                    {
                        data: 'jam_kerja',
                        name: 'jam_kerja'
                    },
                    {
                        data: 'gaji',
                        name: 'gaji'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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

            function buildExportUrl(baseUrl) {
                const searchValue = table.search();
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();
                let url = baseUrl + '?search=' + encodeURIComponent(searchValue);
                if (startDate) {
                    url += '&start_date=' + encodeURIComponent(startDate);
                }
                if (endDate) {
                    url += '&end_date=' + encodeURIComponent(endDate);
                }
                return url;
            }

            $('#apply-filter').on('click', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#reset-filter').on('click', function(e) {
                e.preventDefault();
                $('#start-date').val('');
                $('#end-date').val('');
                table.search('').draw();
            });

            $('#export-csv').on('click', function(e) {
                e.preventDefault();
                window.location.href = buildExportUrl('{{ route('data.pencari.export') }}');
            });

            $('#export-excel').on('click', function(e) {
                e.preventDefault();
                window.location.href = buildExportUrl('{{ route('data.pencari.export.excel') }}');
            });

            $('#export-excel-ayokerjo').on('click', function(e) {
                e.preventDefault();
                window.location.href = buildExportUrl('{{ route('data.pencari.export.excel.ayokerjo') }}');
            });
        });
    </script>
@endpush
