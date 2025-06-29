@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header title="Data Pendaftaran" :btnBack="false"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Index</h2>
            <div class="card">
                <div class="card-header justify-content-end">
                    <a class="btn btn-info btn-icon icon-left text-white" data-toggle="modal" data-target="#modal-filter">
                        <i class="fas fa-filter pe-5"></i>
                        Filter
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="defaultTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>NIK</th>
                                    <th>Nama Pasien</th>
                                    <th>L/P</th>
                                    <th>Keluhan</th>
                                    <th>Poli</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekamMedis as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->pendaftaran->tanggal)->translatedFormat('d/m/Y') }}</td>
                                        <td>{{ $item->pendaftaran->pasien->nik ?? '-' }}</td>
                                        <td>{{ $item->pendaftaran->pasien->name ?? '-' }}</td>
                                        <td>{{ $item->pendaftaran->pasien->jenis_kelamin ?? '-' }}</td>
                                        <td>{{ Str::limit($item->pendaftaran->keluhan, 50) }}</td>
                                        <td>{{ $item->poli->name ?? '-' }}</td>
                                        <td>{{ $item->dokter->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-sm badge-{{ $item->status_color }}">
                                                <i class="{{ $item->status_icon }}"></i>
                                                {{ $item->status_label }}
                                            </span>
                                        </td>
                                        <td class="oneline">
                                            <div>
                                                <a href="{{ route('rekam-medis.show', $item->id) }}" class="btn btn-sm btn-success btn-icon icon-left">
                                                    <i class="fas fa-eye"></i> Show
                                                </a>

                                                @if ($item->status != 'selesai')
                                                    @if ($item->status == 'menunggu_diperiksa')
                                                        <a href="{{ route('rekam-medis.edit', ['rekam_medis' => $item->id, 'is_diperiksa' => true]) }}" class="btn btn-sm btn-dark btn-icon icon-left">
                                                            <i class="fas fa-stethoscope"></i>
                                                            Periksa
                                                        </a>
                                                    @else
                                                        <a href="{{ route('rekam-medis.edit', $item->id) }}" class="btn btn-sm btn-warning btn-icon icon-left">
                                                            <i class="fas fa-pencil-alt"></i> Edit
                                                        </a>
                                                    @endif
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
    @include('pages.rekam-medis._filter')
@endsection

@section('js')
    <script src="/stisla/dist/assets/modules/datatables/datatables.min.js"></script>
    <script src="/stisla/dist/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="/stisla/dist/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="/stisla/dist/assets/modules/jquery-ui/jquery-ui.min.js"></script>

    <script>
        $('.btn-delete').on('click', function() {
            $('#delete-name').html($(this).data('name'));
            $('#form-delete').attr('action', '/pendaftaran/' + $(this).data('id'));
            $('#modal-delete').modal('show');
        });
    </script>
@endsection
