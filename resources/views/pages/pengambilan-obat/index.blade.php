@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header title="Data Pengambilan Obat" :btnBack="false"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Index</h2>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="defaultTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pengambilan Obat</th>
                                    <th>No.RM</th>
                                    <th>Nama Pasien</th>
                                    <th>L/P</th>
                                    {{-- <th>Keluhan</th>
                                    <th>Obat</th>
                                    <th>Status</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengambilanObats as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->waktu_pengambilan_formatted }}</td>
                                        <td>{{ $item->rekamMedis->pendaftaran->pasien->no_kartu ?? '-' }}</td>
                                        <td>{{ $item->rekamMedis->pendaftaran->pasien->name ?? '-' }}</td>
                                        <td>{{ $item->rekamMedis->pendaftaran->pasien->jenis_kelamin ?? '-' }}</td>
                                        {{-- <td>{{ Str::limit($item->rekamMedis->pendaftaran->keluhan, 50) }}</td>
                                        <td class="ps-0">
                                            <ul style="padding-left: 0; margin: 0;">
                                                @foreach ($item->rekamMedis->obatRekamMedis as $orm)
                                                    <li>
                                                        {{ $orm->obat->name }} - ({{ $orm->jumlah }} {{ $orm->obat->satuan }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm badge-{{ $item->rekamMedis->status_color }}">
                                                <i class="{{ $item->rekamMedis->status_icon }}"></i>
                                                {{ $item->rekamMedis->status_label }}
                                            </span>
                                        </td> --}}
                                        <td class="">
                                            <div class="oneline">
                                                <a href="{{ route('rekam-medis.show', $item->rekamMedis->id) }}" class="btn btn-sm btn-success btn-icon icon-left">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>

                                                @if ($item->rekamMedis->status != 'selesai')
                                                    <a href="{{ route('pengambilan-obat.edit', $item->id) }}" class="btn btn-sm btn-warning btn-icon icon-left">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <button class="btn btn-primary btn-sm btn-icon icon-left btn-send-notif" data-no-telepon="{{ $item->rekamMedis->pendaftaran->pasien->telepon ?? '' }}" data-id="{{ $item->id }}"
                                                        data-name="{{ $item->rekamMedis->pendaftaran->pasien->name ?? '' }}">
                                                        <i class="fas fa-bell"></i>
                                                        Beritahu
                                                    </button>
                                                @endif


                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </x-main-content>

    {{-- Modal Filter Data --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-send-notif">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kirim Notifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Pasien: <span class="text-primary" id="pasien-name"></span> <br>
                    No. Telepon: <span class="text-primary" id="pasien-no-telepon"></span> <br>
                    <br>
                    Apakah anda yakin akan mengirim notifikasi SMS pengambilan obat ke nomor tersebut?
                </div>
                <div class="modal-footer justify-content-between bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirm-send-notif">Ya, kirim</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/stisla/dist/assets/modules/datatables/datatables.min.js"></script>
    <script src="/stisla/dist/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="/stisla/dist/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="/stisla/dist/assets/modules/jquery-ui/jquery-ui.min.js"></script>

    <script>
        let dataId = null;

        $('.btn-send-notif').on('click', function() {
            $('#pasien-name').html($(this).data('name'));
            $('#pasien-no-telepon').html($(this).data('no-telepon'));
            $('#modal-send-notif').modal('show');
            dataId = $(this).data('id');
        });

        $('#confirm-send-notif').on('click', function() {
            if (dataId) {
                sendNotif(dataId);
            }
        });

        function sendNotif(dataId) {
            $.ajax({
                url: `/pengambilan-obat/${dataId}/send-notif`,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#confirm-send-notif').attr('disabled', true).text('Mengirim...');
                },
                success: function(response) {
                    $('#modal-send-notif').modal('hide');
                    iziToast.success({
                        message: response.message,
                        position: 'topRight',
                        resetOnHover: false,
                        progressBar: false,
                        timeout: 5000,
                    });
                },
                error: function(xhr) {
                    $('#modal-send-notif').modal('hide');
                    iziToast.error({
                        message: xhr.responseJSON.message || 'Terjadi kesalahan saat mengirim notifikasi.',
                        position: 'topRight',
                        resetOnHover: false,
                        progressBar: false,
                        timeout: 5000,
                    });
                },
                complete: function() {
                    $('#confirm-send-notif').attr('disabled', false).text('Ya, kirim');
                }
            });
        }
    </script>
@endsection
