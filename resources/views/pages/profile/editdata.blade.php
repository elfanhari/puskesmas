@extends('pages.profile.main')

@section('profile')
    <div class="card">
        <div class="card-header">
            <h4>Edit Data</h4>
        </div>
        <form action="{{ route('profile.editdata.update') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="name" class="required">Nama</label>
                            <input type="text" name="name" id="name" placeholder="Ketik Nama" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="required">Email</label>
                            <input type="email" name="email" id="email" placeholder="Ketik Email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
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
                    </div>
                </div>
            </div>
            <div class="card-footer bg-whitesmoke text-md-right">
                <button type="submit" class="btn btn-primary float-end">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        function togglePassword() {
            var x = document.getElementById('password');
            var y = document.getElementById('eye-icon');
            if (x.type === 'password') {
                x.type = 'text';
                y.classList.add('fa-eye');
                y.classList.remove('fa-eye-slash');
                y.classList.add('text-primary');
            } else {
                x.type = 'password';
                y.classList.add('fa-eye-slash');
                y.classList.remove('text-primary');
                y.classList.remove('fa-eye');
            }
        }
    </script>
@endsection
