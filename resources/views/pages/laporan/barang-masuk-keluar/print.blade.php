<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        LAPORAN MASUK/KELUAR BARANG
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
            <h3 class="fw-bold mb-1" style="margin-top: 0px; margin-bottom: 0px;">LAPORAN MASUK/KELUAR BARANG</h3>
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
                        <table>
                            <tr>
                                <td><strong>Jenis</strong></td>
                                <td>:</td>
                                <td>{{ ucfirst($namaJenis) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Periode</strong></td>
                                <td>:</td>
                                <td>{{ $tanggalAwal }} s/d {{ $tanggalAkhir }}</td>
                            </tr>
                        </table>
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
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    @if ($jenis == 'pembelian')
                                        <th>Supplier</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="oneline">{{ \Carbon\Carbon::parse($jenis == 'permintaan' ? $item->permintaanBarang?->tanggal : $item->pembelianBarang->tanggal)->format('d-m-Y') }}</td>
                                        <td>
                                            {{ $jenis == 'permintaan' ? $item->permintaanBarang?->guru->name : $item->pembelianBarang?->bendahara->name }}
                                        </td>
                                        <td>{{ $item->barang->nama }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->barang->satuan }}</td>
                                        @if ($jenis == 'pembelian')
                                            <td>{{ $item->supplier?->nama }}</td>
                                        @endif
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
