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
                                        <h1 class="mb-1">Rekap Form Sipet</h1>
                                        <p class="text-muted mb-4">Ringkasan klik WhatsApp (login vs publik), tanpa daftar
                                            detail.</p>

                                        <div class="alert alert-info mb-4">
                                            Periode:
                                            <strong>{{ $isFiltered ? 'Filter tanggal aktif' : 'Semua tanggal' }}</strong>
                                        </div>

                                        <div class="row g-2 align-items-end mb-4">
                                            <div class="col-md-3">
                                                <label for="start-date" class="form-label">Tanggal mulai</label>
                                                <input type="date" id="start-date" class="form-control"
                                                    value="{{ $startDate }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="end-date" class="form-label">Tanggal akhir</label>
                                                <input type="date" id="end-date" class="form-control"
                                                    value="{{ $endDate }}">
                                            </div>
                                            <div class="col-md-6 d-flex flex-wrap gap-2">
                                                <a href="#" id="apply-filter" class="btn btn-primary">Terapkan
                                                    filter</a>
                                                <a href="#" id="reset-filter"
                                                    class="btn btn-outline-secondary">Reset</a>
                                                <a href="#" id="export-excel" class="btn btn-success">Download
                                                    Excel</a>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3">
                                            <div class="col-md-4">
                                                <div class="card h-100 border-primary">
                                                    <div class="card-body">
                                                        <span class="d-block mb-1 text-muted">Total klik</span>
                                                        <h2 class="mb-0 text-primary">{{ number_format($countTotal) }}</h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card h-100 border-success">
                                                    <div class="card-body">
                                                        <span class="d-block mb-1 text-muted">Dari web publik</span>
                                                        <h2 class="mb-0 text-success">{{ number_format($countPublik) }}</h2>
                                                        <small class="text-muted">Belum login</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card h-100 border-warning">
                                                    <div class="card-body">
                                                        <span class="d-block mb-1 text-muted">Dari login (admin /
                                                            pengguna)</span>
                                                        <h2 class="mb-0 text-warning">{{ number_format($countAdmin) }}</h2>
                                                        <small class="text-muted">Sudah login</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($countLainnya > 0)
                                            <div class="alert alert-secondary mb-0">
                                                Data lain (format lama / tidak terklasifikasi):
                                                <strong>{{ number_format($countLainnya) }}</strong>
                                            </div>
                                        @endif
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
        function buildFilterQueryString() {
            const params = new URLSearchParams();
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            if (startDate) params.append('start_date', startDate);
            if (endDate) params.append('end_date', endDate);
            return params.toString();
        }

        function buildExportUrl(baseUrl) {
            const q = buildFilterQueryString();
            return q ? `${baseUrl}?${q}` : baseUrl;
        }

        document.getElementById('apply-filter').addEventListener('click', function(e) {
            e.preventDefault();
            const q = buildFilterQueryString();
            const baseUrl = '{{ route('data.sipet') }}';
            window.location.href = q ? `${baseUrl}?${q}` : baseUrl;
        });

        document.getElementById('reset-filter').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '{{ route('data.sipet') }}';
        });

        document.getElementById('export-excel').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = buildExportUrl('{{ route('data.sipet.export.excel') }}');
        });
    </script>
@endpush
