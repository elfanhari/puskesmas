<div class="col-md-6">
    <div class="form-group">
        <label for="name" class="required">Nama</label>
        <input type="text" name="name" id="name" placeholder="Ketik Nama" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="email" class="required">Email</label>
        <input type="text" name="email" id="email" placeholder="Ketik Email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="role" class="required">Role</label>
        <select name="role" id="role" class="form-control select2 @error('role') is-invalid @enderror" data-minimum-results-for-search="Infinity" data-placeholder="Pilih" required>
            <option value=""></option>
            @foreach (['admin', 'user'] as $item)
                <option {{ old('role') == $item ? 'selected' : '' }}>{{ $item }}</option>
            @endforeach
        </select>
        @error('role')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="password" class="required">Password</label>
        <div class="input-group">
            <input type="password" name="password" id="password" placeholder="Ketik Password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required>
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <div class="input-group-append" onclick="togglePassword()">
                <span class="input-group-text">
                    <i class="fa fa-eye-slash" id="eye-icon"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="abc" class="">Abc</label>
        <textarea name="abc" id="abc" placeholder="Ketik Abc" value="{{ old('abc') }}" class="form-control @error('password') is-invalid @enderror"></textarea>
        @error('abc')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
