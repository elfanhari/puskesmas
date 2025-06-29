@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header :title="'Laporan Masuk/Keluar Barang'" :btnBack="false"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Laporan Masuk/Keluar Barang</h2>
            <form action="{{ route('laporan.barang-keluar-masuk') }}" method="get" target="_blank">
                <div class="card">
                    <div class="card-body row pb-0">
                        <div class="form-group col-md-4">
                            <label for="jenis required">Jenis Laporan</label>
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="permintaan" {{ request('jenis') == 'permintaan' ? 'selected' : '' }}>Barang Keluar (Permintaan)</option>
                                <option value="pembelian" {{ request('jenis') == 'pembelian' ? 'selected' : '' }}>Barang Masuk (Pembelian)</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tanggal_awal">Dari Tanggal</label>
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tanggal_akhir">Sampai Tanggal</label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                        </div>
                        <input type="hidden" name="print" value="true">

                        <input type="hidden" name="print" value="true">
                    </div>
                    <div class="card-footer pt-0">
                        <button class="btn btn-info btn-icon icon-left text-white" type="submit">
                            <i class="fas fa-print"></i> Cetak Laporan
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
