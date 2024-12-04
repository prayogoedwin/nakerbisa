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
                        <h4 class="fw-bold py-3">Statistik</h4>

                        <!-- Row 1: Job Seekers -->
                        <h5 class="fw-bold py-3">Data Pencari Kerja</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div id="genderChart" style="width: 100%; height: 400px;"></div>
                            </div>
                            <div class="col-md-4">
                                <div id="educationChart" style="width: 100%; height: 400px;"></div>
                            </div>
                            <div class="col-md-4">
                                <div id="generationChart" style="width: 100%; height: 400px;"></div>
                            </div>
                        </div>

                        <hr />

                        <!-- Row 2: Companies -->
                        <h5 class="fw-bold py-3">Data Penyedia Kerja</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="sectorChart" style="width: 100%; height: 400px;"></div>
                            </div>
                            <div class="col-md-6">
                                <div id="cityChart" style="width: 100%; height: 400px;"></div>
                            </div>
                        </div>

                        <hr />

                        <!-- Row 1: Job Seekers and Job Vacancies -->
                        <h5 class="fw-bold py-3">Data Lowongan</h5>
                        <div class="row">
                            <!-- Existing Job Seeker Charts -->
                            <div class="col-md-4">
                                <div id="lowonganPendidikanChart" style="width: 100%; height: 400px;"></div>
                            </div>
                            <div class="col-md-4">
                                <div id="lowonganGenderChart" style="width: 100%; height: 400px;"></div>
                            </div>
                            <div class="col-md-4">
                                <div id="lowonganAktifChart" style="width: 100%; height: 400px;"></div>
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
    <!-- Include Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gender Chart (Job Seekers)
            var genderChartData = @json($genderChartData);
            var educationChartData = @json($educationChartData);
            var generationChartData = @json($generationChartData);
            var sectorChartData = @json($sectorCounts);
            var cityChartData = @json($cityCounts);
            var educationLowonganChartData = @json($educationCounts);
            var lowonganGenderChartData = @json($lowonganGenderChartData);
            var lowonganAktifChartData = @json($lowonganAktifChartData);

            Highcharts.chart('genderChart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Jumlah Pencari Kerja Berdasarkan Gender'
                },
                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: genderChartData
                }]
            });

            // Education Chart (Job Seekers)
            Highcharts.chart('educationChart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Jumlah Pencari Kerja Berdasarkan Pendidikan'
                },
                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: educationChartData
                }]
            });

            // Generation Chart (Job Seekers)
            Highcharts.chart('generationChart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Jumlah Pencari Kerja Berdasarkan Generasi'
                },
                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: generationChartData
                }]
            });

            // Sector Chart (Companies)
            Highcharts.chart('sectorChart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Jumlah Perusahaan Berdasarkan Sektor'
                },
                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: sectorChartData
                }]
            });

            // City Chart (Companies)
            Highcharts.chart('cityChart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Jumlah Perusahaan Berdasarkan Asal Kota'
                },
                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: cityChartData
                }]
            });

            // Lowongan Berdasarkan Pendidikan
            Highcharts.chart('lowonganPendidikanChart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Jumlah Lowongan Berdasarkan Pendidikan'
                },
                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: educationLowonganChartData
                }]
            });

            // Lowongan Berdasarkan Kebutuhan Gender
            Highcharts.chart('lowonganGenderChart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Jumlah Lowongan Berdasarkan Kebutuhan Gender'
                },
                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: lowonganGenderChartData
                }]
            });

            // Lowongan Berdasarkan Status Expired (Aktif/Expired)
            Highcharts.chart('lowonganAktifChart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Jumlah Lowongan Berdasarkan Status Expired'
                },
                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: lowonganAktifChartData
                }]
            });
        });
    </script>
@endpush
