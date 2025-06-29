@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header :title="'Laporan Rekam Medis'" :btnBack="false"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Laporan Rekam Medis</h2>
            <form action="/laporan/rekam-medis" method="get" target="_blank">
                <div class="card">
                    <div class="card-body row pb-0">
                        <div class="form-group col-2">
                            <label for="dari_tanggal" class="">Dari Tanggal</label>
                            <input type="date" name="dari_tanggal" id="dari_tanggal" value="{{ request('dari_tanggal') }}" class="form-control @error('dari_tanggal') is-invalid @enderror">
                            @error('dari_tanggal')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-2">
                            <label for="sampai_tanggal" class="">Sampai Tanggal</label>
                            <input type="date" name="sampai_tanggal" id="sampai_tanggal" value="{{ request('sampai_tanggal') }}" class="form-control @error('sampai_tanggal') is-invalid @enderror">
                            @error('sampai_tanggal')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-3">
                            <label for="poli_id" class="">Poli</label>
                            <select name="poli_id" id="poli_id" class="form-control form-select @error('poli_id') is-invalid @enderror">
                                <option value="">Semua Poli</option>
                                @foreach ($polis as $poli)
                                    <option value="{{ $poli->id }}" {{ request('poli_id') == $poli->id ? 'selected' : '' }}>
                                        {{ $poli->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('poli_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-3">
                            <label for="dokter_id" class="">Dokter</label>
                            <select name="dokter_id" id="dokter_id" class="form-control form-select @error('dokter_id') is-invalid @enderror">
                                <option value="">Semua Dokter</option>
                                @foreach ($dokters as $dokter)
                                    <option value="{{ $dokter->id }}" {{ request('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                        {{ $dokter->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dokter_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-2">
                            <label for="status" class="">Status</label>
                            <select name="status" id="status" class="form form-control form-select @error('status') is-invalid @enderror">
                                <option value="">Semua</option>
                                @foreach ($statuses as $k => $v)
                                    <option value="{{ $k }}" {{ request('status') == $k ? 'selected' : '' }}>{{ $v }}</option>
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
