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

                    <div class="form-group mb-3">
                        <label for="poli_id" class="">Poli</label>
                        <select name="poli_id" id="poli_id" class="form-control form-select @error('poli_id') is-invalid @enderror">
                            <option value="">Semua Poli</option>
                            @foreach ($polis as $poli)
                                <option value="{{ $poli->id }}" {{ request('poli_id') == $poli->id ? 'selected' : '' }}>
                                    {{ $poli->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('poli_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (!auth()->user()->isDokter())
                        <div class="form-group mb-3">
                            <label for="dokter_id" class="">Dokter</label>
                            <select name="dokter_id" id="dokter_id" class="form-control form-select @error('dokter_id') is-invalid @enderror">
                                <option value="">Semua Dokter</option>
                                @foreach ($dokters as $dokter)
                                    <option value="{{ $dokter->id }}" {{ request('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                        {{ $dokter->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dokter_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <div class="form-group mb-3">
                        <label for="status" class="">Status</label>
                        <select name="status" id="status" class="form form-control form-select @error('status') is-invalid @enderror">
                            <option value="">Semua</option>
                            @foreach ($statuses as $k => $v)
                                <option value="{{ $k }}" {{ request('status') == $k ? 'selected' : '' }}>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary btn-submit">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
