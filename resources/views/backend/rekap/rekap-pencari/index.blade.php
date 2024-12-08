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
                                                <div class="mb-3">
                                                    <label for="monthFilter" class="form-label">Filter Bulan</label>
                                                    <select id="monthFilter" class="form-select">
                                                        <option value="">Semua Bulan</option>
                                                        <option value="1">Januari</option>
                                                        <option value="2">Februari</option>
                                                        <option value="3">Maret</option>
                                                        <option value="4">April</option>
                                                        <option value="5">Mei</option>
                                                        <option value="6">Juni</option>
                                                        <option value="7">Juli</option>
                                                        <option value="8">Agustus</option>
                                                        <option value="9">September</option>
                                                        <option value="10">Oktober</option>
                                                        <option value="11">November</option>
                                                        <option value="12">Desember</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <button id="exportCsvBtn" class="btn btn-success">Cetak CSV</button>
                                            <table id="simpletable" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Kecamatan</th>
                                                        <th>Sudah Bekerja (L)</th>
                                                        <th>Sudah Bekerja (P)</th>
                                                        <th>Belum Bekerja (L)</th>
                                                        <th>Belum Bekerja (P)</th>
                                                        <th>Tidak Bekerja (L)</th>
                                                        <th>Tidak Bekerja (P)</th>
                                                        <th class="table-secondary">Total Laki-laki</th>
                                                        <th class="table-secondary">Total Perempuan</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            <h5><strong>Keseluruhan Rembang:</strong> <span id="totalKeseluruhan">{{ $totalKeseluruhan }}</span></h5>
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
            let table = $('#simpletable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('rekap.tenaga-kerja.index') }}',
                    data: function(d) {
                        d.month = $('#monthFilter').val(); // Kirim parameter bulan
                    }
                },
                autoWidth: false,
                columns: [{
                        data: 'kecamatan'
                    },
                    {
                        data: 'sudah_bekerja_laki'
                    },
                    {
                        data: 'sudah_bekerja_perempuan'
                    },
                    {
                        data: 'belum_bekerja_laki'
                    },
                    {
                        data: 'belum_bekerja_perempuan'
                    },
                    {
                        data: 'tidak_bekerja_laki'
                    },
                    {
                        data: 'tidak_bekerja_perempuan'
                    },
                    {
                        data: 'total_laki'
                    },
                    {
                        data: 'total_perempuan'
                    }
                ]
            });

            // Reload tabel saat bulan dipilih
            $('#monthFilter').on('change', function() {
                table.ajax.reload();
            });

            // Fungsi untuk mengekspor CSV
            $('#exportCsvBtn').click(function() {
                let month = $('#monthFilter').val();
                window.location.href = '{{ route('rekap.tenaga-kerja.export') }}?month=' + month;
            });
        });
    </script>
@endpush
