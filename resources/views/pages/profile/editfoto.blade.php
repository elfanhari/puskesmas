@extends('pages.profile.main')

@section('profile')

<div class="col">
  <div class="card profile-widget">
    <div class="profile-widget-header">
      <img alt="image" src="/img/profile/{{ $user->foto }}" class="rounded-circle profile-widget-picture img-preview" style="">
    </div>
    <div class="profile-widget-description">
      <div class="profile-widget-name">{{ $user->name }} <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> {{ $user->role }}</div></div>
    </div>
    <form action="{{ route('profile.editfoto.update') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="card-body">
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="files" class="required">Ganti Foto</label>
              <input type="file" name="files" id="files" value="{{ old('files', $user->files) }}" class="form-control @error('files') is-invalid @enderror" required accept="image/*" onchange="previewImage()">
              @error('files') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
</div>
@endsection
