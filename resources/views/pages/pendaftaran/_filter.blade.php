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
                    <div class="form-group mb-3">
                        <label for="dari_tanggal" class="">Dari Tanggal</label>
                        <input type="date" name="dari_tanggal" id="dari_tanggal" value="{{ request('dari_tanggal') }}" class="form-control @error('dari_tanggal') is-invalid @enderror">
                        @error('dari_tanggal')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="sampai_tanggal" class="">Sampai Tanggal</label>
                        <input type="date" name="sampai_tanggal" id="sampai_tanggal" value="{{ request('sampai_tanggal') }}" class="form-control @error('sampai_tanggal') is-invalid @enderror">
                        @error('sampai_tanggal')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label for="petugas_id" class="">Petugas</label>
                        <select name="petugas_id" id="petugas_id" class="form-control form-select @error('petugas_id') is-invalid @enderror">
                            <option value="">Semua Petugas</option>
                            @foreach ($petugas as $user)
                                <option value="{{ $user->id }}" {{ request('petugas_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('petugas_id')
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
