<div class="col-md-6">
    <div class="form-group">
        <label for="nama" class="required">Nama Kategori Barang</label>
        <input type="text" name="nama" id="nama" placeholder="Ketik Nama Kategori Barang" value="{{ old('nama', $kategoriBarang->nama) }}" class="form-control @error('nama') is-invalid @enderror" required>
        @error('nama')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
