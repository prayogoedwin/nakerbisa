<div class="step d-none" id="step3">
    <?php
    $provinsis = getProvinsi();
    ?>
    <form action="{{ route('akhir-daftar-akun-blk') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="blkName" class="form-label">Nama BLK</label>
            <input type="text" class="form-control" id="nama_blk" name="nama_blk" required>
        </div>
        <div class="mb-3">
            <label for="no_izin_pendirian" class="form-label">No Izin Pendirian</label>
            <input type="text" class="form-control" id="no_izin_pendirian" name="no_izin_pendirian" required>
        </div>

        <div class="mb-3">
            <label for="waktu_pendirian" class="form-label">Tanggal Pendirian</label>
            <input type="date" class="form-control" id="waktu_pendirian" name="waktu_pendirian" required>
        </div>

        
        <div class="mb-3">
            <label for="nomor_vin" class="form-label">No VIN</label>
            <input type="text" class="form-control" id="nomor_vin" name="nomor_vin" required>
        </div>

        <div class="mb-3">
            <label for="nomor_induk_berusaha" class="form-label">NIB</label>
            <input type="text" class="form-control" id="nomor_induk_berusaha" name="nomor_induk_berusaha" required>
        </div>

        <div class="mb-3">
            <label for="nomor_akreditasi_lembaga" class="form-label">No Akreditasi Lembaga</label>
            <input type="text" class="form-control" id="nomor_akreditasi_lembaga" name="nomor_akreditasi_lembaga" required>
        </div>

        jenis_pelatihan

        <div class="mb-3">
            <label for="berlaku_sampai" class="form-label">Berlaku Sampai</label>
            <input type="date" class="form-control" id="berlaku_sampai" name="berlaku_sampai" required>
        </div>

        <div class="mb-3">
            <label for="jenis_pelatihan" class="form-label">Jenis Pelatihan</label>
            <input type="text" class="form-control" id="jenis_pelatihan" name="jenis_pelatihan" required>
        </div>

        <div class="mb-3">
            <label for="nomor_akreditasi_lembaga" class="form-label">Kapasitas Peserta Per Pelatihan</label>
            <input type="number" class="form-control" id="kapasitas_peserta_per_pelatihan" name="kapasitas_peserta_per_pelatihan" required>
        </div>

        <div class="mb-3">
            <label for="jumlah_lulusan_sampai_sekarang" class="form-label">Jumlah Lulusan Sampai Sekarang</label>
            <input type="number" class="form-control" id="jumlah_lulusan_sampai_sekarang" name="jumlah_lulusan_sampai_sekarang" required>
        </div>

        <div class="mb-3">
            <label for="jumlah_peserta_lulus_uji_kompetensi" class="form-label">Jumlah Peserta Lulus Uji Kompetensi</label>
            <input type="number" class="form-control" id="jumlah_peserta_lulus_uji_kompetensi" name="jumlah_peserta_lulus_uji_kompetensi" required>
        </div>

        <div class="mb-3">
            <label for="jumlah_instruktur" class="form-label">Jumlah Instruktur</label>
            <input type="number" class="form-control" id="jumlah_instruktur" name="jumlah_instruktur" required>
        </div>

        <div class="mb-3">
            <label for="jumlah_instruktur_bersertifikat_kompetensi" class="form-label">Jumlah Instruktur Bersertifikat</label>
            <input type="number" class="form-control" id="jumlah_instruktur_bersertifikat_kompetensi" name="jumlah_instruktur_bersertifikat_kompetensi" required>
        </div>

        <div class="mb-3">
            <label for="kabkota" class="form-label">Provinsi</label>
            <select class="form-select" id="provinsi_id" name="provinsi_id" required>
                <option selected disabled>Pilih Provinsi</option>
                @foreach ($provinsis as $prov)
                    <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="kabkota" class="form-label">Kabupaten / Kota</label>
            <select class="form-select" id="kabkota_id" name="kabkota_id" required>
                <option selected disabled>Pilih Kabupaten/Kota</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="kecamatan" class="form-label">Kecamatan</label>
            <select class="form-select" id="kecamatan_id" name="kecamatan_id" required>
                <option selected disabled>Pilih Kecamatan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="kelurahan" class="form-label">Desa / Kelurahan</label>
            <select class="form-select" id="desa_id" name="desa_id" required>
                <option selected disabled>Pilih Desa/Kelurahan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Lengkap</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="kodepos" class="form-label">Kode Pos</label>
            <input type="text" class="form-control" id="kodepos" name="kodepos" required>
        </div>
        <div class="mb-3">
            <label for="telpon" class="form-label">Telpon</label>
            <input type="number" class="form-control" id="telpon" name="telpon" required>
        </div>
        <div class="mb-3">
            <label for="picName" class="form-label">PIC</label>
            <input type="text" class="form-control" id="pic" name="pic" required>
        </div>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
        </div>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Website</label>
            <input type="text" class="form-control" id="website" name="website" required>
        </div>

        {{-- <button type="button" class="btn btn-secondary w-100 mt-3" onclick="previousStep()">Back</button> --}}
        <button type="submit" class="btn btn-success w-100 mt-3">Submit</button>
    </form>
</div>
