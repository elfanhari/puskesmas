<?php

namespace App\Http\Controllers;

use App\Helpers\Utilities;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $pasiens = Pasien::latest();
    $pasiens = $pasiens->get();
    return view('pages.pasien.index', compact('pasiens'));
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $pasien = new Pasien([
      'no_kartu' => Utilities::generateNoKartuPasien(),
    ]);
    return view('pages.pasien.create', compact('pasien'));
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'no_kartu'       => 'required|unique:pasiens,no_kartu',
      'name'           => 'required|string|max:255',
      'nik'            => 'required|unique:pasiens,nik',
      'tanggal_lahir'  => 'required|date',
      'jenis_kelamin'  => 'required|in:L,P',
      'alamat'         => 'required|string',
      'telepon'        => 'required|string|max:15',
    ]);

    DB::beginTransaction();
    try {
      Pasien::create($request->all());
      DB::commit();
      return redirect()->route('pasien.index')->withSuccess('Data berhasil ditambahkan!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Pasien  $pasien
   * @return \Illuminate\Http\Response
   */
  public function show(Pasien $pasien)
  {
    return view('pages.pasien.show', [
      'pasien' => $pasien,
      'riwayat' => $pasien->pendaftaran()->latest()->get(),
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Pasien  $pasien
   * @return \Illuminate\Http\Response
   */
  public function edit(Pasien $pasien)
  {
    return view('pages.pasien.edit', compact('pasien'));
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Pasien  $pasien
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Pasien $pasien)
  {
    $request->validate([
      'no_kartu'       => 'required|unique:pasiens,no_kartu,' . $pasien->id,
      'name'           => 'required|string|max:255',
      'nik'            => 'required|unique:pasiens,nik,' . $pasien->id,
      'tanggal_lahir'  => 'required|date',
      'jenis_kelamin'  => 'required|in:L,P',
      'alamat'         => 'required|string',
      'telepon'        => 'required|string|max:15',
    ]);

    DB::beginTransaction();
    try {
      $pasien->update($request->all());
      DB::commit();
      return redirect()->route('pasien.index')->withSuccess('Data berhasil diperbarui!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Pasien  $pasien
   * @return \Illuminate\Http\Response
   */
  public function destroy(Pasien $pasien)
  {
    DB::beginTransaction();
    try {
      $pasien->delete();
      DB::commit();
      return back()->withSuccess("{$pasien->name} berhasil dihapus!");
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function kartuBerobat(Pasien $pasien)
  {
    return view('pages.pasien.kartu-berobat', [
      'pasien' => $pasien,
    ]);
  }
}
