@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header :title="'Data Poli'" :btnBack="true" :redirect="'/poli'"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Edit</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Edit Data Poli</h4>
                </div>
                <form action="{{ route('poli.update', $poli->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            @include('pages.poli._form')
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
