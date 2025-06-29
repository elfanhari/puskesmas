@extends('layouts.app-sidebar')

@section('css')
@endsection

@section('content')
    <x-main-content>
        <x-section-header title="Data Pasien" :btnBack="true"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Show</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ $pasien->no_kartu }}</h4>
                            <a href="{{ route('pasien.kartu-berobat', $pasien) }}" class="btn btn-primary" target="_blank">
                                <i class="fas fa-print me-1"></i>
                                Cetak Kartu Berobat
                            </a>
                        </div>
                        <div class="card-body px-3 pt-0 mt-0">
                            <div class="profile-widget px-2 pt-0 mt-4">

                                <div class="fw-bold pt-0"><b>Nama Pasien</b></div>
                                <div class="text-gray-600">{{ $pasien->name ?? '-' }}</div>

                                <div class="fw-bold mt-3"><b>NIK</b></div>
                                <div class="text-gray-600">{{ $pasien->nik ?? '-' }}</div>

                                <div class="fw-bold mt-3"><b>Tanggal Lahir</b></div>
                                <div class="text-gray-600">
                                    {{ $pasien->tanggal_lahir_formatted }}
                                </div>

                                <div class="fw-bold mt-3"><b>Jenis Kelamin</b></div>
                                <div class="text-gray-600">
                                    {{ $pasien->jenis_kelamin_formatted }}
                                </div>

                                <div class="fw-bold mt-3"><b>Alamat</b></div>
                                <div class="text-gray-600">{{ $pasien->alamat ?? '-' }}</div>

                                <div class="fw-bold mt-3"><b>Telepon</b></div>
                                <div class="text-gray-600">{{ $pasien->telepon ?? '-' }}</div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header fw-bold">
                            Riwayat Kunjungan
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;">No</th>
                                            <th>Tanggal</th>
                                            <th>Keluhan</th>
                                            <th style="width: 80px;">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($riwayat as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d/m/Y') }}</td>
                                                <td>{{ Str::limit($item->keluhan, 40) }}</td>
                                                <td>
                                                    <a href="{{ route('rekam-medis.show', $item->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Belum ada kunjungan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </x-main-content>
@endsection
@section('js')
@endsection
