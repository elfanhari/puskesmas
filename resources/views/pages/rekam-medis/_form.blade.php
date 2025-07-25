<div class="card">
    <div class="card-header justify-content-between">
        <h4>Screening Awal</h4>
        <div class="">
            <span class="badge badge-sm badge-{{ $rekamMedis->status_color }}">
                <i class="{{ $rekamMedis->status_icon }}"></i>
                {{ $rekamMedis->status_label }}
            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- Kolom Kiri --}}
            <div class="col-md-6">
                <input type="hidden" name="petugas_id" value="{{ $pendaftaran->petugas_id }}">

                {{-- Pasien --}}
                <div class="form-group mb-3">
                    <label for="pasien_id" class="required">Pasien</label>
                    <select name="pasien_id" id="pasien_id" class="form-control form-select @error('pasien_id') is-invalid @enderror" data-placeholder="Pilih Pasien" disabled>
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
                </div>

                {{-- Tanggal --}}
                <div class="form-group mb-3">
                    <label for="tanggal" class="required">Tanggal Kunjungan</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $pendaftaran->tanggal ?? date('Y-m-d')) }}" class="form-control @error('tanggal') is-invalid @enderror" required readonly>
                    @error('tanggal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Keluhan --}}
                <div class="form-group mb-3">
                    <label for="keluhan" class="required">Keluhan</label>
                    <textarea name="keluhan" id="keluhan" rows="3" class="form-control @error('keluhan') is-invalid @enderror" placeholder="Masukkan keluhan pasien" required readonly>{{ old('keluhan', $pendaftaran->keluhan ?? '') }}</textarea>
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
                    <input type="text" name="tekanan_darah" id="tekanan_darah" value="{{ old('tekanan_darah', $pendaftaran->tekanan_darah ?? '') }}" placeholder="Contoh: 120/80" class="form-control @error('tekanan_darah') is-invalid @enderror" readonly>
                    @error('tekanan_darah')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Suhu --}}
                <div class="form-group mb-3">
                    <label for="suhu">Suhu Tubuh (°C)</label>
                    <input type="number" step="0.1" name="suhu" id="suhu" value="{{ old('suhu', $pendaftaran->suhu ?? '') }}" class="form-control @error('suhu') is-invalid @enderror" readonly>
                    @error('suhu')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tinggi Badan --}}
                <div class="form-group mb-3">
                    <label for="tinggi_badan">Tinggi Badan (cm)</label>
                    <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan" value="{{ old('tinggi_badan', $pendaftaran->tinggi_badan ?? '') }}" class="form-control @error('tinggi_badan') is-invalid @enderror" readonly>
                    @error('tinggi_badan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Berat Badan --}}
                <div class="form-group mb-3">
                    <label for="berat_badan">Berat Badan (kg)</label>
                    <input type="number" step="0.1" name="berat_badan" id="berat_badan" value="{{ old('berat_badan', $pendaftaran->berat_badan ?? '') }}" class="form-control @error('berat_badan') is-invalid @enderror" readonly>
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
                    <select name="poli_id" id="poli_id" class="form-control form-select  @error('poli_id') is-invalid @enderror" data-placeholder="Pilih Poli" required disabled>
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
                    <select name="dokter_id" id="dokter_id" class="form-control form-select  @error('dokter_id') is-invalid @enderror" data-placeholder="Pilih Dokter" required disabled>
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

<div class="row">
    <div class="col-md-6" id="pemeriksaan">
        <div class="card">
            <div class="card-header">
                <h4>Hasil Pemeriksaan</h4>
            </div>
            <div class="card-body">

                <div class="form-group mb-3">
                    <label for="hasil_lab" class="required">Hasil Lab</label>
                    <textarea name="hasil_lab" id="hasil_lab" rows="3" class="form-control @error('hasil_lab') is-invalid @enderror" placeholder="Masukkan hasil_lab" required>{{ old('hasil_lab', $rekamMedis->hasil_lab ?? '') }}</textarea>
                    @error('hasil_lab')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="diagnosa" class="required">Diagnosa</label>
                    <textarea name="diagnosa" id="diagnosa" rows="3" class="form-control @error('diagnosa') is-invalid @enderror" placeholder="Masukkan diagnosa" required>{{ old('diagnosa', $rekamMedis->diagnosa ?? '') }}</textarea>
                    @error('diagnosa')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="tindakan" class="required">Tindakan</label>
                    <textarea name="tindakan" id="tindakan" rows="3" class="form-control @error('tindakan') is-invalid @enderror" placeholder="Masukkan tindakan medis" required>{{ old('tindakan', $rekamMedis->tindakan ?? '') }}</textarea>
                    @error('tindakan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="catatan">Catatan Tambahan</label>
                    <textarea name="catatan" id="catatan" rows="3" class="form-control @error('catatan') is-invalid @enderror" placeholder="Opsional">{{ old('catatan', $rekamMedis->catatan ?? '') }}</textarea>
                    @error('catatan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="keputusan" class="required">Keputusan</label>
                    <select name="keputusan" id="keputusan" class="form-control form-select @error('keputusan') is-invalid @enderror" data-placeholder="Pilih Keputusan" required>
                        <option value="">Pilih</option>
                        <option value="diberi_obat" {{ old('keputusan', $rekamMedis->keputusan ?? '') == 'diberi_obat' ? 'selected' : '' }}> Diberi Obat </option>
                        <option value="dirujuk" {{ old('keputusan', $rekamMedis->keputusan ?? '') == 'dirujuk' ? 'selected' : '' }}> Perlu Dirujuk </option>
                    </select>
                    @error('keputusan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-6" id="obat-rekam-medis">
        <div class="card">
            <div class="card-header">
                <h4>Obat yang Diberikan</h4>
            </div>
            <div class="card-body">

                <div class="table-responsive mb-3">
                    <table class="table table-striped table-sm">
                        <tr>
                            <th>Obat</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                        @forelse ($obatRekamMedis as $itemObat)
                            <tr>
                                <td>
                                    <select name="obat_id[]" class="form-control form-select @error('obat_id') is-invalid @enderror" data-placeholder="Pilih Obat">
                                        <option value=""></option>
                                        @foreach ($obats as $obat)
                                            <option value="{{ $obat->id }}" {{ $itemObat->obat_id == $obat->id ? 'selected' : '' }}>
                                                {{ $obat->name }} ({{ $obat->satuan }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="jumlah[]" class="form-control @error('jumlah') is-invalid @enderror" value="{{ $itemObat->jumlah }}" placeholder="">
                                </td>
                                <td class="oneline">
                                    <button type="button" class="btn btn-danger btn-sm btn-remove-obat">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm btn-add-obat">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>
                                    <select name="obat_id[]" class="form-control form-select @error('obat_id') is-invalid @enderror" data-placeholder="Pilih Obat">
                                        <option value=""></option>
                                        @foreach ($obats as $obat)
                                            <option value="{{ $obat->id }}">
                                                {{ $obat->name }} ({{ $obat->satuan }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="jumlah[]" class="form-control @error('jumlah') is-invalid @enderror" placeholder="">
                                </td>
                                <td class="oneline">
                                    <button type="button" class="btn btn-danger btn-sm btn-remove-obat">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm btn-add-obat">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </table>
                </div>

                <div id="pengambilan-obat" class="d-none">
                    <div class="form-group mb-3">
                        <label for="waktu_pengambilan" class="">Waktu Pengambilan</label>
                        <input type="text" name="waktu_pengambilan" id="waktu_pengambilan" value="{{ old('waktu_pengambilan', $pengambilanObat->waktu_pengambilan ?? date('Y-m-d')) }}" class="form-control datetimepicker @error('waktu_pengambilan') is-invalid @enderror">
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
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-6" id="rujukan">
        <div class="card">
            <div class="card-header">
                <h4>Rujukan</h4>
            </div>
            <div class="card-body">

                <div class="form-group mb-3">
                    <label for="rumah_sakit_tujuan">Rumah Sakit Tujuan</label>
                    <input type="text" name="rumah_sakit_tujuan" id="rumah_sakit_tujuan" value="{{ old('rumah_sakit_tujuan', $rujukan->rumah_sakit_tujuan ?? '') }}" class="form-control @error('rumah_sakit_tujuan') is-invalid @enderror">
                    @error('rumah_sakit_tujuan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="alasan">Alasan Rujukan</label>
                    <textarea name="alasan" id="alasan" rows="3" class="form-control @error('alasan') is-invalid @enderror">{{ old('alasan', $rujukan->alasan ?? '') }}</textarea>
                    @error('alasan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>
    </div>

</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('#keputusan').change(function() {
                toggleKeputusan();
            });

            function toggleKeputusan() {
                const keputusan = $('#keputusan').val();
                if (keputusan === 'diberi_obat') {
                    $('#obat-rekam-medis').removeClass('d-none');
                    $('#rujukan').addClass('d-none');
                    if ($('#poli_id').val() == '1') {
                        $('#pengambilan-obat').removeClass('d-none');
                    } else {
                        $('#pengambilan-obat').addClass('d-none');
                    }
                } else if (keputusan === 'dirujuk') {
                    $('#rujukan').removeClass('d-none');
                    $('#obat-rekam-medis').addClass('d-none');
                } else {
                    $('#obat-rekam-medis').addClass('d-none');
                    $('#rujukan').addClass('d-none');
                }
            }
            toggleKeputusan();

            // Fungsi untuk update tombol (+ dan -)
            function updateButtons() {
                const rows = $('.table-responsive table tbody tr');
                rows.find('.btn-add-obat').hide();
                rows.find('.btn-remove-obat').show();

                if (rows.length === 2) {
                    rows.find('.btn-remove-obat').hide();
                }

                rows.last().find('.btn-add-obat').show();
            }

            // Klik tombol tambah baris
            $(document).on('click', '.btn-add-obat', function() {
                const $tr = $(this).closest('tr');
                const $clone = $tr.clone();
                $clone.find('select').val('');
                $clone.find('input').val('');
                $tr.after($clone);
                updateButtons();
            });

            // Klik tombol hapus baris
            $(document).on('click', '.btn-remove-obat', function() {
                const $tr = $(this).closest('tr');
                if ($('.table-responsive table tbody tr').length > 2) {
                    $tr.remove();
                    updateButtons();
                }
            });

            updateButtons();
        });
    </script>
@endpush

@push('css')
@endpush
