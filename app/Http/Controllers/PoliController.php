<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PoliController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('pages.poli.index', [
      'poli' => Poli::get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.poli.create', [
      'poli' => new Poli()
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
    ]);

    DB::beginTransaction();
    try {
      Poli::create($request->all());
      DB::commit();
      return redirect(route('poli.index'))->withSuccess('Data berhasil diperbarui');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Poli  $poli
   * @return \Illuminate\Http\Response
   */
  public function show(Poli $poli)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Poli  $poli
   * @return \Illuminate\Http\Response
   */
  public function edit(Poli $poli)
  {
    return view('pages.poli.edit', [
      'poli' => $poli,
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Poli  $poli
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Poli $poli)
  {
    $request->validate([
      'name' => 'required',
    ]);

    DB::beginTransaction();
    try {
      $poli->update($request->all());
      DB::commit();
      return redirect(route('poli.index'))->withSuccess('Data berhasil diperbarui!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Poli  $poli
   * @return \Illuminate\Http\Response
   */
  public function destroy(Poli $poli)
  {
    DB::beginTransaction();
    try {
      $poli->delete();
      DB::commit();
      return redirect(route('poli.index'))->withSuccess('Data berhasil dihapus!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }
}
