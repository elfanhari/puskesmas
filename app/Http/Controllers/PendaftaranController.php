<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\RekamMedis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
  public function index(Request $request)
  {
    $pendaftaran = Pendaftaran::query();

    if ($request->dari_tanggal) {
      $pendaftaran->whereDate('tanggal', '>=', $request->dari_tanggal);
    }

    if ($request->sampai_tanggal) {
      $pendaftaran->whereDate('tanggal', '<=', $request->sampai_tanggal);
    }

    if ($request->petugas_id) {
      $pendaftaran->where('petugas_id', $request->petugas_id);
    }
    $pendaftarans = $pendaftaran->with(['pasien', 'petugas'])->orderBy('tanggal', 'desc')->get();
    $petugas = User::where('role', 'petugas')->get();
    return view('pages.pendaftaran.index', compact('pendaftarans', 'petugas'));
  }

  public function create()
  {
    $petugasId = auth()->user()->isDokter() ? auth()->user->dokter_id : Dokter::inRandomOrder()->first()->id;
    return view('pages.pendaftaran.create', [
      'pendaftaran' => new Pendaftaran([
        'petugas_id' => $petugasId,
        'tanggal' => date('Y-m-d'),
      ]),
      'pasiens' => Pasien::get(),
      'polis' => \App\Models\Poli::get(),
      'dokters' => \App\Models\Dokter::get(),
    ]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'pasien_id' => 'required|exists:pasiens,id',
      'petugas_id' => 'required|exists:users,id',
      'tanggal' => 'required|date',
      'poli_id' => 'required|exists:polis,id',
      'dokter_id' => 'required|exists:dokters,id',
    ]);

    DB::beginTransaction();

    try {
      $pendaftaran = Pendaftaran::create([
        'pasien_id' => $request->pasien_id,
        'petugas_id' => $request->petugas_id,
        'tanggal' => $request->tanggal,
        'keluhan' => $request->keluhan,
        'tekanan_darah' => $request->tekanan_darah,
        'suhu' => $request->suhu,
        'tinggi_badan' => $request->tinggi_badan,
        'berat_badan' => $request->berat_badan,
      ]);

      RekamMedis::create([
        'pendaftaran_id' => $pendaftaran->id,
        'dokter_id' => $request->dokter_id,
        'poli_id' => $request->poli_id,
        'status' => 'menunggu_diperiksa',
      ]);

      DB::commit();

      return redirect()->route('pendaftaran.index')->with('success', 'Data pendaftaran berhasil disimpan');
    } catch (\Throwable $e) {
      DB::rollBack();
      return back()->withError('Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
  }

  public function edit(Pendaftaran $pendaftaran, Request $request)
  {
    return view('pages.pendaftaran.edit', [
      'pendaftaran' => $pendaftaran,
      'pasiens' => Pasien::get(),
      'polis' => \App\Models\Poli::get(),
      'dokters' => \App\Models\Dokter::get(),
    ]);
  }

  public function update(Pendaftaran $pendaftaran, Request $request)
  {
    $request->validate([
      'pasien_id' => 'required|exists:pasiens,id',
      'petugas_id' => 'required|exists:users,id',
      'tanggal' => 'required|date',
      'poli_id' => 'required|exists:polis,id',
      'dokter_id' => 'required|exists:dokters,id',
    ]);

    DB::beginTransaction();

    try {
      $pendaftaran->update([
        'pasien_id' => $request->pasien_id,
        'petugas_id' => $request->petugas_id,
        'tanggal' => $request->tanggal,
        'keluhan' => $request->keluhan,
        'tekanan_darah' => $request->tekanan_darah,
        'suhu' => $request->suhu,
        'tinggi_badan' => $request->tinggi_badan,
        'berat_badan' => $request->berat_badan,
      ]);

      DB::commit();

      return redirect()->route('pendaftaran.index')->with('success', 'Data pendaftaran berhasil diperbarui');
    } catch (\Throwable $e) {
      DB::rollBack();
      return back()->withError('Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
  }

  public function destroy(Pendaftaran $pendaftaran)
  {
    DB::beginTransaction();
    try {
      $pendaftaran->delete();
      DB::commit();
      return back()->withSuccess("Pendaftaran pasien {$pendaftaran->pasien->name} berhasil dihapus!");
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }
}
