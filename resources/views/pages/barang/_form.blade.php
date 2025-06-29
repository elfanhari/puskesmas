<div class="col-md-6">

    <div class="form-group">
        <label for="nama" class="required">Nama Barang</label>
        <input type="text" name="nama" id="nama" placeholder="Ketik Nama Barang" value="{{ old('nama', $barang->nama ?? '') }}" class="form-control @error('nama') is-invalid @enderror" required>
        @error('nama')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="kode" class="required">Kode Barang</label>
        <input type="text" name="kode" id="kode" placeholder="Ketik Kode Barang" value="{{ old('kode', $barang->kode ?? '') }}" class="form-control @error('kode') is-invalid @enderror" required>
        @error('kode')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="kategori_barang_id" class="required">Kategori Barang</label>
        <select name="kategori_barang_id" id="kategori_barang_id" class="form-control select2 @error('kategori_barang_id') is-invalid @enderror" data-placeholder="Pilih Kategori" required>
            <option value=""></option>
            @foreach ($kategoriBarangs as $kategori)
                <option value="{{ $kategori->id }}" {{ old('kategori_barang_id', $barang->kategori_barang_id ?? '') == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama }}
                </option>
            @endforeach
        </select>
        @error('kategori_barang_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="stok" class="required">Stok</label>
        <input type="number" name="stok" id="stok" placeholder="Masukkan Jumlah Stok" value="{{ old('stok', $barang->stok ?? 0) }}" class="form-control @error('stok') is-invalid @enderror" required>
        @error('stok')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="satuan" class="required">Satuan</label>
        <select name="satuan" id="satuan" class="form-control select2 @error('satuan') is-invalid @enderror" data-placeholder="Pilih Satuan" required>
            <option value=""></option>
            @foreach (['pcs', 'unit', 'set', 'pak', 'lembar', 'buah'] as $option)
                <option value="{{ $option }}" {{ old('satuan', $barang->satuan ?? '') == $option ? 'selected' : '' }}>
                    {{ ucfirst($option) }}
                </option>
            @endforeach
        </select>
        @error('satuan')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea name="keterangan" id="keterangan" placeholder="Tulis keterangan barang (opsional)" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $barang->keterangan ?? '') }}</textarea>
        @error('keterangan')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
