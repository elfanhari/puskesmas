<div class="card">
    <div class="card-header justify-content-between">
        <h4>Screening Awal</h4>
    </div>
    <div class="card-body">

        <div class="row">
            {{-- Kolom Kiri --}}
            <div class="col-md-6">
                <input type="hidden" name="petugas_id" value="{{ $pendaftaran->petugas_id }}">

                {{-- Pasien --}}
                <div class="form-group mb-3">
                    <label for="pasien_id" class="required">Pasien</label>
                    <select name="pasien_id" id="pasien_id" class="form-control form-select select2 @error('pasien_id') is-invalid @enderror" data-placeholder="Pilih Pasien">
                        <option value=""></option>
                        @foreach ($pasiens as $pasien)
                            <option value="{{ $pasien->id }}" {{ old('pasien_id', $pendaftaran->pasien_id ?? '') == $pasien->id ? 'selected' : '' }}>
                                {{ $pasien->name }} | {{ $pasien->nik }} | {{ $pasien->jk_formatted }}
                            </option>
                        @endforeach
                    </select>
                    @error('pasien_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div class="mt-2">
                        Belum ada data pasien? <a href="{{ route('pasien.create') }}" class="text-primary">tambah data pasien</a>
                    </div>
                </div>

                {{-- Tanggal --}}
                <div class="form-group mb-3">
                    <label for="tanggal" class="required">Tanggal Kunjungan</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $pendaftaran->tanggal ?? date('Y-m-d')) }}" class="form-control @error('tanggal') is-invalid @enderror" required>
                    @error('tanggal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Keluhan --}}
                <div class="form-group mb-3">
                    <label for="keluhan" class="required">Keluhan</label>
                    <textarea name="keluhan" id="keluhan" rows="3" class="form-control @error('keluhan') is-invalid @enderror" placeholder="Masukkan keluhan pasien" required>{{ old('keluhan', $pendaftaran->keluhan ?? '') }}</textarea>
                    @error('keluhan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-md-6">
                {{-- Tekanan Darah --}}
                <div class="form-group mb-3">
                    <label for="tekanan_darah">Tekanan Darah</label>
                    <input type="text" name="tekanan_darah" id="tekanan_darah" value="{{ old('tekanan_darah', $pendaftaran->tekanan_darah ?? '') }}" placeholder="Contoh: 120/80" class="form-control @error('tekanan_darah') is-invalid @enderror">
                    @error('tekanan_darah')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Suhu --}}
                <div class="form-group mb-3">
                    <label for="suhu">Suhu Tubuh (°C)</label>
                    <input type="number" step="0.1" name="suhu" id="suhu" value="{{ old('suhu', $pendaftaran->suhu ?? '') }}" class="form-control @error('suhu') is-invalid @enderror">
                    @error('suhu')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tinggi Badan --}}
                <div class="form-group mb-3">
                    <label for="tinggi_badan">Tinggi Badan (cm)</label>
                    <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan" value="{{ old('tinggi_badan', $pendaftaran->tinggi_badan ?? '') }}" class="form-control @error('tinggi_badan') is-invalid @enderror">
                    @error('tinggi_badan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Berat Badan --}}
                <div class="form-group mb-3">
                    <label for="berat_badan">Berat Badan (kg)</label>
                    <input type="number" step="0.1" name="berat_badan" id="berat_badan" value="{{ old('berat_badan', $pendaftaran->berat_badan ?? '') }}" class="form-control @error('berat_badan') is-invalid @enderror">
                    @error('berat_badan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <hr>

        <div class="alert alert-light">
            Berdasarkan hasil screening awal, ditentukan bahwa pemeriksaan lanjutan:
        </div>

        <div class="row">
            <div class="col-md-6">
                {{-- Poli --}}
                <div class="form-group mb-3">
                    <label for="poli_id" class="required">Poli</label>
                    <select name="poli_id" id="poli_id" class="form-control form-select select2 @error('poli_id') is-invalid @enderror" data-placeholder="Pilih Poli" required>
                        <option value=""></option>
                        @foreach ($polis as $poli)
                            <option value="{{ $poli->id }}" {{ old('poli_id', $pendaftaran->rekamMedis->poli_id ?? '') == $poli->id ? 'selected' : '' }}>
                                {{ $poli->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('poli_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                {{-- Dokter --}}
                <div class="form-group mb-3">
                    <label for="dokter_id" class="required">Dokter</label>
                    <select name="dokter_id" id="dokter_id" class="form-control form-select  select2 @error('dokter_id') is-invalid @enderror" data-placeholder="Pilih Dokter" required>
                        <option value=""></option>
                        @foreach ($dokters as $dokter)
                            <option value="{{ $dokter->id }}" {{ old('dokter_id', $pendaftaran->rekamMedis->dokter_id ?? '') == $dokter->id ? 'selected' : '' }}>
                                {{ $dokter->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('dokter_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
