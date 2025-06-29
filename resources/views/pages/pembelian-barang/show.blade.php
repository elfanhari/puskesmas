@extends('layouts.app-sidebar')

@section('css')
@endsection

@section('content')
    <x-main-content>
        <x-section-header title="Data Pembelian Barang" :btnBack="true"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Detail Pembelian Barang</h2>
            <div class="row">
                {{-- DETAIL PERMINTAAN --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Informasi Pembelian</h4>
                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-riwayat-status">
                                <i class="fas fa-clock"></i> Riwayat
                            </a>
                        </div>
                        <div class="card-body px-4">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th style="width: 40%">Pengaju</th>
                                    <td>{{ $pembelian->bendahara->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($pembelian->tanggal)->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $pembelian->status_color }}">
                                            <i class="{{ $pembelian->status_icon }}"></i>
                                            {{ $pembelian->status_label }}
                                        </span>
                                        @if (!in_array($pembelian->status, ['selesai', 'ditolak']) && in_array(auth()->user()->role, ['admin', 'kepsek']))
                                            <a href="#" class="text-underline" data-toggle="modal" data-target="#modal-edit-status">
                                                <u>Edit</u>
                                            </a>
                                        @endif
                                        @if (!in_array($pembelian->status, ['selesai', 'ditolak', 'menunggu_persetujuan']) && in_array(auth()->user()->role, ['bendahara']))
                                            <a href="#" class="text-underline" data-toggle="modal" data-target="#modal-edit-status">
                                                <u>Edit</u>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Feedback</th>
                                    <td>
                                        {{ $pembelian->feedback ?? '-' }}
                                        @if (in_array(auth()->user()->role, ['admin', 'kepsek']))
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
                        <div class="card-body px-2 table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr class="bg-light">
                                        <th style="width: 10%">#</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Supplier</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pembelian->itemPembelianBarang as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->barang->nama }}</td>
                                            <td>{{ $item->jumlah }}</td>
                                            <td>Rp {{ $item->harga_satuan_formatted }}</td>
                                            <td>{{ $item->supplier->name }}</td>
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

    @include('pages.pembelian-barang._modal-riwayat-status')
    @include('pages.pembelian-barang._modal-edit-status')
    @include('pages.pembelian-barang._modal-edit-feedback')
@endsection
@section('js')
@endsection
