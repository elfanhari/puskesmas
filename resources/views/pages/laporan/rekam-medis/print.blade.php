<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        LAPORAN REKAM MEDIS
    </title>
    <style>
        .fw-bold {
            font-weight: bold;
        }

        .align-middle {
            align-content: center;
        }

        .text-center {
            text-align: center;
        }

        .float-end {
            float: right;
        }
    </style>
</head>

<body style="font-family: 'Times New Roman'; font-size: 14px">

    <div class="row" style="padding: 30px">
        <div class="text-center" style="text-align: center">
            <h3 class="fw-bold mb-1" style="margin-top: 0px; margin-bottom: 0px;">LAPORAN REKAM MEDIS</h3>
            <h3 class="fw-bold" style="margin-top: 0px; margin-bottom: 0px;">{{ $puskesmas->name }}</h3>
            <p style="margin-top: 0px; margin-bottom: 0px;">{{ $puskesmas->alamat }}</p>
            <div class="float-end">
                Tanggal Cetak: {{ date('d-m-Y') }}
            </div>
            <br>

            <hr />
        </div>

        <div class="col-12">
            <div class="hero bg-primary text-white">
                <div class="mb-2">
                    <strong>Periode:</strong>
                    {{ $request->dari_tanggal ?? '-' }} s.d {{ $request->sampai_tanggal ?? '-' }}
                </div>
                <div class="mb-2">
                    <strong>Poli:</strong> {{ $request->poli_id ? $rekamMedis->first()?->poli?->name : 'Semua' }}<br>
                    <strong>Dokter:</strong> {{ $request->dokter_id ? $rekamMedis->first()?->dokter?->name : 'Semua' }}<br>
                    <strong>Status:</strong> {{ $request->status ? ucfirst(str_replace('_', ' ', $request->status)) : 'Semua' }}
                </div>
            </div>
            <hr />
        </div>

        <div class="section-body" style="margin-top: 30px">
            <div class="card">
                <div class="card-body invoice-print">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered" border="1" cellspacing="0" style="width: 100%">
                            <thead class="">
                                <tr class=" text-white">
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>L/P</th>
                                    <th>Keluhan</th>
                                    <th>Poli</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekamMedis as $index => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->pendaftaran->tanggal)->format('d/m/Y') }}</td>
                                        <td>{{ $item->pendaftaran->pasien->nik ?? '-' }}</td>
                                        <td>{{ $item->pendaftaran->pasien->name ?? '-' }}</td>
                                        <td>{{ $item->pendaftaran->pasien->jenis_kelamin ?? '-' }}</td>
                                        <td>{{ Str::limit($item->pendaftaran->keluhan, 50) }}</td>
                                        <td>{{ $item->poli->name ?? '-' }}</td>
                                        <td>{{ $item->dokter->name ?? '-' }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $item->status)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <script>
            window.onload = window.print();
        </script>
</body>

</html>
