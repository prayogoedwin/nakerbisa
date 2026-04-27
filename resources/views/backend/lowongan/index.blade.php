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

                                            </div>

                                            @if (Auth::user()->roles[0]['name'] == 'penyedia-kerja')
                                                
                                            <div class="col-sm-6 text-end">
                                                <button class="btn btn-success btn-sm btn-round has-ripple"
                                                    data-bs-toggle="modal" data-bs-target="#modal-report"><i
                                                        class="feather icon-plus"></i> Add
                                                    Data</button>
                                            </div>

                                            @endif
                                            
                                        </div>
                                        <div class="table-responsive">
                                            <table id="simpletable" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Judul Lowongan</th>
                                                        <th>Perusahaan</th>
                                                        <th>Tgl Mulai</th>
                                                        <th>Tgl Selesai</th>
                                                        <th>Deskripsi</th>
                                                        <th>Status</th>
                                                        <th width="25%">Aksi</th>
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

    <div class="modal fade" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="tambahForm">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jab">Jabatan</label>
                                    <select class="form-control" name="jabatan_id" id="jabatan_id" required>
                                        <option value="">Pilih Jabatan</option>
                                        @foreach ($jabatans as $jab)
                                            <option value="{{ $jab->id }}">{{ $jab->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jab">Sektor</label>
                                    <select class="form-control" name="sektor_id" id="sektor_id" required>
                                        <option value="">Pilih Sektor</option>
                                        @foreach ($sektors as $sekt)
                                            <option value="{{ $sekt->id }}">{{ $sekt->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="jab">Tanggal Mulai</label>
                                        <input type="date" class="form-control" name="tanggal_start" id="tanggal_start">
                                    </div>
                                    <div class="col-6">
                                        <label for="jab">Tanggal Selesai</label>
                                        <input type="date" class="form-control" name="tanggal_end" id="tanggal_end">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{-- <label class="floating-label" for="jdllow">Judul Lowongan</label> --}}
                                    <label for="jab">Judul Lowongan</label>
                                    <textarea class="form-control" id="judul_lowongan" name="judul_lowongan" rows="3" placeholder="Judul Lowongan"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jab">Kabupaten / Kota</label>
                                    <select class="form-control" name="kabkota_id" id="kabkota_id" required>
                                        {{-- Didefaultkan value 1 --}}
                                        <option value="" selected>Pilih Kabkota</option>
                                            @foreach ($kabkotas as $kk)
                                            <option value="{{ $kk->id }}">{{ $kk->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{-- <label class="floating-label" for="pertanyaan">Lokasi Penempatan</label> --}}
                                        <label for="jab">Lokasi Penempatan</label>
                                        <input class="form-control" type="text" id="lokasi_penempatan_text"
                                            name="lokasi_penempatan_text" placeholder="Lokasi Penempatan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="floating-label" for="jumpri">Jumlah Pria</label>
                                        <input type="number" class="form-control" name="jumlah_pria" id="jumlah_pria">
                                    </div>
                                    <div class="col-6">
                                        <label class="floating-label" for="jumwat">Jumlah Wanita</label>
                                        <input type="number" class="form-control" name="jumlah_wanita"
                                            id="jumlah_wanita">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{-- <label class="floating-label" for="desk">Deskripsi</label> --}}
                                    <label for="jab">Deskripsi Pekerjaan</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi Pekerjaan"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="pendid">Pendidikan</label>
                                    <select class="form-control" name="pendidikan_id" id="pendidikan_id" required>
                                        <option value="">Pilih Pendidikan</option>
                                        @foreach ($pendidikans as $pend)
                                            <option value="{{ $pend->id }}">{{ $pend->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jur">Jurusan</label>
                                    <select class="form-control" name="jurusan_id" id="jurusan_id" required>
                                        <option selected disabled>Pilih Jurusan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="stskawin">Status Perkawinan</label>
                                    <select class="form-control" id="status_perkawinan_id" name="status_perkawinan_id"
                                        required>
                                        <option selected disabled>Pilih Status</option>
                                        @foreach ($maritals as $marit)
                                            <option value="{{ $marit->id }}">{{ $marit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-12">

                                <button class="float-end btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Lamar Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jab">Jabatan</label>
                                    <select class="form-control" name="jabatan_id" id="e_jabatan_id" required>
                                        <option value="">Pilih Jabatan</option>
                                        @foreach ($jabatans as $jab)
                                            <option value="{{ $jab->id }}">{{ $jab->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jab">Sektor</label>
                                    <select class="form-control" name="sektor_id" id="e_sektor_id" required>
                                        <option value="">Pilih Sektor</option>
                                        @foreach ($sektors as $sekt)
                                            <option value="{{ $sekt->id }}">{{ $sekt->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="jab">Tanggal Mulai</label>
                                        <input type="date" class="form-control" name="tanggal_start" id="e_tanggal_start">
                                    </div>
                                    <div class="col-6">
                                        <label for="jab">Tanggal Selesai</label>
                                        <input type="date" class="form-control" name="tanggal_end" id="e_tanggal_end">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label mb-1">Perusahaan</label>
                                    <div class="form-control-plaintext border rounded px-2 py-1" id="e_perusahaan_name">-</div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label mb-1">Alamat Perusahaan</label>
                                    <div class="form-control-plaintext border rounded px-2 py-1" id="e_perusahaan_alamat">-</div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{-- <label class="floating-label" for="jdllow">Judul Lowongan</label> --}}
                                    <label for="jab">Judul Lowongan</label>
                                    <textarea class="form-control" id="e_judul_lowongan" name="judul_lowongan" rows="3" placeholder="Judul Lowongan"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jab">Kabupaten / Kota</label>
                                    <select class="form-control" name="kabkota_id" id="e_kabkota_id" required>
                                        {{-- Didefaultkan value 1 --}}
                                        <option value="" selected>Pilih Kabkota</option>
                                            @foreach ($kabkotas as $kk)
                                            <option value="{{ $kk->id }}">{{ $kk->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{-- <label class="floating-label" for="pertanyaan">Lokasi Penempatan</label> --}}
                                        <label for="jab">Lokasi Penempatan</label>
                                        <input class="form-control" type="text" id="e_lokasi_penempatan_text"
                                            name="lokasi_penempatan_text" placeholder="Lokasi Penempatan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="floating-label" for="jumpri">Jumlah Pria</label>
                                        <input type="number" class="form-control" name="jumlah_pria" id="e_jumlah_pria">
                                    </div>
                                    <div class="col-6">
                                        <label class="floating-label" for="jumwat">Jumlah Wanita</label>
                                        <input type="number" class="form-control" name="jumlah_wanita"
                                            id="e_jumlah_wanita">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{-- <label class="floating-label" for="desk">Deskripsi</label> --}}
                                    <label for="jab">Deskripsi Pekerjaan</label>
                                    <textarea class="form-control" id="e_deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi Pekerjaan"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="pendid">Pendidikan</label>
                                    <select class="form-control" name="pendidikan_id" id="e_pendidikan_id" required>
                                        <option value="">Pilih Pendidikan</option>
                                        @foreach ($pendidikans as $pend)
                                            <option value="{{ $pend->id }}">{{ $pend->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jur">Jurusan</label>
                                    <select class="form-control" name="jurusan_id" id="e_jurusan_id" required>
                                        <option selected disabled>Pilih Jurusan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="stskawin">Status Perkawinan</label>
                                    <select class="form-control" id="e_status_perkawinan_id" name="status_perkawinan_id"
                                        required>
                                        <option selected disabled>Pilih Status</option>
                                        @foreach ($maritals as $marit)
                                            <option value="{{ $marit->id }}">{{ $marit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @if(Auth::user()->roles[0]->name == 'super-admin')
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="stskawin">Status Acc</label>
                                    <select class="form-control" id="e_status_id" name="status_id" required>
                                        <option selected disabled>Pilih Status</option>
                                        @foreach ($progresloker as $pl)
                                            <option value="{{ $pl->kode }}">{{ $pl->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                                <div class="col-sm-6" hidden>
                                    <div class="form-group">
                                        <label for="stskawin">Status Acc</label>
                                        <input type="text" class="form-control" id="e_status_id" name="status_id" 
                                             readonly >
                                    </div>
                                </div>
                            @endif
                        

                            <div class="row" style="margin-top:10px">
                                <div class="col-sm-12">
                                    <button type="submit" class="float-end btn btn-primary">Update</button>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="lamarForm">
                        <input type="hidden" id="detailId" name="id">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jab">Jabatan</label>
                                    <select class="form-control" name="jabatan_id" id="d_jabatan_id" required disabled>
                                        @foreach ($jabatans as $jab)
                                            <option value="{{ $jab->id }}">{{ $jab->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jab">Sektor</label>
                                    <select class="form-control" name="sektor_id" id="d_sektor_id" required disabled>
                                        @foreach ($sektors as $sekt)
                                            <option value="{{ $sekt->id }}">{{ $sekt->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="jab">Tanggal Mulai</label>
                                        <input type="date" class="form-control" name="tanggal_start" id="d_tanggal_start" disabled>
                                    </div>
                                    <div class="col-6">
                                        <label for="jab">Tanggal Selesai</label>
                                        <input type="date" class="form-control" name="tanggal_end" id="d_tanggal_end" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-2">
                                    <label class="form-label mb-1">Perusahaan</label>
                                    <div class="form-control-plaintext border rounded px-2 py-1" id="d_perusahaan_name">-</div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-2">
                                    <label class="form-label mb-1">Alamat Perusahaan</label>
                                    <div class="form-control-plaintext border rounded px-2 py-1" id="d_perusahaan_alamat">-</div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{-- <label class="floating-label" for="jdllow">Judul Lowongan</label> --}}
                                    <label for="jab">Judul Lowongan</label>
                                    <textarea class="form-control" id="d_judul_lowongan" name="judul_lowongan" rows="3" placeholder="Judul Lowongan" disabled></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jab">Kabupaten / Kota</label>
                                    <select class="form-control" name="kabkota_id" id="d_kabkota_id" required disabled>
                                        {{-- Didefaultkan value 1 --}}
                                        <option value="" selected>Pilih Kabkota</option>
                                            @foreach ($kabkotas as $kk)
                                            <option value="{{ $kk->id }}">{{ $kk->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{-- <label class="floating-label" for="pertanyaan">Lokasi Penempatan</label> --}}
                                        <label for="jab">Lokasi Penempatan</label>
                                        <input class="form-control" type="text" id="d_lokasi_penempatan_text"
                                            name="lokasi_penempatan_text" placeholder="Lokasi Penempatan" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="floating-label" for="jumpri">Jumlah Pria</label>
                                        <input type="number" class="form-control" name="jumlah_pria" id="d_jumlah_pria" disabled>
                                    </div>
                                    <div class="col-6">
                                        <label class="floating-label" for="jumwat">Jumlah Wanita</label>
                                        <input type="number" class="form-control" name="jumlah_wanita"
                                            id="d_jumlah_wanita" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{-- <label class="floating-label" for="desk">Deskripsi</label> --}}
                                    <label for="jab">Deskripsi Pekerjaan</label>
                                    <textarea class="form-control" id="d_deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi Pekerjaan" disabled></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="pendid">Pendidikan</label>
                                    <select class="form-control" name="pendidikan_id" id="d_pendidikan_id" required disabled>
                                        <option value="">Pilih Pendidikan</option>
                                        @foreach ($pendidikans as $pend)
                                            <option value="{{ $pend->id }}">{{ $pend->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jur">Jurusan</label>
                                    <select class="form-control" name="jurusan_id" id="d_jurusan_id" required disabled>
                                        <option selected disabled>Pilih Jurusan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="stskawin">Status Perkawinan</label>
                                    <select class="form-control" id="d_status_perkawinan_id" name="status_perkawinan_id"
                                        required disabled>
                                        <option selected disabled>Pilih Status</option>
                                        @foreach ($maritals as $marit)
                                            <option value="{{ $marit->id }}">{{ $marit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @if(Auth::user()->roles[0]->name == 'super-admin')
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="stskawin">Status Acc</label>
                                    <select class="form-control" id="d_status_id" name="status_id" required disabled>
                                        <option selected disabled>Pilih Status</option>
                                        @foreach ($progresloker as $pl)
                                            <option value="{{ $pl->kode }}">{{ $pl->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                                <div class="col-sm-6" hidden>
                                    <div class="form-group">
                                        <label for="stskawin">Status Acc</label>
                                        <input type="text" class="form-control" id="d_status_id" name="status_id" 
                                             readonly >
                                    </div>
                                </div>
                            @endif
                        

                            <div class="row" style="margin-top:10px">
                                <div class="col-sm-12">
                                    <button type="submit" class="float-end btn btn-primary">Lamar</button>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(function() {
            $('#simpletable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('lowongan.index') }}',
                autoWidth: false, // Menonaktifkan auto-width
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'judul_lowongan'
                    },
                    {
                        data: 'perusahaan_name',
                        defaultContent: '-'
                    },
                    {
                        data: 'tanggal_start'
                    },
                    {
                        data: 'tanggal_end'
                    },
                    {
                        data: 'deskripsi'
                    },
                    {
                        data: 'progres_name'
                    },
                    {
                        data: 'options',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#tambahForm').submit(function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                // Clear previous error messages
                $('#errorMessages').html('').addClass('d-none');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('lowongan.add') }}', // Ganti dengan rute yang sesuai
                    data: {
                        jabatan_id: $('#jabatan_id').val(),
                        sektor_id: $('#sektor_id').val(),
                        tanggal_start: $('#tanggal_start').val(),
                        tanggal_end: $('#tanggal_end').val(),
                        judul_lowongan: $('#judul_lowongan').val(),
                        kabkota_id: $('#kabkota_id').val(),
                        lokasi_penempatan_text: $('#lokasi_penempatan_text').val(),
                        jumlah_pria: $('#jumlah_pria').val(),
                        jumlah_wanita: $('#jumlah_wanita').val(),
                        deskripsi: $('#deskripsi').val(),
                        pendidikan_id: $('#pendidikan_id').val(),
                        jurusan_id: $('#jurusan_id').val(),
                        marital_id: $('#status_perkawinan_id').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Berhasil menambahkan data');
                            $('#modal-report').modal('hide');
                            location.reload(); // Refresh halaman
                        } else {
                            // If validation errors are found, display them in an alert
                            if (response.errors) {
                                let errorMessages = '';
                                $.each(response.errors, function(key, value) {
                                    $.each(value, function(index, errorMessage) {
                                        errorMessages += errorMessage +
                                            '\n'; // Gabungkan pesan error
                                    });
                                });
                                alert('Terjadi kesalahan:\n' + errorMessages);
                            } else {
                                alert('Gagal menambahkan data');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });
        });
    </script>

    <script>
        function showEditModal(id) {
            var detailUrl = "{{ route('lowongan.detail', ':id') }}".replace(':id', id);

            $.ajax({
                url: detailUrl,
                type: 'GET',
                success: function(response) {
                    let dt = response.data;

                    // Isi data modal dengan data yang diperoleh
                    $('#editId').val(dt.id);
                    $('#editPertanyaan').val(dt.name);
                    $('#editJawaban').val(dt.description);
                    $('#e_jabatan_id').val(dt.jabatan_id);
                    $('#e_sektor_id').val(dt.sektor_id);
                    $('#e_tanggal_start').val(dt.tanggal_start);
                    $('#e_tanggal_end').val(dt.tanggal_end);
                    $('#e_perusahaan_name').text(dt.perusahaan_name ?? '-');
                    $('#e_perusahaan_alamat').text(dt.perusahaan_alamat ?? '-');
                    $('#e_judul_lowongan').val(dt.judul_lowongan);
                    $('#e_kabkota_id').val(dt.kabkota_id);
                    $('#e_lokasi_penempatan_text').val(dt.lokasi_penempatan_text);
                    $('#e_jumlah_pria').val(dt.jumlah_pria);
                    $('#e_jumlah_wanita').val(dt.jumlah_wanita);
                    $('#e_deskripsi').val(dt.deskripsi);
                    $('#e_pendidikan_id').val(dt.pendidikan_id);
                    $('#e_status_perkawinan_id').val(dt.marital_id);
                    $('#e_status_id').val(dt.status_id);

                    // Pastikan hanya memanggil loadJurusanByPendidikan jika pendidikan_id ada
                    var pendidikanId = dt.pendidikan_id;
                    if (pendidikanId) {
                        loadJurusanByPendidikan(pendidikanId, '#e_jurusan_id', dt.jurusan_id); // Panggil fungsi untuk mengisi data
                    }

                    // Tampilkan modal edit
                    $('#modal-edit').modal('show');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }

        // Fungsi untuk memuat data jurusan berdasarkan pendidikan_id
        function loadJurusanByPendidikan(kd, targetDropdown, selectedJurusanId) {
            if (!kd) return; // Pastikan kd (pendidikan_id) tidak kosong

            // Panggil API untuk mendapatkan jurusan
            $.ajax({
                url: "{{ route('get-jurusan-bypendidikan', ':id') }}".replace(':id', kd),
                type: 'GET',
                success: function(response) {
                    // Kosongkan dropdown sebelumnya
                    $(targetDropdown).empty();

                    // Tambahkan opsi default
                    $(targetDropdown).append('<option selected disabled>Pilih Jurusan</option>');

                    // Tambahkan data jurusan ke dropdown
                    $.each(response, function(index, jurusan) {
                        $(targetDropdown).append('<option value="' + jurusan.id + '">' + jurusan.nama + '</option>');
                    });

                    // Pilih jurusan_id yang sudah ada
                    if (selectedJurusanId) {
                        $(targetDropdown).val(selectedJurusanId); // Pilih nilai jurusan yang sudah ada
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }
    </script>

    <script>
        function showDetailModal(id) {
            var detailUrl = "{{ route('lowongan.detail', ':id') }}".replace(':id', id);

            $.ajax({
                url: detailUrl,
                type: 'GET',
                success: function(response) {
                    let dt = response.data;

                    // Isi data modal dengan data yang diperoleh
                    $('#detailId').val(dt.id);
                    $('#d_jabatan_id').val(dt.jabatan_id);
                    $('#d_sektor_id').val(dt.sektor_id);
                    $('#d_tanggal_start').val(dt.tanggal_start);
                    $('#d_tanggal_end').val(dt.tanggal_end);
                    $('#d_perusahaan_name').text(dt.perusahaan_name ?? '-');
                    $('#d_perusahaan_alamat').text(dt.perusahaan_alamat ?? '-');
                    $('#d_judul_lowongan').val(dt.judul_lowongan);
                    $('#d_kabkota_id').val(dt.kabkota_id);
                    $('#d_lokasi_penempatan_text').val(dt.lokasi_penempatan_text);
                    $('#d_jumlah_pria').val(dt.jumlah_pria);
                    $('#d_jumlah_wanita').val(dt.jumlah_wanita);
                    $('#d_deskripsi').val(dt.deskripsi);
                    $('#d_pendidikan_id').val(dt.pendidikan_id);
                    $('#d_status_perkawinan_id').val(dt.marital_id);
                    $('#d_status_id').val(dt.status_id);

                    // Pastikan hanya memanggil loadJurusanByPendidikan jika pendidikan_id ada
                    var pendidikanId = dt.pendidikan_id;
                    if (pendidikanId) {
                        loadJurusanByPendidikan(pendidikanId, '#d_jurusan_id', dt.jurusan_id); // Panggil fungsi untuk mengisi data
                    }

                    // Tampilkan modal edit
                    $('#modal-detail').modal('show');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }

        // Fungsi untuk memuat data jurusan berdasarkan pendidikan_id
        function loadJurusanByPendidikan(kd, targetDropdown, selectedJurusanId) {
            if (!kd) return; // Pastikan kd (pendidikan_id) tidak kosong

            // Panggil API untuk mendapatkan jurusan
            $.ajax({
                url: "{{ route('get-jurusan-bypendidikan', ':id') }}".replace(':id', kd),
                type: 'GET',
                success: function(response) {
                    // Kosongkan dropdown sebelumnya
                    $(targetDropdown).empty();

                    // Tambahkan opsi default
                    $(targetDropdown).append('<option selected disabled>Pilih Jurusan</option>');

                    // Tambahkan data jurusan ke dropdown
                    $.each(response, function(index, jurusan) {
                        $(targetDropdown).append('<option value="' + jurusan.id + '">' + jurusan.nama + '</option>');
                    });

                    // Pilih jurusan_id yang sudah ada
                    if (selectedJurusanId) {
                        $(targetDropdown).val(selectedJurusanId); // Pilih nilai jurusan yang sudah ada
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }
    </script>


    <script>
        $(document).ready(function() {
            $('#editForm').submit(function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                // Clear previous error messages
                $('#errorMessages').html('').addClass('d-none');
                var id = $('#editId').val()
                $.ajax({
                    type: 'PUT',
                    url: "{{ route('lowongan.update', ':id') }}".replace(':id', id),
                    data: {
                        id: id, // ID untuk update
                        jabatan_id: $('#e_jabatan_id').val(),
                        sektor_id: $('#e_sektor_id').val(),
                        tanggal_start: $('#e_tanggal_start').val(),
                        tanggal_end: $('#e_tanggal_end').val(),
                        judul_lowongan: $('#e_judul_lowongan').val(),
                        kabkota_id: $('#e_kabkota_id').val(),
                        lokasi_penempatan_text: $('#e_lokasi_penempatan_text').val(),
                        jumlah_pria: $('#e_jumlah_pria').val(),
                        jumlah_wanita: $('#e_jumlah_wanita').val(),
                        deskripsi: $('#e_deskripsi').val(),
                        pendidikan_id: $('#e_pendidikan_id').val(),
                        jurusan_id: $('#e_jurusan_id').val(),
                        marital_id: $('#e_status_perkawinan_id').val(),
                        status_id: $('#e_status_id').val(),
                        _token: '{{ csrf_token() }}' // CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Berhasil memperbarui data');
                            $('#modal-edit').modal('hide');
                            location.reload(); // Refresh halaman
                        } else {
                            // If validation errors are found, display them in an alert
                            if (response.errors) {
                                let errorMessages = '';
                                $.each(response.errors, function(key, value) {
                                    $.each(value, function(index, errorMessage) {
                                        errorMessages += errorMessage + '\n'; // Gabungkan pesan error
                                    });
                                });
                                alert('Terjadi kesalahan:\n' + errorMessages);
                            } else {
                                alert('Gagal memperbarui data');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#lamarForm').submit(function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                // Clear previous error messages
                $('#errorMessages').html('').addClass('d-none');
                var id = $('#detailId').val()
                $.ajax({
                    type: 'POST',
                    url: "{{ route('lowongan.lamar', ':id') }}".replace(':id', id),
                    data: {
                        id: id, // ID untuk update
                        _token: '{{ csrf_token() }}' // CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Berhasil lamar');
                            location.reload(); // Refresh halaman
                        } else {
                            // If validation errors are found, display them in an alert
                            if (response.errors) {
                                let errorMessages = '';
                                $.each(response.errors, function(key, value) {
                                    $.each(value, function(index, errorMessage) {
                                        errorMessages += errorMessage + '\n'; // Gabungkan pesan error
                                    });
                                });
                                alert('Terjadi kesalahan:\n' + errorMessages);
                            } else {
                                alert('Gagal lamar');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });
        });
    </script>


    <script>
        function confirmDelete(id) {
            // Konfirmasi penghapusan
            var deleteUrl = "{{ route('lowongan.softdelete', ':id') }}".replace(':id', id);
            if (confirm("Yakin hapus data?")) {
                // Kirim request ke server untuk menghapus data
                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // Menyertakan CSRF token
                    },
                    success: function(response) {
                        // Jika berhasil, reload DataTable
                        alert(response.message); // Menampilkan pesan
                        $('#simpletable').DataTable().ajax.reload(); // Reload data tabel
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan error jika ada masalah
                        alert('Error: ' + xhr.responseText);
                    }
                });
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#pendidikan_id').on('change', function() {
                // console.log(this.value);
                var kd = this.value

                // Panggil API untuk mendapatkan kecamatan berdasarkan kabkota_id
                $.ajax({
                    url: "{{ route('get-jurusan-bypendidikan', ':id') }}".replace(':id',
                        kd), // Panggil API
                    type: 'GET',
                    success: function(response) {
                        // Kosongkan dropdown kecamatan sebelumnya
                        $('#jurusan_id').empty();

                        // Tambahkan opsi default
                        $('#jurusan_id').append(
                            '<option selected disabled>Pilih Jurusan</option>');

                        // Loop data kecamatan dan tambahkan ke dropdown
                        $.each(response, function(index, jurusan) {
                            $('#jurusan_id').append('<option value="' + jurusan.id +
                                '">' +
                                jurusan.nama + '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#pendidikan_id').on('load', function() {
                // console.log(this.value);
                var kd = this.value

                // Panggil API untuk mendapatkan kecamatan berdasarkan kabkota_id
                $.ajax({
                    url: "{{ route('get-jurusan-bypendidikan', ':id') }}".replace(':id',
                        kd), // Panggil API
                    type: 'GET',
                    success: function(response) {
                        // Kosongkan dropdown kecamatan sebelumnya
                        $('#e_jurusan_id').empty();

                        // Tambahkan opsi default
                        $('#e_jurusan_id').append(
                            '<option selected disabled>Pilih Jurusan</option>');

                        // Loop data kecamatan dan tambahkan ke dropdown
                        $.each(response, function(index, jurusan) {
                            $('#e_jurusan_id').append('<option value="' + jurusan.id +
                                '">' +
                                jurusan.nama + '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            });
        });
    </script>
@endpush
