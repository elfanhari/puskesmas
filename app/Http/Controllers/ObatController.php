<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('pages.obat.index', [
      'obat' => Obat::orderBy('name', 'asc')->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.obat.create', [
      'obat' => new Obat()
    ]);
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
      'name' => 'required',
      'satuan' => 'required',
      'stok' => 'required|numeric',
    ]);

    DB::beginTransaction();
    try {
      Obat::create($request->all());
      DB::commit();
      return redirect(route('obat.index'))->withSuccess('Data berhasil diperbarui');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Obat  $obat
   * @return \Illuminate\Http\Response
   */
  public function show(Obat $obat)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Obat  $obat
   * @return \Illuminate\Http\Response
   */
  public function edit(Obat $obat)
  {
    return view('pages.obat.edit', [
      'obat' => $obat,
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Obat  $obat
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Obat $obat)
  {
    $request->validate([
      'name' => 'required',
      'satuan' => 'required',
      'stok' => 'required|numeric',
    ]);

    DB::beginTransaction();
    try {
      $obat->update($request->all());
      DB::commit();
      return redirect(route('obat.index'))->withSuccess('Data berhasil diperbarui!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Obat  $obat
   * @return \Illuminate\Http\Response
   */
  public function destroy(Obat $obat)
  {
    DB::beginTransaction();
    try {
      $obat->delete();
      DB::commit();
      return redirect(route('obat.index'))->withSuccess('Data berhasil dihapus!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }
}
