<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        LAPORAN BARANG
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
            <h3 class="fw-bold mb-1" style="margin-top: 0px; margin-bottom: 0px;">LAPORAN BARANG</h3>
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
                    <table class="table-sm" border="0" cellspacing="1">
                        <tr>
                            <td class="fw-bold">Kategori</td>
                            <td>:</td>
                            <td>{{ $namaKategori }}</td>
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
                        <table class="table table-sm table-striped table-bordered" border="1" cellspacing="0" style="width: 100%">
                            <thead class="">
                                <tr class=" text-white">
                                    <td rowspan="2" class="align-middle text-center fw-bold ">#</td>
                                    <td rowspan="2" class="align-middle text-center fw-bold ">Kode</td>
                                    <td rowspan="2" class="align-middle text-center fw-bold ">Nama</td>
                                    <td rowspan="2" class="align-middle text-center fw-bold ">Kategori</td>
                                    <td colspan="7" class="align-middle text-center fw-bold ">Stok</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->kategoriBarang->nama ?? '-' }}</td>
                                        <td>{{ $item->stok }} {{ $item->satuan }}</td>
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
