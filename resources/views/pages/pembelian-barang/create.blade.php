@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header :title="'Data Pembelian Barang'" :btnBack="true" :redirect="'/barang'"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Create</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Form Pengajuan Pembelian Barang</h4>
                </div>
                <form action="{{ route('pembelian-barang.store') }}" method="post">
                    @csrf
                    <div class="card-body pb-0">
                        @include('pages.pembelian-barang._form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-main-content>
@endsection

@section('js')
    <script src="/stisla/dist/assets/modules/select2/dist/js/select2.full.min.js"></script>
    @include('pages.pembelian-barang._script-create-edit');
@endsection
