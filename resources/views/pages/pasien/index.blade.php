@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header title="Data Pasien" :btnBack="false"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Index</h2>
            <div class="card">
                @can('petugas')
                    <div class="card-header justify-content-between">
                        <a href="{{ route('pasien.create') }}" class="btn btn-primary btn-icon icon-left">
                            <i class="fas fa-plus pe-5"></i>
                            Tambah Pasien
                        </a>
                    </div>
                @endcan
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="defaultTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No. RM</th>
                                    <th>Nama </th>
                                    {{-- <th>NIK</th>
                                    <th>L/P</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pasiens as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $item->no_kartu }}</td>
                                        <td>{{ $item->name }}</td>
                                        {{-- <td>{{ $item->nik }}</td>
                                        <td>{{ $item->jenis_kelamin }}</td> --}}
                                        <td class="oneline">
                                            <div class="">
                                                <a href="{{ route('pasien.show', $item->id) }}" class="btn btn-sm btn-success btn-icon icon-left">
                                                    <i class="fas fa-eye"></i>
                                                    Show
                                                </a>
                                                @can('petugas')
                                                    <a href="{{ route('pasien.edit', $item->id) }}" class="btn btn-sm btn-warning btn-icon icon-left">
                                                        <i class="fas fa-pencil-alt"></i>
                                                        Edit
                                                    </a>
                                                    <button class="btn btn-sm btn-danger btn-icon icon-left btn-delete" data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                                                        <i class="fas fa-trash"></i>
                                                        Delete
                                                    </button>
                                                @endcan
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

    {{-- Modal Hapus Data --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-delete">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="form-delete">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Data: <span class="text-danger" id="delete-name"></span>
                        <br>
                        Apakah anda yakin akan menghapus data tersebut?
                    </div>
                    <div class="modal-footer justify-content-between bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, hapus</button>
                    </div>
                </form>
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
        $('.btn-delete').on('click', function() {
            $('#delete-name').html($(this).data('name'));
            $('#form-delete').attr('action', '/pasien/' + $(this).data('id'));
            $('#modal-delete').modal('show');
        });
    </script>
@endsection
