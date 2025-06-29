@extends('layouts.app-sidebar')

@section('content')

<x-main-content>
  <x-section-header :title="'Dashboard'" :btnBack="false"></x-section-header>

  <div class="row">
    <div class="col-12 mb-4">
      <div class="hero bg-primary text-white">
        <div class="hero-inner">
          <h2>Halo, {{ auth()->user()->name }}!</h2>
          {{-- <p class="lead">You almost arrived, complete the information about your account to complete registration.</p> --}}
          <div class="mt-4">
            <a href="{{ route('profile.show') }}" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="far fa-user"></i> Lihat profil saya </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    @foreach ($data as $item)
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-{{ $item['color'] ?? 'primary' }}">
            @isset($item['icon'])
              {!! $item['icon'] !!}
            @else
              <i class="far fa-file"></i>
            @endisset
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>{{ $item['title'] }}</h4>
            </div>
            <div class="card-body">
              {{ $item['count'] }}
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</x-main-content>

@endsection
