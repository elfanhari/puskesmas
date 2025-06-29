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
            <label for="role" class="required">Role</label>
            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" data-minimum-results-for-search="Infinity" required>
              <option value=""></option>
              @foreach (['admin','user'] as $item)
                <option {{ request('role') == $item ? 'selected' : '' }}>{{ $item }}</option>
              @endforeach
            </select>
            @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary btn-submit">Terapkan</button>
        </div>
      </form>
    </div>
  </div>
</div>
