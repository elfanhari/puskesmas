<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="guru_id" class="required">Nama Guru</label>
            <select name="guru_id" id="guru_id" class="form-control select2 @error('guru_id') is-invalid @enderror" data-placeholder="Pilih Guru" required>
                <option value=""></option>
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id }}" {{ old('guru_id', $permintaan->guru_id) == $guru->id ? 'selected' : '' }}>{{ $guru->name }}</option>
                @endforeach
            </select>
            @error('guru_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="tanggal" class="required">Tanggal Permintaan</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $permintaan->tanggal) }}" class="form-control @error('tanggal') is-invalid @enderror" required readonly>
            @error('tanggal')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="alasan" class="required">Alasan Permintaan</label>
            <textarea name="alasan" id="alasan" class="form-control @error('alasan') is-invalid @enderror" rows="3" placeholder="Tulis alasan permintaan" required>{{ old('alasan', $permintaan->alasan) }}</textarea>
            @error('alasan')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<hr>

{{-- ITEMS --}}
<h5 class="mb-3">Item Permintaan</h5>
<table class="table table-borderless" id="table-items">
    <thead>
        <tr>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th style="width: 50px;"></th>
        </tr>
    </thead>
    <tbody>
        @forelse (old('items', $permintaan->itemPermintaanBarang ?? [null]) as $i => $item)
            <tr class="border-bottom">
                <td>
                    <select name="items[{{ $i }}][barang_id]" class="form-control select-barang" required>
                        <option value="">Pilih Barang</option>
                        @foreach ($barangs as $barang)
                            <option value="{{ $barang->id }}" data-satuan="{{ $barang->satuan }}" {{ (old("items.$i.barang_id") ?? ($item->barang_id ?? '')) == $barang->id ? 'selected' : '' }}>
                                {{ $barang->nama }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td class="d-flex">
                    <input type="number" name="items[{{ $i }}][jumlah]" class="form-control mt-2" min="1" value="{{ old("items.$i.jumlah") ?? ($item->jumlah ?? '') }}" required>
                </td>
                <td>
                    <span class="ml-2 satuan-text align-self-center">
                        {{ optional($barangs->firstWhere('id', old("items.$i.barang_id") ?? ($item->barang_id ?? '-')))->satuan }}
                    </span>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger btn-remove-item"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @empty
            {{-- default 1 baris kosong --}}
            <tr class="border-bottom">
                <td>
                    <select name="items[0][barang_id]" class="form-control select-barang" required>
                        <option value="">Pilih Barang</option>
                        @foreach ($barangs as $barang)
                            <option value="{{ $barang->id }}" data-satuan="{{ $barang->satuan }}">{{ $barang->nama }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="d-flex">
                    <input type="number" name="items[0][jumlah]" class="form-control mt-2" min="1" required>
                </td>
                <td>
                    <span class="ml-2 satuan-text align-self-center">-</span>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger btn-remove-item"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>


<div class="d-flex justify-content-end">
    <button type="button" class="btn btn-sm btn-success" id="btn-add-item">
        <i class="fas fa-plus"></i> Tambah Item
    </button>
</div>


<hr>
{{-- <div class="form-group text-right">
    <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
</div> --}}
