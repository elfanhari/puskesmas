<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $barangs = Barang::query();
    if ($request->kategori_barang_id) $barangs->where('kategori_barang_id', $request->kategori_barang_id);
    return view('pages.barang.index', [
      'barang' => $barangs->with('kategoriBarang')->get(),
      'kategoriBarangs' => KategoriBarang::get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.barang.create', [
      'barang' => new Barang([
        'kode' => strtoupper(fake()->bothify('BRG-###??'))
      ]),
      'kategoriBarangs' => KategoriBarang::get(),
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
      'kategori_barang_id' => 'required|exists:kategori_barangs,id',
      'nama'               => 'required|string|max:255',
      'kode'               => 'required|string|max:100|unique:barangs,kode',
      'stok'               => 'required|integer|min:0',
      'satuan'             => 'required|string|max:50',
      'keterangan'         => 'nullable|string',
    ]);


    DB::beginTransaction();
    try {
      Barang::create($request->all());
      DB::commit();
      return redirect(route('barang.index'))->withSuccess('Data berhasil diperbarui');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Barang  $barang
   * @return \Illuminate\Http\Response
   */
  public function show(Barang $barang)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Barang  $barang
   * @return \Illuminate\Http\Response
   */
  public function edit(Barang $barang)
  {
    return view('pages.barang.edit', [
      'barang' => $barang,
      'kategoriBarangs' => KategoriBarang::get(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Barang  $barang
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Barang $barang)
  {
    $request->validate([
      'kategori_barang_id' => 'required|exists:kategori_barangs,id',
      'nama'               => 'required|string|max:255',
      'kode'               => 'required|string|max:100|unique:barangs,kode,' . $barang->id,
      'stok'               => 'required|integer|min:0',
      'satuan'             => 'required|string|max:50',
      'keterangan'         => 'nullable|string',
    ]);

    DB::beginTransaction();
    try {
      $barang->update($request->all());
      DB::commit();
      return redirect(route('barang.index'))->withSuccess('Data berhasil diperbarui!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Barang  $barang
   * @return \Illuminate\Http\Response
   */
  public function destroy(Barang $barang)
  {
    DB::beginTransaction();
    try {
      $barang->delete();
      DB::commit();
      return redirect(route('barang.index'))->withSuccess('Data berhasil dihapus!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }
}
