<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriBarangController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('pages.kategori-barang.index', [
      'kategoriBarang' => KategoriBarang::withCount('barang')->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.kategori-barang.create', [
      'kategoriBarang' => new KategoriBarang()
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
      'nama' => 'required',
      'telepon' => 'nullable',
      'alamat' => 'nullable',
    ]);

    DB::beginTransaction();
    try {
      KategoriBarang::create($request->all());
      DB::commit();
      return redirect(route('kategori-barang.index'))->withSuccess('Data berhasil diperbarui');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\KategoriBarang  $kategori_barang
   * @return \Illuminate\Http\Response
   */
  public function show(KategoriBarang $kategori_barang)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\KategoriBarang  $kategori_barang
   * @return \Illuminate\Http\Response
   */
  public function edit(KategoriBarang $kategori_barang)
  {
    return view('pages.kategori-barang.edit', [
      'kategoriBarang' => $kategori_barang,
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\KategoriBarang  $kategori_barang
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, KategoriBarang $kategori_barang)
  {
    $request->validate([
      'nama' => 'required',
      'telepon' => 'nullable',
      'alamat' => 'nullable',
    ]);

    DB::beginTransaction();
    try {
      $kategori_barang->update($request->all());
      DB::commit();
      return redirect(route('kategori-barang.index'))->withSuccess('Data berhasil diperbarui!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\KategoriBarang  $kategori_barang
   * @return \Illuminate\Http\Response
   */
  public function destroy(KategoriBarang $kategori_barang)
  {
    DB::beginTransaction();
    try {
      $kategori_barang->delete();
      DB::commit();
      return redirect(route('kategori-barang.index'))->withSuccess('Data berhasil dihapus!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }
}
