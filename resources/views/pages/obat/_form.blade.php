<div class="col-md-6">
    <div class="form-group">
        <label for="name" class="required">Nama Obat</label>
        <input type="text" name="name" id="name" placeholder="Ketik Nama Obat" value="{{ old('name', $obat->name) }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="stok" class="required">Stok</label>
        <input type="number" name="stok" id="stok" placeholder="Ketik Stok" value="{{ old('stok', $obat->stok) }}" class="form-control @error('stok') is-invalid @enderror">
        @error('stok')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="satuan" class="required">Satuan</label>
        <input type="text" name="satuan" id="satuan" placeholder="Ketik Satuan" value="{{ old('satuan', $obat->satuan) }}" class="form-control @error('satuan') is-invalid @enderror">
        @error('satuan')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

</div>
