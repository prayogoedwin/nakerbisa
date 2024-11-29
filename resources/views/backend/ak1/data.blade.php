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
                        <h1>Data AK1</h1>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Tenaga Kerja</th>
                                    <th>Tanggal Cetak</th>
                                    <th>Status Cetak</th>
                                    <th>Berhenti Berlaku</th>
                                    <th>QR Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ak1s as $ak1)
                                    <tr>
                                        <td>{{ $ak1->id }}</td>
                                        <td>{{ $ak1->user->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($ak1->tanggal_cetak)->format('d-m-Y') }}</td>
                                        <td>{{ $ak1->status_cetak == '0' ? 'Mandiri' : 'Admin' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($ak1->berlaku_hingga)->format('d-m-Y') }}</td>
                                        <td><img src="{{ asset('storage/' . $ak1->qr) }}" width="50" alt="QR Code"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
