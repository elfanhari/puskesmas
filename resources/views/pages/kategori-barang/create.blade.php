@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header :title="'Data Kategori Barang'" :btnBack="true" :redirect="'/kategori-barang'"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Create</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Data Kategori Barang</h4>
                </div>
                <form action="{{ route('kategori-barang.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            @include('pages.kategori-barang._form')
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
