@extends('backend.template.backend')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">
                <div class="content-wrapper">
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
                                        <h1>Data Form Sipet</h1>

                                        <div class="alert alert-info">
                                            Total Data:
                                            <strong>{{ $countSipet }}</strong>
                                            ({{ $isFiltered ? 'Berdasarkan Filter Tanggal' : 'Semua Data' }})
                                        </div>

                                        <div class="row g-2 align-items-end mb-3">
                                            <div class="col-md-3">
                                                <label for="start-date" class="form-label">Start Date</label>
                                                <input type="date" id="start-date" class="form-control"
                                                    value="{{ $startDate }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="end-date" class="form-label">End Date</label>
                                                <input type="date" id="end-date" class="form-control"
                                                    value="{{ $endDate }}">
                                            </div>
                                            <div class="col-md-6 d-flex flex-wrap gap-2">
                                                <a href="#" id="apply-filter" class="btn btn-primary">Filter</a>
                                                <a href="#" id="reset-filter"
                                                    class="btn btn-outline-secondary">Reset</a>
                                                <a href="#" id="export-excel" class="btn btn-success">Download
                                                    Excel</a>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="sipet-table" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>No Whatsapp</th>
                                                        <th>Judul</th>
                                                        <th>Isi</th>
                                                        <th>Tanggal Input</th>
                                                        <th>IP</th>
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
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let table = $('#sipet-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('data.sipet') }}',
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
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'wa',
                        name: 'wa'
                    },
                    {
                        data: 'judu',
                        name: 'judu'
                    },
                    {
                        data: 'isi',
                        name: 'isi'
                    },
                    {
                        data: 'created_at_format',
                        name: 'created_at'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by',
                        visible: false
                    },
                    {
                        data: 'created_by_ip',
                        name: 'created_by_ip'
                    }
                ],
                language: {
                    emptyTable: "Tidak ada data tersedia di tabel",
                    processing: "Memproses...",
                }
            });

            function buildFilterQueryString() {
                const params = new URLSearchParams();
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();

                if (startDate) {
                    params.append('start_date', startDate);
                }
                if (endDate) {
                    params.append('end_date', endDate);
                }

                return params.toString();
            }

            function buildExportUrl(baseUrl) {
                const searchValue = table.search();
                const params = new URLSearchParams();
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();

                if (searchValue) {
                    params.append('search', searchValue);
                }
                if (startDate) {
                    params.append('start_date', startDate);
                }
                if (endDate) {
                    params.append('end_date', endDate);
                }

                const query = params.toString();
                return query ? `${baseUrl}?${query}` : baseUrl;
            }

            $('#apply-filter').on('click', function(e) {
                e.preventDefault();
                const query = buildFilterQueryString();
                const baseUrl = '{{ route('data.sipet') }}';
                window.location.href = query ? `${baseUrl}?${query}` : baseUrl;
            });

            $('#reset-filter').on('click', function(e) {
                e.preventDefault();
                window.location.href = '{{ route('data.sipet') }}';
            });

            $('#export-excel').on('click', function(e) {
                e.preventDefault();
                window.location.href = buildExportUrl('{{ route('data.sipet.export.excel') }}');
            });
        });
    </script>
@endpush
