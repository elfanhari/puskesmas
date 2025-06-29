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
                        <label for="is_aktif" class="required">Status</label>
                        <select name="is_aktif" id="is_aktif" class="form form-control form-select @error('is_aktif') is-invalid @enderror">
                            <option value="">Semua</option>
                            @foreach (['1', '0'] as $item)
                                <option {{ request('is_aktif') == $item ? 'selected' : '' }} value="{{ $item }}">{{ $item == '1' ? 'Aktif' : 'Non-Aktif' }}</option>
                            @endforeach
                        </select>
                        @error('is_aktif')
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
