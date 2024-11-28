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
                        <div class="container mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Cetak AK1 - Pencarian KTP</h5>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="{{ route('ak1.existing') }}">
                                        <div class="mb-3">
                                            <label for="ktp" class="form-label">Masukkan Nomor KTP</label>
                                            <input type="text" id="ktp" name="ktp" class="form-control"
                                                value="{{ request('ktp') }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Cari KTP</button>
                                    </form>
                                </div>
                            </div>

                            @if ($user)
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5>Detail Profil</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $kabkotas = getKabkota();
                                        $pendidikans = getPendidikan();
                                        $maritals = getMarital();
                                        $agamas = getAgama();
                                        $sektors = getSektor();
                                        $statusKerjas = getStatusKerja();
                                        ?>
                                        <form method="POST" action="{{ route('ak1.update', $user->id) }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Lengkap</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                    value="{{ $user->name }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="ktp" class="form-label">KTP</label>
                                                <input type="text" id="ktp" name="ktp" class="form-control"
                                                    value="{{ $user->pencari->ktp }}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <input type="text" id="alamat" name="alamat" class="form-control"
                                                    value="{{ $user->pencari->alamat ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                                    class="form-control" value="{{ $user->pencari->tanggal_lahir ?? '' }}">
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="kodepos">Kode Pos</label>
                                                    <input type="text" id="kodepos" class="form-control" name="kodepos"
                                                        value="{{ $user->pencari->kodepos }}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="agama" class="form-label">Agama</label>
                                                    <select class="form-select" id="agama_id" name="agama_id" required>
                                                        <option selected disabled>Pilih Agama</option>
                                                        @foreach ($agamas as $ag)
                                                            <option value="{{ $ag->id }}"
                                                                {{ $user->pencari->id_agama == $ag->id ? 'selected' : '' }}>
                                                                {{ $ag->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Add other fields as required -->

                                            <button type="submit" class="btn btn-success mt-3">Update</button>
                                            <a href="{{ route('ak1.print', $user->id) }}"
                                                class="btn btn-primary mt-3">Cetak AK1</a>
                                        </form>
                                    </div>
                                </div>
                            @elseif(request('ktp'))
                                <div class="alert alert-warning mt-4">
                                    Data tidak ditemukan untuk KTP: {{ request('ktp') }}
                                </div>
                            @endif
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
