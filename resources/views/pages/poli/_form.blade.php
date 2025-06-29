<div class="col-md-6">
    <div class="form-group">
        <label for="name" class="required">Nama Poli</label>
        <input type="text" name="name" id="name" placeholder="Ketik Nama Poli" value="{{ old('name', $poli->name) }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
