<div class="form-group">
  <label for="{{ $column }}" class="{{ $required == true ? 'required' : '' }}">{{ $title }}</label>
  <input type="text" class="form-control" name="{{ $column }}" id="{{ $column }}" placeholder="Ketik {{ $title }}" {{ $required == true ? 'required' : '' }}>
  @error('{{ $column }}') <span class="invalid-feedback">{{ $message }}</span> @enderror
</div>
