<div class="col-md-6">
    <div class="form-group">
        <label for="name" class="required">Nama</label>
        <input type="text" name="name" id="name" placeholder="Ketik Nama" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="is_aktif" class="required">Status Aktif</label>
        <select name="is_aktif" id="is_aktif" class="form-control select2 @error('is_aktif') is-invalid @enderror" data-minimum-results-for-search="Infinity" data-placeholder="Pilih" required>
            <option value=""></option>
            @foreach (['1', '0'] as $item)
                <option value="{{ $item }}" {{ old('is_aktif', $user->is_aktif) == $item ? 'selected' : '' }}>{{ $item == '1' ? 'Aktif' : 'Non-Aktif' }}</option>
            @endforeach
        </select>
        @error('is_aktif')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    @if ($user->role == 'dokter')
        <div class="form-group">
            <label for="poli_id" class="required">Poli Ditangani</label>
            <select name="poli_id[]" id="poli_id" class="form-control select2 @error('poli_id') is-invalid @enderror" data-placeholder="Pilih Poli" multiple required>
                @foreach ($polis as $poli)
                    <option value="{{ $poli->id }}" {{ in_array($poli->id, old('poli_id', $poliDitangani ?? [])) ? 'selected' : '' }}>
                        {{ $poli->name }}
                    </option>
                @endforeach
            </select>
            @error('poli_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    @endif

    <div class="form-group">
        <label for="email" class="required">Email</label>
        <input type="text" name="email" id="email" placeholder="Ketik Email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    @if ($action == 'create')
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
    @else
        <div class="form-group">
            <label for="password" class="">Password Baru <small>(Opsional)</small></label>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Ketik Password Baru" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
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
    @endif

</div>
