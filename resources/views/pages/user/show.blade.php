@extends('layouts.app-sidebar')

@section('css')
@endsection

@section('content')
    <x-main-content>
        <x-section-header title="Data {{ $roleFormatted }}" :btnBack="true"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Show</h2>
            <div class="card">
                <div class="card-header">
                    <h4>{{ $user->name }}</h4>
                </div>
                <div class="card-body px-2">
                    <div class="profile-widget px-0">
                        <div class="profile-widget-header">
                            <img alt="image" src="{{ $user->url_foto }}" class="rounded-circle profile-widget-picture">
                        </div>
                        <div class="card-footer">
                            <div class="fw-bold"><b>Nama</b></div>
                            <div class="text-gray-600">{{ $user->name ?? '-' }}</div>

                            <div class="fw-bold mt-3"><b>Email</b></div>
                            <div class="text-gray-600">{{ $user->email ?? '-' }}</div>

                            @if ($user->isDokter())
                                <div class="fw-bold mt-3"><b>Poli Ditangani</b></div>
                                <div class="text-gray-600">
                                    @foreach ($user->dokter?->dokterPoli as $poli)
                                        <span class="badge badge-info me-2">{{ $poli->poli->name }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="fw-bold mt-3"><b>Role</b></div>
                            <div class="text-gray-600 text-uppercase">{{ $user->role_formatted ?? '-' }}</div>

                            <div class="fw-bold mt-3"><b>Status</b></div>
                            <div class="">
                                @if ($user->is_aktif == 1)
                                    <div class="badge badge-sm badge-success">AKTIF</div>
                                @else
                                    <div class="badge badge-sm badge-danger">NON-AKTIF</div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-main-content>
@endsection
@section('js')
@endsection
