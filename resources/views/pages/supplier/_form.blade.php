<div class="col-md-6">
    <div class="form-group">
        <label for="nama" class="required">Nama Supplier</label>
        <input type="text" name="nama" id="nama" placeholder="Ketik Nama Supplier" value="{{ old('nama', $supplier->nama) }}" class="form-control @error('nama') is-invalid @enderror" required>
        @error('nama')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="telepon" class="required">Telepon</label>
        <input type="text" name="telepon" id="telepon" placeholder="Ketik Telepon" value="{{ old('telepon', $supplier->telepon) }}" class="form-control @error('telepon') is-invalid @enderror">
        @error('telepon')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="alamat" class="">Alamat</label>
        <textarea name="alamat" id="alamat" placeholder="Ketik Alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $supplier->alamat) }}</textarea>
        @error('alamat')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
