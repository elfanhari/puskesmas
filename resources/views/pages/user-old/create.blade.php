@extends('layouts.app-sidebar')

@section('css')
<link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
@endsection

@section('content')
<x-main-content>
  <x-section-header :title="'Data User'" :btnBack="true"></x-section-header>

  <div class="section-body">
    {{-- <h2 class="section-title">Create</h2> --}}
    {{-- <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
    <div class="card">
      <div class="card-header">
        <h4>Create</h4>
      </div>
      <form action="{{ route('user.store') }}" method="post">
        @csrf
        <div class="card-body">
          <div class="row">
            @include('pages.user._createform')
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</x-main-content>

@endsection

@section('js')
<script src="/stisla/dist/assets/modules/select2/dist/js/select2.full.min.js"></script>
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
