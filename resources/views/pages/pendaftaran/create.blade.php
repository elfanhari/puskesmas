@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header title="Data Pendaftaran" :btnBack="true"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Create</h2>
            <form action="{{ route('pendaftaran.store') }}" method="post">
                @csrf
                @include('pages.pendaftaran._form', ['action' => 'create'])
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
            </form>
        </div>
    </x-main-content>
@endsection

@section('js')
@endsection
