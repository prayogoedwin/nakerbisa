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
                                                    <label for="yearFilter" class="form-label">Filter Tahun</label>
                                                    <?php
                                                    $currentYear = date('Y'); // Current year
                                                    $startYear = $currentYear - 2; // 2 years back
                                                    $endYear = $currentYear + 1; // This year + 1
                                                    ?>
                                                    <select id="yearFilter" class="form-select" name="year">
                                                        <option value="">Semua Tahun</option>
                                                        <?php for ($year = $startYear; $year <= $endYear; $year++): ?>
                                                        <option value="<?= $year ?>"><?= $year ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                            </div>
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
                                        <button id="printButton" class="btn btn-primary">
                                            <i class="fa fa-print"></i> Cetak PDF
                                        </button>
                                        <div class="table-responsive">
                                            <table id="penempatanTable" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Jenis Penempatan</th>
                                                        <th>Gender L</th>
                                                        <th>Gender P</th>
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
            let table = $('#penempatanTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('rekap.penempatan.index') }}',
                    data: function(d) {
                        // Add selected month and year to the request data
                        d.month = $('#monthFilter').val();
                        d.year = $('#yearFilter').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'jenis_penempatan',
                        name: 'jenis_penempatan'
                    },
                    {
                        data: 'gender_l', // Column for Gender L
                        name: 'gender_l'
                    },
                    {
                        data: 'gender_p', // Column for Gender P
                        name: 'gender_p'
                    }
                ]
            });

            // Reload the table when the month filter is changed
            $('#monthFilter').on('change', function() {
                table.ajax.reload();
            });

            // Reload the table when the year filter is changed
            $('#yearFilter').on('change', function() {
                table.ajax.reload();
            });

            // Print button functionality
            $('#printButton').on('click', function() {
                window.open('{{ route('rekap.penempatan.print') }}', '_blank');
            });
        });
    </script>
@endpush
