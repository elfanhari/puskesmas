<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        LAPORAN PERMINTAAN/PEMBELIAN BARANG
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

        .text-top {
            vertical-align: text-top;
        }

        .oneline {
            white-space: nowrap;
        }
    </style>
</head>

<body style="font-family: 'Times New Roman'; font-size: 14px">

    <div class="row" style="padding: 30px">
        <div class="text-center" style="text-align: center">
            <h3 class="fw-bold mb-1" style="margin-top: 0px; margin-bottom: 0px;">LAPORAN PERMINTAAN/PEMBELIAN BARANG</h3>
            <h3 class="fw-bold" style="margin-top: 0px; margin-bottom: 0px;">{{ $sekolah->name }}</h3>
            <p style="margin-top: 0px; margin-bottom: 0px;">{{ $sekolah->alamat }}</p>
            <div class="float-end">
                Tanggal Cetak: {{ date('d-m-Y') }}
            </div>
            <br>

            <hr />
        </div>

        <div class="col-12">
            <div class="hero bg-primary text-white">
                <div class="">
                    <table class="table table-bordered table-sm">
                        <tr>
                            <td>Jenis</td>
                            <td>: {{ ucfirst($jenis) }}</td>
                        </tr>
                        <tr>
                            <td>Pengaju</td>
                            <td>: {{ $pengaju ?? 'Semua' }}</td>
                        </tr>
                        <tr>
                            <td>Periode</td>
                            <td>: {{ $dari ?? '-' }} s/d {{ $sampai ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>: {{ ucfirst(str_replace('_', ' ', $status)) ?? 'Semua' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr />
        </div>

        <div class="section-body" style="margin-top: 30px">
            <div class="card">
                <div class="card-body invoice-print">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-top" border="1" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Pengaju</th>
                                    <th>Item</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $i => $row)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td class="oneline">{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                                        <td>{{ $jenis == 'permintaan' ? $row->guru->name : $row->bendahara->name }}</td>
                                        <td>
                                            <ul class="pl-1">
                                                @foreach ($jenis == 'permintaan' ? $row->itemPermintaanBarang : $row->itemPembelianBarang as $item)
                                                    <li> <b>{{ $item->barang->nama }}</b> - {{ $item->jumlah }} {{ $item->barang->satuan }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ strtoupper(str_replace('_', ' ', $row->status)) }}</td>
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
