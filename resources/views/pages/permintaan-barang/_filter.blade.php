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
                    <div class="form-group mb-2">
                        <label for="status" class="">Status</label>
                        <select name="status" id="status" class="form form-control form-select @error('status') is-invalid @enderror">
                            <option value="">Semua</option>
                            @foreach ($statuses as $k => $v)
                                <option value="{{ $k }}" {{ request('status') == $k ? 'selected' : '' }}>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if (Auth::user()->role != 'guru')
                        <div class="form-group mb-2">
                            <label for="guru_id" class="">Guru</label>
                            <select name="guru_id" id="guru_id" class="form form-control form-select @error('guru_id') is-invalid @enderror">
                                <option value="">Semua</option>
                                @foreach ($gurus as $item)
                                    <option value="{{ $item->id }}" {{ request('guru_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="form-group mb-2">
                        <label for="dari_tanggal" class="">Dari Tanggal</label>
                        <input type="date" name="dari_tanggal" id="dari_tanggal" class="form form-control @error('dari_tanggal') is-invalid @enderror" value="{{ request('dari_tanggal') }}">
                        @error('dari_tanggal')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="sampai_tanggal" class="">Sampai Tanggal</label>
                        <input type="date" name="sampai_tanggal" id="sampai_tanggal" class="form form-control @error('sampai_tanggal') is-invalid @enderror" value="{{ request('sampai_tanggal') }}">
                        @error('sampai_tanggal')
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
