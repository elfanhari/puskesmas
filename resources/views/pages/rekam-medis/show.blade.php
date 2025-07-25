@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/customize/daterangepicker/style.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header title="Data Rekam Medis" :btnBack="true"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Detail</h2>
            <div class="mb-4 mt-0">
                <a href="{{ route('rekam-medis.print', $rekamMedis->id) }}" class="btn btn-sm btn-primary" target="_blank">
                    <i class="fas fa-print"></i>
                    Cetak Rekam Medis
                </a>
                @if ($rekamMedis->status == 'menunggu_diperiksa')
                    <a href="{{ route('rekam-medis.edit', ['rekam_medis' => $rekamMedis->id, 'is_diperiksa' => true]) }}" class="btn btn-sm btn-dark btn-icon icon-left ms-3">
                        <i class="fas fa-stethoscope"></i>
                        Periksa
                    </a>
                @endif
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-light text-dark">
                            <h5 class="mb-0">Informasi Pasien</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $info = [
                                    'Nama' => $pendaftaran->pasien->name,
                                    'No.RM' => $pendaftaran->pasien->no_kartu,
                                    'Jenis Kelamin' => $pendaftaran->pasien->jk_formatted,
                                    'Tanggal Kunjungan' => Carbon\Carbon::parse($pendaftaran->tanggal_kunjungan)->translatedFormat('d/m/Y'),
                                    'Keluhan' => $pendaftaran->keluhan,
                                    'Tekanan Darah' => $pendaftaran->tekanan_darah,
                                    'Suhu Tubuh' => $pendaftaran->suhu . ' °C',
                                    'Tinggi Badan' => $pendaftaran->tinggi_badan . ' cm',
                                    'Berat Badan' => $pendaftaran->berat_badan . ' kg',
                                ];
                            @endphp

                            @foreach ($info as $label => $value)
                                <div class="row mb-2">
                                    <div class="col-sm-4 text-sm-end fw-bold">
                                        <b> {{ $label }} </b>
                                    </div>
                                    <div class="col-sm-8">
                                        : {!! nl2br(e($value)) !!}
                                    </div>
                                </div>
                            @endforeach
                            <div class="row mb-2">
                                <div class="col-sm-4 text-sm-end fw-bold">
                                    <b>Status</b>
                                </div>
                                <div class="col-sm-8">
                                    :
                                    <span class="badge badge-sm badge-{{ $rekamMedis->status_color }}">
                                        <i class="{{ $rekamMedis->status_icon }}"></i>
                                        {{ $rekamMedis->status_label }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-light text-dark">
                            <h5 class="mb-0">Pemeriksaan Lanjutan</h5>
                        </div>
                        <div class="card-body">

                            <div class="fw-bold pt-0"><b>Poli</b></div>
                            <div class="text-gray-600">{{ $rekamMedis->poli->name }}</div>

                            <div class="fw-bold mt-3"><b>Dokter</b></div>
                            <div class="text-gray-600">{{ $rekamMedis->dokter->name }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-light text-dark">
                            <h5 class="mb-0">Diagnosa & Tindakan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-2"><strong>Hasil Lab</strong><br> {{ $rekamMedis->hasil_lab ?? '-' }}</div>
                            <div class="mb-2"><strong>Diagnosa</strong><br> {{ $rekamMedis->diagnosa ?? '-' }}</div>
                            <div class="mb-2"><strong>Tindakan</strong><br> {{ $rekamMedis->tindakan ?? '-' }}</div>
                            <div class="mb-2"><strong>Catatan Tambahan</strong><br> {{ $rekamMedis->catatan ?? '-' }}</div>
                            <div class="mb-2"><strong>Keputusan</strong> <br> {{ $rekamMedis->keputusan_formatted }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    @if ($rekamMedis->keputusan === 'diberi_obat')
                        <div class="card mb-4">
                            <div class="card-header bg-light text-dark">
                                <h5 class="mb-0">Obat yang Diberikan</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach ($obatRekamMedis as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $item->obat->name }} ({{ $item->obat->satuan }})
                                            <span class="badge bg-light">{{ $item->jumlah }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                @if ($pengambilanObat)
                                    <div class="mt-3">
                                        <div class="mb-2"><strong>Waktu Pengambilan</strong> <br> {{ $pengambilanObat->waktu_pengambilan }}</div>
                                        <div class="mb-2"><strong>Catatan</strong> <br>{{ $pengambilanObat->catatan ?? '-' }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($rekamMedis->keputusan === 'dirujuk' && $rujukan)
                        <div class="card">
                            <div class="card-header bg-light text-dark py-0">
                                <h5 class="mb-0">Rujukan</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-2"><strong>Rumah Sakit Tujuan</strong> <br> {{ $rujukan->rumah_sakit_tujuan ?? '-' }}</div>
                                <div class="mb-2"><strong>Alasan Rujukan</strong><br> {{ $rujukan->alasan ?? '-' }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-main-content>
@endsection

@section('js')
    <script src="/customize/daterangepicker/script.js"></script>
@endsection
