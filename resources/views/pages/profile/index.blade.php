@extends('pages.profile.main')

@section('profile')
    <div class="col">
        <div class="card profile-widget">
            <div class="profile-widget-header">
                <img alt="image" src="{{ $user->url_foto }}" class="rounded-circle profile-widget-picture">
            </div>
            <div class="profile-widget-description pb-0">
                <div class="profile-widget-name">{{ $user->name }}
                    <div class="text-muted d-inline font-weight-normal">
                        <div class="slash"></div>
                        {{ $user->role_formatted }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="fw-bold"><b>Nama</b></div>
                <div class="text-gray-600">{{ $user->name ?? '-' }}</div>

                <div class="fw-bold mt-3"><b>Email</b></div>
                <div class="text-gray-600">{{ $user->email ?? '-' }}</div>

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
@endsection
