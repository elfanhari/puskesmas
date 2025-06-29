@if ($method == 'create')
  <div class="form-group">
    <label for="{{ $column }}" class="{{ $required == true ? 'required' : '' }} @error('{{ $column }}') is-invalid @enderror">{{ $title }}</label>
    <input type="email" class="form-control" name="{{ $column }}" id="{{ $column }}" value="{{ old($column) }}" placeholder="Ketik {{ $title }}" {{ $required == true ? 'required' : '' }}>
    @error('{{ $column }}') <span class="invalid-feedback">{{ $message }}</span> @enderror
  </div>
@elseif($method == 'edit')
  <div class="form-group">
    <label for="{{ $column }}" class="{{ $required == true ? 'required' : '' }} @error('{{ $column }}') is-invalid @enderror">{{ $title }}</label>
    <input type="email" class="form-control" name="{{ $column }}" id="{{ $column }}" value="{{ old($column, $data->$column) }}" placeholder="Ketik {{ $title }}" {{ $required == true ? 'required' : '' }}>
    @error('{{ $column }}') <span class="invalid-feedback">{{ $message }}</span> @enderror
  </div>
@endif
