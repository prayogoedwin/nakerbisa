<div class="step d-none" id="step3">
    <?php
    $provinsis = getProvinsi();
    ?>
    <form action="{{ route('akhir-daftar-akun-blk') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="blkName" class="form-label">Nama Blk</label>
            <input type="text" class="form-control" id="nama_blk" name="nama_blk" required>
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
