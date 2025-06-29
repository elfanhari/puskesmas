<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="bendahara_id" class="required">Nama Bendahara</label>
            <select name="bendahara_id" id="bendahara_id" class="form-control select2 @error('bendahara_id') is-invalid @enderror" data-placeholder="Pilih Bendahara" required>
                <option value=""></option>
                @foreach ($bendaharas as $bendahara)
                    <option value="{{ $bendahara->id }}" {{ old('bendahara_id', $pembelian->bendahara_id) == $bendahara->id ? 'selected' : '' }}>{{ $bendahara->name }}</option>
                @endforeach
            </select>
            @error('bendahara_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="tanggal" class="required">Tanggal Pengajuan</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $pembelian->tanggal) }}" class="form-control @error('tanggal') is-invalid @enderror" required readonly>
            @error('tanggal')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<hr>

{{-- ITEMS --}}
<h5 class="mb-3">Item Pembelian</h5>
<table class="table table-borderless" id="table-items">
    <thead>
        <tr>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Harga Satuan (Rp)</th>
            <th>Supplier</th>
            <th style="width: 50px;"></th>
        </tr>
    </thead>
    <tbody>
        @forelse (old('items', $pembelian->itemPembelianBarang ?? [null]) as $i => $item)
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
                <td>
                    <input type="number" name="items[{{ $i }}][harga_satuan]" class="form-control" value="{{ old("items.$i.harga_satuan") ?? ($item->harga_satuan ?? '') }}" required>
                </td>
                <td>
                    <select name="items[{{ $i }}][supplier_id]" class="form-control select-supplier" required>
                        <option value="">Pilih Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ (old("items.$i.supplier_id") ?? ($item->supplier_id ?? '')) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->nama }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger btn-remove-item"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @empty
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
                <td>
                    <input type="number" name="items[0][harga_satuan]" class="form-control" value="" required>
                </td>
                <td>
                    <select name="items[0][supplier_id]" class="form-control select-supplier" required>
                        <option value="">Pilih Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">
                                {{ $supplier->nama }}
                            </option>
                        @endforeach
                    </select>
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
    <button type="submit" class="btn btn-primary">Kirim Pembelian</button>
</div> --}}
