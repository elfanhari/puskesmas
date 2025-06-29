<div class="col-md-6">
    <div class="form-group">
        <label for="no_kartu" class="required">No. Kartu</label>
        <input type="text" name="no_kartu" id="no_kartu" placeholder="Masukkan No. Kartu" value="{{ old('no_kartu', $pasien->no_kartu ?? '') }}" class="form-control @error('no_kartu') is-invalid @enderror" required readonly>
        @error('no_kartu')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="name" class="required">Nama</label>
        <input type="text" name="name" id="name" placeholder="Ketik Nama" value="{{ old('name', $pasien->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="nik" class="required">NIK</label>
        <input type="number" name="nik" id="nik" placeholder="Masukkan NIK" value="{{ old('nik', $pasien->nik ?? '') }}" class="form-control @error('nik') is-invalid @enderror" required>
        @error('nik')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="tanggal_lahir" class="required">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir ?? '') }}" class="form-control @error('tanggal_lahir') is-invalid @enderror" required>
        @error('tanggal_lahir')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="jenis_kelamin" class="required">Jenis Kelamin</label>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
            <option value="">-- Pilih --</option>
            <option value="L" {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('jenis_kelamin')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="alamat" class="required">Alamat</label>
        <textarea name="alamat" id="alamat" rows="3" placeholder="Masukkan Alamat" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $pasien->alamat ?? '') }}</textarea>
        @error('alamat')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="telepon" class="required">No. Telepon</label>
        <input type="text" name="telepon" id="telepon" placeholder="Masukkan No. Telepon" value="{{ old('telepon', $pasien->telepon ?? '') }}" class="form-control @error('telepon') is-invalid @enderror" required>
        @error('telepon')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

</div>
