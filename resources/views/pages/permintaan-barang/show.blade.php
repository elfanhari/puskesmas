@extends('layouts.app-sidebar')

@section('css')
@endsection

@section('content')
    <x-main-content>
        <x-section-header title="Data Permintaan Barang" :btnBack="true"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Detail Permintaan Barang</h2>
            <div class="row">
                {{-- DETAIL PERMINTAAN --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Informasi Permintaan</h4>
                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-riwayat-status">
                                <i class="fas fa-clock"></i> Riwayat
                            </a>
                        </div>
                        <div class="card-body px-4">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th style="width: 40%">Pengaju</th>
                                    <td>{{ $permintaan->guru->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($permintaan->tanggal)->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Alasan Permintaan</th>
                                    <td>{{ $permintaan->alasan }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $permintaan->status_color }}">
                                            <i class="{{ $permintaan->status_icon }}"></i>
                                            {{ $permintaan->status_label }}
                                        </span>
                                        @if (!in_array($permintaan->status, ['selesai', 'ditolak']) && in_array(auth()->user()->role, ['admin', 'tu', 'kepsek']))
                                            <a href="#" class="text-underline" data-toggle="modal" data-target="#modal-edit-status">
                                                <u>Edit</u>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Feedback</th>
                                    <td>
                                        {{ $permintaan->feedback ?? '-' }}
                                        @if (in_array(auth()->user()->role, ['admin', 'tu', 'kepsek']))
                                            <a href="#" class="text-underline ms-2" data-toggle="modal" data-target="#modal-edit-feedback">
                                                <u>Edit</u>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ITEM BARANG --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Item Barang</h4>
                        </div>
                        <div class="card-body px-2">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr class="bg-light">
                                        <th style="width: 10%">#</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($permintaan->itemPermintaanBarang as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->barang->nama }}</td>
                                            <td>{{ $item->jumlah }}</td>
                                            <td>{{ $item->barang->satuan }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Tidak ada item barang.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-main-content>

    @include('pages.permintaan-barang._modal-riwayat-status')
    @include('pages.permintaan-barang._modal-edit-status')
    @include('pages.permintaan-barang._modal-edit-feedback')
@endsection
@section('js')
@endsection
