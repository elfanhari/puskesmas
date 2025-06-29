<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kartu Berobat - {{ $pasien->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        .card-container {
            width: 450px;
            border: 1px solid #333;
            padding: 16px;
            margin: 20px auto;
            border-radius: 8px;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #aaa;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header img {
            max-height: 60px;
            margin-bottom: 8px;
        }

        .header .title {
            font-size: 16px;
            font-weight: bold;
        }

        .info-table {
            width: 100%;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .label {
            width: 100px;
            font-weight: bold;
        }

        .footer {
            margin-top: 15px;
            font-size: 12px;
            text-align: center;
            border-top: 1px dashed #999;
            padding-top: 8px;
        }

        .float-left {
            float: left;
        }

        @media print {
            body {
                margin: 0;
            }

            .card-container {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="card-container">
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

        <table class="info-table">
            <tr>
                <td class="label">No. Kartu</td>
                <td>: {{ $pasien->no_kartu }}</td>
            </tr>
            <tr>
                <td class="label">Nama</td>
                <td>: {{ $pasien->name }}</td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td>: {{ $pasien->nik }}</td>
            </tr>
            <tr>
                <td class="label">Tgl Lahir</td>
                <td>: {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td>: {{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td>: {{ $pasien->alamat }}</td>
            </tr>
            <tr>
                <td class="label">Telepon</td>
                <td>: {{ $pasien->telepon }}</td>
            </tr>
        </table>

        <div class="footer">
            {{ $puskesmas->telepon ? 'Telp: ' . $puskesmas->telepon : '' }}
            {{ $puskesmas->email ? '| Email: ' . $puskesmas->email : '' }}
            {{ $puskesmas->website ? '| ' . $puskesmas->website : '' }}
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
