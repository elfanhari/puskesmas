<div class="modal fade" tabindex="-1" role="dialog" id="modal-edit-status">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pembelian-barang.update-status', $pembelian->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="status" class="required">Status</label>
                        <select name="status" id="status" class="form form-control form-select @error('status') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            @if ($pembelian->status === 'diajukan')
                                <option value="menunggu_persetujuan">Menunggu Persetujuan</option>
                                <option value="ditolak">Ditolak</option>
                            @elseif ($pembelian->status === 'menunggu_persetujuan')
                                <option value="disetujui">Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                            @elseif ($pembelian->status === 'disetujui')
                                <option value="selesai">Selesai</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary btn-submit">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
