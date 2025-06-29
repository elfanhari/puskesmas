@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header :title="'Data Obat'" :btnBack="true" :redirect="'/obat'"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Create</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Data Obat</h4>
                </div>
                <form action="{{ route('obat.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            @include('pages.obat._form')
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
@endsection
