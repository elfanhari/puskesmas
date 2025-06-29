@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header :title="'Data Puskesmas'" :btnBack="false"></x-section-header>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('puskesmas.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            @include('pages.puskesmas._form')
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-main-content>
@endsection

@section('js')
    <script src="/stisla/dist/assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script>
        function previewLogo(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('logo-preview');
                output.src = reader.result;
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
@endsection
