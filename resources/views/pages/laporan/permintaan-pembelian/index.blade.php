@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header :title="'Laporan Permintaan / Pembelian Barang'" :btnBack="false"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Laporan Permintaan / Pembelian Barang</h2>
            <form action="{{ route('laporan.permintaan-pembelian') }}" method="get" target="_blank">
                <div class="card">
                    <div class="card-body row pb-0">
                        <div class="form-group col-md-3">
                            <label class="required">Jenis</label>
                            <select name="jenis" id="jenis" class="form-control " required>
                                <option value="">Pilih</option>
                                <option value="permintaan">Permintaan Barang</option>
                                <option value="pembelian">Pembelian Barang</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Pengaju</label>
                            <select name="pengaju_id" id="pengaju_id" class="form-control select2">
                                <option value="">Semua</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Dari Tanggal</label>
                            <input type="date" name="dari" class="form-control">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Sampai Tanggal</label>
                            <input type="date" name="sampai" class="form-control">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Status</label>
                            <select name="status" class="form-control ">
                                <option value="">Semua</option>
                                <option value="diajukan">Diajukan</option>
                                <option value="menunggu_persetujuan">Menunggu Persetujuan</option>
                                <option value="disetujui">Disetujui</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>

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

    <script>
        const gurus = @json($gurus);
        const bendaharas = @json($bendaharas);

        function updatePengajuOptions(role) {
            const target = $('#pengaju_id');
            target.html('<option value="">Semua</option>');

            const data = role === 'permintaan' ? gurus : bendaharas;

            data.forEach(function(user) {
                target.append(`<option value="${user.id}">${user.name}</option>`);
            });
        }

        $('#jenis').on('change', function() {
            updatePengajuOptions($(this).val());
        });

        $(document).ready(() => {
            updatePengajuOptions($('#jenis').val());
        });
    </script>
@endsection
