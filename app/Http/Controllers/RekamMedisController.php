<?php

namespace App\Http\Controllers;

use App\Models\ObatRekamMedis;
use App\Models\Pendaftaran;
use App\Models\RekamMedis;
use App\Models\Rujukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RekamMedisController extends Controller
{
  public function index(Request $request)
  {
    $rekamMedis = RekamMedis::query();

    if (auth()->user()->isDokter()) {
      $rekamMedis->where('dokter_id', auth()->user()->dokter_id);
    }

    if ($request->dari_tanggal) {
      $rekamMedis->whereHas('pendaftaran', function ($query) use ($request) {
        $query->whereDate('tanggal', '>=', $request->dari_tanggal);
      });
    }

    if ($request->sampai_tanggal) {
      $rekamMedis->whereHas('pendaftaran', function ($query) use ($request) {
        $query->whereDate('tanggal', '<=', $request->sampai_tanggal);
      });
    }

    foreach (['poli_id', 'dokter_id', 'status'] as $i => $req) {
      if ($request->$req) {
        $rekamMedis->where($req, $request->$req);
      }
    }

    $rekamMedis = $rekamMedis->with(['pendaftaran'])->get()
      ->sortByDesc(fn($item) => $item->pendaftaran->tanggal ?? now());;

    $polis = \App\Models\Poli::get();
    $dokters = \App\Models\Dokter::get();
    $statuses = [
      'menunggu_diperiksa' => 'Menunggu Diperiksa',
      'sedang_diperiksa'   => 'Sedang Diperiksa',
      'selesai_diperiksa'  => 'Selesai Diperiksa',
      'menunggu_obat'      => 'Menunggu Obat',
      'selesai'            => 'Selesai',
    ];

    return view('pages.rekam-medis.index', compact('rekamMedis', 'polis', 'dokters', 'statuses'));
  }

  public function show(RekamMedis $rekam_medis)
  {
    $pendaftaran = Pendaftaran::find($rekam_medis->pendaftaran_id);
    $rekamMedis = $rekam_medis;
    $rujukan = Rujukan::where('rekam_medis_id', $rekam_medis->id)->first() ?? [];
    $obatRekamMedis = ObatRekamMedis::where('rekam_medis_id', $rekam_medis->id)->get();
    $pengambilanObat = $rekamMedis->pengambilanObat()->first() ?? [];

    return view('pages.rekam-medis.show', [
      'pendaftaran' => $pendaftaran,
      'rekamMedis' => $rekamMedis,
      'rujukan' => $rujukan,
      'obatRekamMedis' => $obatRekamMedis,
      'pengambilanObat' => $pengambilanObat,
    ]);
  }

  public function edit(Request $request, RekamMedis $rekam_medis)
  {
    if ($request->is_diperiksa && $rekam_medis->status === 'menunggu_diperiksa') {
      $rekam_medis->update(['status' => 'sedang_diperiksa']);
    }

    $pendaftaran = Pendaftaran::find($rekam_medis->pendaftaran_id);
    $rekamMedis = $rekam_medis;
    $rujukan = Rujukan::where('rekam_medis_id', $rekam_medis->id)->first() ?? [];
    $obatRekamMedis = ObatRekamMedis::where('rekam_medis_id', $rekam_medis->id)->get();
    $pengambilanObat = $rekamMedis->pengambilanObat()->first() ?? [];

    $pasiens = \App\Models\Pasien::get();
    $polis = \App\Models\Poli::get();
    $dokters = \App\Models\Dokter::get();
    $obats = \App\Models\Obat::get();
    return view('pages.rekam-medis.edit', [
      'pendaftaran' => $pendaftaran,
      'rekamMedis' => $rekamMedis,
      'rujukan' => $rujukan,
      'obatRekamMedis' => $obatRekamMedis,
      'pengambilanObat' => $pengambilanObat,
      'pasiens' => $pasiens,
      'polis' => $polis,
      'dokters' => $dokters,
      'obats' => $obats,
    ]);
  }

  public function update(Request $request, RekamMedis $rekam_medis)
  {
    $validated = Validator::make($request->all(), [
      // 'petugas_id' => 'required|exists:users,id',
      // 'pasien_id' => 'required|exists:pasiens,id',
      'tanggal' => 'required|date',
      'keluhan' => 'nullable|string',
      'tekanan_darah' => 'nullable|string',
      'suhu' => 'nullable|numeric',
      'tinggi_badan' => 'nullable|numeric',
      'berat_badan' => 'nullable|numeric',
      // 'poli_id' => 'required|exists:polis,id',
      // 'dokter_id' => 'required|exists:dokters,id',
      'diagnosa' => 'nullable|string',
      'tindakan' => 'nullable|string',
      'catatan' => 'nullable|string',
      'keputusan' => 'nullable|in:diberi_obat,dirujuk',
      // 'obat_id' => 'array|nullable',
      // 'obat_id.*' => 'exists:obats,id',
      // 'jumlah' => 'array|nullable',
      // 'jumlah.*' => 'nullable',
      'waktu_pengambilan' => 'nullable|date',
      'catatan_pengambilan_obat' => 'nullable|string',
      'rumah_sakit_tujuan' => 'nullable|string',
      'alasan' => 'nullable|string',
    ]);

    if ($validated->fails()) {
      return back()->withError('Gagal! lengkapi form dengan benar!')->withInput();
    }

    DB::beginTransaction();
    try {
      // Update pendaftaran
      $rekam_medis->pendaftaran->update([
        // 'petugas_id' => $request->petugas_id,
        // 'pasien_id' => $request->pasien_id,
        'tanggal' => $request->tanggal,
        'keluhan' => $request->keluhan,
        'tekanan_darah' => $request->tekanan_darah,
        'suhu' => $request->suhu,
        'tinggi_badan' => $request->tinggi_badan,
        'berat_badan' => $request->berat_badan,
      ]);

      // Update rekam medis
      $rekam_medis->update([
        // 'poli_id' => $request->poli_id,
        // 'dokter_id' => $request->dokter_id,
        'diagnosa' => $request->diagnosa,
        'tindakan' => $request->tindakan,
        'catatan' => $request->catatan,
      ]);

      // Handle status update berdasarkan keputusan
      $keputusan = $request->keputusan;
      $statusLama = $rekam_medis->status;
      $statusBaru = $statusLama; // default tetap

      // if (in_array($statusLama, ['menunggu_diperiksa', 'sedang_diperiksa', 'selesai_diperiksa'])) {
      //   if ($keputusan === 'diberi_obat') {
      //     $statusBaru = 'menunggu_obat';
      //   } elseif ($keputusan === 'dirujuk') {
      //     $statusBaru = 'selesai';
      //   }
      // }

      if ($statusLama !== 'selesai') {
        if ($keputusan === 'diberi_obat') {
          if ($rekam_medis->poli_id == 1) { // Poli TBC
            $statusBaru = 'menunggu_obat';
          } else {
            $statusBaru = 'selesai';
          }
        } elseif ($keputusan === 'dirujuk') {
          $statusBaru = 'selesai';
        }
      }

      $rekam_medis->update([
        'status' => $statusBaru,
        'is_rujukan' => $keputusan === 'dirujuk',
      ]);

      // Jika diberi obat
      if ($keputusan === 'diberi_obat') {
        $rekam_medis->rujukan()->delete(); // Hapus rujukan jika ada

        // Hapus obat lama (biar update clean)
        $rekam_medis->obatRekamMedis()->delete();

        // Insert obat baru
        foreach ($request->obat_id as $index => $obat_id) {
          $rekam_medis->obatRekamMedis()->create([
            'obat_id' => $obat_id,
            'jumlah' => $request->jumlah[$index] ?? 0,
          ]);
        }

        // Create atau update pengambilan obat
        if ($rekam_medis->poli_id == 1) { // Poli TBC
          $rekam_medis->pengambilanObat()->updateOrCreate(
            ['rekam_medis_id' => $rekam_medis->id],
            [
              'waktu_pengambilan' => $request->waktu_pengambilan,
              'catatan' => $request->catatan_pengambilan_obat,
            ]
          );
        }
      }

      // Jika perlu dirujuk
      if ($keputusan === 'dirujuk') {

        $rekam_medis->obatRekamMedis()->delete();
        $rekam_medis->pengambilanObat()->delete();

        $rekam_medis->rujukan()->updateOrCreate(
          ['rekam_medis_id' => $rekam_medis->id],
          [
            'rumah_sakit_tujuan' => $request->rumah_sakit_tujuan,
            'alasan' => $request->alasan,
          ]
        );
      }

      DB::commit();

      return redirect()->route('rekam-medis.index')->with('success', 'Rekam medis berhasil diperbarui.');
    } catch (\Throwable $th) {
      DB::rollBack();
      report($th);
      return back()->withInput()->withError('Terjadi kesalahan! ' . $th->getMessage());
    }
  }

  public function print(RekamMedis $rekam_medis)
  {
    $pendaftaran = Pendaftaran::find($rekam_medis->pendaftaran_id);
    $rekamMedis = $rekam_medis;
    $rujukan = Rujukan::where('rekam_medis_id', $rekam_medis->id)->first() ?? [];
    $obatRekamMedis = ObatRekamMedis::where('rekam_medis_id', $rekam_medis->id)->get();
    $pengambilanObat = $rekamMedis->pengambilanObat()->first() ?? [];

    return view('pages.rekam-medis.print', [
      'pendaftaran' => $pendaftaran,
      'rekamMedis' => $rekamMedis,
      'rujukan' => $rujukan,
      'obatRekamMedis' => $obatRekamMedis,
      'pengambilanObat' => $pengambilanObat,
    ]);
  }
}
