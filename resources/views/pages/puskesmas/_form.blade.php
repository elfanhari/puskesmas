<div class="col-md-6">
    <div class="form-group">
        <label for="name" class="required">Nama Puskesmas</label>
        <input type="text" name="name" id="name" placeholder="Ketik Nama Puskesmas" value="{{ old('name', $puskesmas->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $puskesmas->alamat ?? '') }}</textarea>
        @error('alamat')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="telepon">Telepon</label>
        <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $puskesmas->telepon ?? '') }}" class="form-control @error('telepon') is-invalid @enderror">
        @error('telepon')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $puskesmas->email ?? '') }}" class="form-control @error('email') is-invalid @enderror">
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="website">Website</label>
        <input type="text" name="website" id="website" value="{{ old('website', $puskesmas->website ?? '') }}" class="form-control @error('website') is-invalid @enderror">
        @error('website')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="logo">Logo Puskesmas</label>
        <input type="file" name="logo" id="logo" class="form-control-file form-control @error('logo') is-invalid @enderror" accept="image/*" onchange="previewLogo(event)">
        @error('logo')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror

        <div class="mt-3">
            <img id="logo-preview" src="{{ $puskesmas->url_logo }}" alt="Logo Preview" style="max-height: 120px; border: 1px solid #ddd; padding: 4px;">
        </div>
    </div>
</div>
