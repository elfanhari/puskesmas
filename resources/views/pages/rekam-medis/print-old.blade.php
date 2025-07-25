<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Rekam Medis - {{ $pendaftaran->pasien->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
        }

        .section {
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .info-table .label {
            width: 160px;
            font-weight: bold;
        }

        .list-group {
            margin: 0;
            padding-left: 20px;
        }

        .list-group li {
            margin-bottom: 4px;
        }

        .badge {
            display: inline-block;
            background: #eee;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
        }

        @media print {
            body {
                margin: 0;
            }

            .section {
                page-break-inside: avoid;
            }
        }

        .fs-12 {
            font-size: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #aaa;
            padding-bottom: 10px;
            margin-bottom: 8px;
        }

        .header img {
            max-height: 60px;
            margin-bottom: 8px;
        }

        .header .title {
            font-size: 16px;
            font-weight: bold;
        }

        .float-left {
            float: left;
        }
    </style>
</head>

<body class="fs-12">

    <div class="header">
        @if (!empty($puskesmas->logo))
            <div class="float-left">
                <img src="{{ $puskesmas->url_logo }}" alt="Logo" style="max-height: 50px;">
            </div>
        @endif
        <div class="title">KARTU BEROBAT</div>
        <div class="title">{{ $puskesmas->name }}</div>
        <div>{{ $puskesmas->alamat }}</div>
    </div>
    <div class="section">
        <div class="section-title">Informasi Pasien</div>
        <table class="info-table">
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
                <tr>
                    <td class="label">{{ $label }}</td>
                    <td>: {!! nl2br(e($value)) !!}</td>
                </tr>
            @endforeach
            <tr>
                <td class="label">Status</td>
                <td>
                    : <span class="badge">{{ $rekamMedis->status_label }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section fs-12">
        <div class="section-title">Pemeriksaan Lanjutan</div>
        <table class="info-table">
            <tr>
                <td class="label">Poli</td>
                <td>: {{ $rekamMedis->poli->name }}</td>
            </tr>
            <tr>
                <td class="label">Dokter</td>
                <td>: {{ $rekamMedis->dokter->name }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Diagnosa & Tindakan</div>
        <table class="info-table">
            <tr>
                <td class="label">Diagnosa</td>
                <td>: {{ $rekamMedis->diagnosa }}</td>
            </tr>
            <tr>
                <td class="label">Tindakan</td>
                <td>: {{ $rekamMedis->tindakan }}</td>
            </tr>
            <tr>
                <td class="label">Catatan Tambahan</td>
                <td>: {{ $rekamMedis->catatan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Keputusan</td>
                <td>: {{ $rekamMedis->keputusan_formatted }}</td>
            </tr>
        </table>
    </div>

    @if ($rekamMedis->keputusan === 'diberi_obat')
        <div class="section">
            <div class="section-title">Obat yang Diberikan</div>
            <ul class="list-group">
                @foreach ($obatRekamMedis as $item)
                    <li>{{ $item->obat->name }} ({{ $item->obat->satuan }}) - <strong>{{ $item->jumlah }}</strong></li>
                @endforeach
            </ul>
            @if ($pengambilanObat)
                <table class="info-table" style="margin-top: 10px;">
                    <tr>
                        <td class="label">Waktu Pengambilan</td>
                        <td>: {{ $pengambilanObat->waktu_pengambilan }}</td>
                    </tr>
                    <tr>
                        <td class="label">Catatan</td>
                        <td>: {{ $pengambilanObat->catatan ?? '-' }}</td>
                    </tr>
                </table>
            @endif
        </div>
    @endif

    @if ($rekamMedis->keputusan === 'dirujuk' && $rujukan)
        <div class="section">
            <div class="section-title">Rujukan</div>
            <table class="info-table">
                <tr>
                    <td class="label">Rumah Sakit Tujuan</td>
                    <td>: {{ $rujukan->rumah_sakit_tujuan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Alasan Rujukan</td>
                    <td>: {{ $rujukan->alasan ?? '-' }}</td>
                </tr>
            </table>
        </div>
    @endif

    <script>
        window.print();
    </script>
</body>

</html>
