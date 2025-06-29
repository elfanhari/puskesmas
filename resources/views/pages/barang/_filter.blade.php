<div class="modal fade" tabindex="-1" role="dialog" id="modal-filter">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="">
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="kategori_barang_id" class="required">Kategori Barang</label>
                        <select name="kategori_barang_id" id="kategori_barang_id" class="form form-control form-select @error('kategori_barang_id') is-invalid @enderror">
                            <option value="">Semua</option>
                            @foreach ($kategoriBarangs as $item)
                                <option value="{{ $item->id }}" {{ request('kategori_barang_id') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_barang_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary btn-submit">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
