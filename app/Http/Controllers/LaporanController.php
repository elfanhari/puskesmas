<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Dokter;
use App\Models\ItemPembelianBarang;
use App\Models\ItemPermintaanBarang;
use App\Models\KategoriBarang;
use App\Models\Pasien;
use App\Models\PembelianBarang;
use App\Models\PermintaanBarang;
use App\Models\Poli;
use App\Models\RekamMedis;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
  public function laporanPasien(Request $request)
  {
    if ($request->print == 'true') {
      $pasiens = Pasien::query();
      if ($request->jenis_kelamin != '') {
        $pasiens->where('jenis_kelamin', $request->jenis_kelamin);
        $labelJenisKelamin = $request->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
      } else {
        $labelJenisKelamin = 'Semua Jenis Kelamin';
      }
      return view('pages.laporan.pasien.print', [
        'pasiens' => $pasiens->orderBy('name')->get(),
        'namaJk' => $labelJenisKelamin
      ]);
    } else {
      return view('pages.laporan.pasien.index', [
        'pasien' => [],
      ]);
    }
  }

  public function laporanRekamMedis(Request $request)
  {
    if ($request->print == 'true') {
      $rekamMedis = RekamMedis::with(['pendaftaran.pasien', 'poli', 'dokter'])
        ->when($request->dari_tanggal, fn($q) => $q->whereHas('pendaftaran', fn($q) => $q->whereDate('tanggal', '>=', $request->dari_tanggal)))
        ->when($request->sampai_tanggal, fn($q) => $q->whereHas('pendaftaran', fn($q) => $q->whereDate('tanggal', '<=', $request->sampai_tanggal)))
        ->when($request->poli_id, fn($q) => $q->where('poli_id', $request->poli_id))
        ->when($request->dokter_id, fn($q) => $q->where('dokter_id', $request->dokter_id))
        ->when($request->status, fn($q) => $q->where('status', $request->status))
        ->get()
        ->sortByDesc(fn($item) => $item->pendaftaran->tanggal ?? now());

      return view('pages.laporan.rekam-medis.print', [
        'rekamMedis' => $rekamMedis,
        'request' => $request,
      ]);
    }

    return view('pages.laporan.rekam-medis.index', [
      'rekamMedis' => [],
      'dokters' => Dokter::orderBy('name')->get(),
      'polis' => Poli::orderBy('name')->get(),
      'statuses' =>  [
        'menunggu_diperiksa' => 'Menunggu Diperiksa',
        'sedang_diperiksa'   => 'Sedang Diperiksa',
        'selesai_diperiksa'  => 'Selesai Diperiksa',
        'menunggu_obat'      => 'Menunggu Obat',
        'selesai'            => 'Selesai',
      ]
    ]);
  }
}
