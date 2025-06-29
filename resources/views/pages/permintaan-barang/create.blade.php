@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header :title="'Data Permintaan Barang'" :btnBack="true" :redirect="'/barang'"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Create</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Form Permintaan Barang</h4>
                </div>
                <form action="{{ route('permintaan-barang.store') }}" method="post">
                    @csrf
                    <div class="card-body pb-0">
                        @include('pages.permintaan-barang._form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            Kirim Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-main-content>
@endsection

@section('js')
    <script src="/stisla/dist/assets/modules/select2/dist/js/select2.full.min.js"></script>
    @include('pages.permintaan-barang._script-create-edit');
@endsection
