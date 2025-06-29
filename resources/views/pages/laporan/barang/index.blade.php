@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header :title="'Laporan Barang'" :btnBack="false"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Laporan Barang</h2>
            <form action="/laporan/barang" method="get" target="_blank">
                <div class="žard">
                    <div class="card-body row pb-0">
                        <div class="form-group col-4">
                            <label for="kategori_barang_id" class="">Kategori Barang</label>
                            <select name="kategori_barang_id" id="kategori_barang_id" class="form-control select2 @error('kategori_barang_id') is-invalid @enderror">
                                <option value="">Semua </option>
                                @foreach ($kategoriBarangs as $kategori)
                                    <option value="{{ $kategori->id }}" {{ request('kategori_barang_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="print" value="true">
                    </div>
                    <div class="card-footer pt-0">
                        <button class="btn btn-info btn-icon icon-left text-white" type="submit">
                            <i class="fas fa-print"></i>
                            Cetak Laporan
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </x-main-content>
@endsection

@section('js')
    <script src="/stisla/dist/assets/modules/datatables/datatables.min.js"></script>
    <script src="/stisla/dist/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="/stisla/dist/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="/stisla/dist/assets/modules/jquery-ui/jquery-ui.min.js"></script>
@endsection
