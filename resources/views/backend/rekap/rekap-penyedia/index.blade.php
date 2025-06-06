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
                                            <div class="col-sm-4">
                                                <div class="mb-3">
                                                    <label for="monthFilter" class="form-label">Filter Tahun</label>

                                                    <?php

                                                        $currentYear = date('Y'); // Tahun saat ini
                                                        $startYear = $currentYear - 2; // 5 tahun ke belakang
                                                        $endYear = $currentYear + 1; // Tahun ini + 1

                                                    ?>

                                                    <select id="yearFilter" class="form-select" name="year">
                                                        <option value="">Semua Tahun</option>
                                                        <?php for ($year = $startYear; $year <= $endYear; $year++): ?>
                                                           
                                                            <option value="<?= $year ?>" >
                                                                <?= $year ?>
                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="mb-3">
                                                    <label for="monthFilter" class="form-label">Filter Bulan</label>
                                                    <select id="monthFilter" class="form-select" name="month">
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
                                             <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label for="dateFilter" class="form-label">Filter Tanggal</label>
                                                <input type="date" id="dateFilter" class="form-control" name="tanggal">
                                            </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="simpletable" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kecamatan / Penyedia Kerja
                                                        </th>
                                                        <th class="table-secondary">Jumlah</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            <h5><strong>Total Keseluruhan:</strong> <span
                                                    id="totalKeseluruhan">{{ $totalKeseluruhan }}</span></h5>
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
                paging: false,
                searching: false, 
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('rekap.penyedia-kerja.index') }}',
                    data: function(d) {
                        d.month = $('#monthFilter').val(); // Kirim parameter bulan
                        d.year = $('#yearFilter').val(); // Kirim parameter bulan
                        d.tanggal = $('#dateFilter').val(); // Kirim parameter bulan
                    }
                },
                autoWidth: false,
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kecamatan'
                    },
                    {
                        data: 'total'
                    }
                ]
            });

            // Reload tabel saat bulan dipilih
            $('#monthFilter').on('change', function() {
                table.ajax.reload();
            });

            $('#yearFilter').on('change', function() {
                table.ajax.reload();
            });

             $('#dateFilter').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
