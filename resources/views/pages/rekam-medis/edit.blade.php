@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/customize/daterangepicker/style.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header title="Data Rekam Medis" :btnBack="true"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Edit</h2>
            <form action="{{ route('rekam-medis.update', $rekamMedis->id) }}" method="post">
                @csrf
                @method('PUT')
                @include('pages.rekam-medis._form', ['action' => 'create'])
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
            </form>
        </div>
    </x-main-content>
@endsection

@section('js')
    <script src="/customize/daterangepicker/script.js"></script>
@endsection
