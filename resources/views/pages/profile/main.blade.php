@extends('layouts.app-sidebar')

@section('content')
  <x-main-content>
    <x-section-header :title="'Profile'" :btnBack="false"></x-section-header>

    <div class="section-body">
      <h2 class="section-title">Hi, {{ $user->name }}!</h2>
      <p class="section-lead">
        Ubah data diri kamu di halaman ini!
      </p>

      <div id="output-status"></div>
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item"><a href="{{ route('profile.show') }}" class="nav-link {{ Route::is('profile.show') ? 'active' : '' }}">Detail</a></li>
                <li class="nav-item"><a href="{{ route('profile.editdata') }}" class="nav-link {{ Route::is('profile.editdata') ? 'active' : '' }}">Edit Data</a></li>
                <li class="nav-item"><a href="{{ route('profile.editfoto') }}" class="nav-link {{ Route::is('profile.editfoto') ? 'active' : '' }}">Edit Foto</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          @yield('profile')
        </div>
      </div>

    </div>

  </x-main-content>
@endsection

@section('js')
  <script>
    function previewImage() {
      const image = document.querySelector('#files');
      const imgPreview = document.querySelector('.img-preview');

      // imgPreview.style.display = 'inline';

      const oFReader = new FileReader();
      oFReader.readAsDataURL(files.files[0]);

      oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
      }
    }
  </script>
@endsection
