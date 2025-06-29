<div class="modal fade" tabindex="-1" role="dialog" id="modal-edit-feedback">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pembelian-barang.update-feedback', $pembelian->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="feedback" class="">Feedback</label>
                        <textarea name="feedback" id="feedback" class="form-control @error('feedback') is-invalid @enderror" rows="3" required>{{ old('feedback', $pembelian->feedback) }}</textarea>
                        @error('feedback')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary btn-submit">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
