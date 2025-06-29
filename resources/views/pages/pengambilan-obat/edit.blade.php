@extends('layouts.app-sidebar')

@section('css')
    <link rel="stylesheet" href="/stisla/dist/assets/modules/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/customize/daterangepicker/style.css">
@endsection

@section('content')
    <x-main-content>
        <x-section-header title="Pengambilan Obat" :btnBack="true"></x-section-header>

        <div class="section-body">
            <h2 class="section-title">Edit</h2>
            <div class="alert alert-warning">
                Dengan mengubah status menjadi Selesai, maka pasien sudah mengambil obat yang telah diresepkan dan status rekam medis akan berubah menjadi Selesai.
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('pengambilan-obat.update', $pengambilanObat->id) }}" method="post">
                                @csrf
                                @method('PUT')

                                <div class="form-group mb-3">
                                    <label for="waktu_pengambilan" class="required">Waktu Pengambilan</label>
                                    <input type="text" name="waktu_pengambilan" id="waktu_pengambilan" value="{{ old('waktu_pengambilan', $pengambilanObat->waktu_pengambilan ?? date('Y-m-d')) }}" class="form-control datetimepicker @error('waktu_pengambilan') is-invalid @enderror" required>
                                    @error('waktu_pengambilan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="catatan_pengambilan_obat">Catatan</label>
                                    <textarea name="catatan_pengambilan_obat" id="catatan_pengambilan_obat" rows="3" class="form-control @error('catatan_pengambilan_obat') is-invalid @enderror" placeholder="Opsional">{{ old('catatan_pengambilan_obat', $pengambilanObat->catatan ?? '') }}</textarea>
                                    @error('catatan_pengambilan_obat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status" class="required">Status</label>
                                    <select name="status" id="status" class="form-control form-select @error('status') is-invalid @enderror" data-placeholder="Pilih Pasien">
                                        <option value=""></option>
                                        @foreach (['menunggu_obat' => 'Menunggu Obat', 'selesai' => 'Selesai'] as $key => $label)
                                            <option value="{{ $key }}" {{ old('status', $pengambilanObat->rekamMedis->status) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h4>List Obat</h4>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </x-main-content>
@endsection

@section('js')
    <script src="/customize/daterangepicker/script.js"></script>
@endsection
