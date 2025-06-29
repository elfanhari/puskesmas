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
  public function laporanBarang(Request $request)
  {
    if ($request->print == 'true') {
      $barangs = Barang::query();
      if ($request->kategori_barang_id != '') {
        $kategori = KategoriBarang::findOrFail($request->kategori_barang_id);
        $barangs->where('kategori_barang_id', $request->kategori_barang_id);
        $namaKategori = $kategori->nama;
      } else {
        $namaKategori = 'Semua Kategori';
      }
      return view('pages.laporan.barang.print', [
        'barangs' => $barangs->with('kategoriBarang')->get(),
        'namaKategori' => $namaKategori
      ]);
    } else {
      return view('pages.laporan.barang.index', [
        'kategoriBarangs' => KategoriBarang::get(),
      ]);
    }
  }

  public function laporanPermintaanPembelian(Request $request)
  {
    if ($request->print == 'true') {
      $jenis = $request->jenis;
      $status = $request->status;
      $dari = $request->dari;
      $sampai = $request->sampai;
      $pengajuId = $request->pengaju_id;

      if ($jenis === 'permintaan') {
        $data = PermintaanBarang::with(['guru', 'itemPermintaanBarang.barang'])
          ->when($status, fn($q) => $q->where('status', $status))
          ->when($pengajuId, fn($q) => $q->where('guru_id', $pengajuId))
          ->when($dari, fn($q) => $q->whereDate('tanggal', '>=', $dari))
          ->when($sampai, fn($q) => $q->whereDate('tanggal', '<=', $sampai))
          ->orderBy('tanggal', 'desc')
          ->get();
      } else {
        $data = PembelianBarang::with(['bendahara', 'itemPembelianBarang.barang'])
          ->when($status, fn($q) => $q->where('status', $status))
          ->when($pengajuId, fn($q) => $q->where('bendahara_id', $pengajuId))
          ->when($dari, fn($q) => $q->whereDate('tanggal', '>=', $dari))
          ->when($sampai, fn($q) => $q->whereDate('tanggal', '<=', $sampai))
          ->orderBy('tanggal', 'desc')
          ->get();
      }

      return view('pages.laporan.permintaan-pembelian.print', [
        'jenis' => $jenis,
        'data' => $data,
        'status' => $status ?? 'Semua',
        'dari' => $dari,
        'sampai' => $sampai,
        'pengaju' => $jenis === 'permintaan'
          ? User::find($pengajuId)?->name
          : User::find($pengajuId)?->name,
      ]);
    }

    return view('pages.laporan.permintaan-pembelian.index', [
      'gurus' => User::where('role', 'guru')->get(),
      'bendaharas' => User::where('role', 'bendahara')->get(),
    ]);
  }

  public function laporanBarangKeluarMasuk(Request $request)
  {
    if ($request->print == 'true') {
      $jenis = $request->jenis;
      $tanggalAwal = $request->tanggal_awal;
      $tanggalAkhir = $request->tanggal_akhir;

      if ($jenis == 'permintaan') {
        $query = ItemPermintaanBarang::with(['barang', 'permintaanBarang.guru'])
          ->whereHas(
            'permintaanBarang',
            fn($q) =>
            $q->where('status', 'selesai')
              ->when($tanggalAwal, fn($q) => $q->whereDate('tanggal', '>=', $tanggalAwal))
              ->when($tanggalAkhir, fn($q) => $q->whereDate('tanggal', '<=', $tanggalAkhir))
          )
          ->orderByDesc(
            PermintaanBarang::select('tanggal')
              ->whereColumn('id', 'item_permintaan_barangs.permintaan_barang_id')
              ->limit(1)
          );
      } else {
        $query = ItemPembelianBarang::with(['barang', 'supplier', 'pembelianBarang.bendahara'])
          ->whereHas(
            'pembelianBarang',
            fn($q) =>
            $q->where('status', 'selesai')
              ->when($tanggalAwal, fn($q) => $q->whereDate('tanggal', '>=', $tanggalAwal))
              ->when($tanggalAkhir, fn($q) => $q->whereDate('tanggal', '<=', $tanggalAkhir))
          )
          ->orderByDesc(
            PembelianBarang::select('tanggal')
              ->whereColumn('id', 'item_pembelian_barangs.pembelian_barang_id')
              ->limit(1)
          );
      }

      return view('pages.laporan.barang-masuk-keluar.print', [
        'items' => $query->get(),
        'jenis' => $jenis,
        'namaJenis' => $jenis == 'permintaan' ? 'Barang Keluar (Permintaan)' : 'Barang Masuk (Pembelian)',
        'tanggalAwal' => $tanggalAwal != null ? \Carbon\Carbon::parse($tanggalAwal)->format('d-m-Y') : '-',
        'tanggalAkhir' => $tanggalAkhir != null ? \Carbon\Carbon::parse($tanggalAkhir)->format('d-m-Y') : '-',
      ]);
    }

    return view('pages.laporan.barang-masuk-keluar.index');
  }


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
