<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('pages.supplier.index', [
      'supplier' => Supplier::withCount('itemPembelianBarang')->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.supplier.create', [
      'supplier' => new Supplier()
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
      Supplier::create($request->all());
      DB::commit();
      return redirect(route('supplier.index'))->withSuccess('Data berhasil diperbarui');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Supplier  $supplier
   * @return \Illuminate\Http\Response
   */
  public function show(Supplier $supplier)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Supplier  $supplier
   * @return \Illuminate\Http\Response
   */
  public function edit(Supplier $supplier)
  {
    return view('pages.supplier.edit', [
      'supplier' => $supplier,
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Supplier  $supplier
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Supplier $supplier)
  {
    $request->validate([
      'nama' => 'required',
      'telepon' => 'nullable',
      'alamat' => 'nullable',
    ]);

    DB::beginTransaction();
    try {
      $supplier->update($request->all());
      DB::commit();
      return redirect(route('supplier.index'))->withSuccess('Data berhasil diperbarui!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Supplier  $supplier
   * @return \Illuminate\Http\Response
   */
  public function destroy(Supplier $supplier)
  {
    DB::beginTransaction();
    try {
      $supplier->delete();
      DB::commit();
      return redirect(route('supplier.index'))->withSuccess('Data berhasil dihapus!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }
}
