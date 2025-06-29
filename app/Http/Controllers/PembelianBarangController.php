<?php

namespace App\Http\Controllers;

use App\Helpers\Utilities;
use App\Models\Barang;
use App\Models\ItemPembelianBarang;
use App\Models\LogPembelianBarang;
use App\Models\PembelianBarang;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class PembelianBarangController extends Controller
{
  public function index(Request $request)
  {
    $pembelianBarang = PembelianBarang::query()
      ->when($request->bendahara_id, function ($query, $bendaharaId) {
        $query->where('bendahara_id', $bendaharaId);
      })
      ->when($request->status, function ($query, $status) {
        $query->where('status', $status);
      })
      ->when($request->dari_tanggal, function ($query, $from) {
        $query->whereDate('tanggal', '>=', $from);
      })
      ->when($request->sampai_tanggal, function ($query, $to) {
        $query->whereDate('tanggal', '<=', $to);
      });

    $statuses = [
      'menunggu_persetujuan'  => 'Menunggu Persetujuan',
      'disetujui'             => 'Disetujui',
      'selesai'              => 'Selesai',
      'ditolak'              => 'Ditolak',
    ];
    return view('pages.pembelian-barang.index', [
      'pembelianBarang' => $pembelianBarang
        ->with('bendahara')
        ->withCount('itemPembelianBarang')
        ->orderBy('tanggal', 'desc')
        ->get(),
      'statuses' => $statuses,
      'bendaharas' => User::where('role', 'bendahara')->get(),
    ]);
  }

  public function create()
  {
    $bendahara = User::where('role', 'bendahara');
    if (auth()->user()->isBendahara()) {
      $bendahara->where('id', auth()->user()->id);
    }

    return view('pages.pembelian-barang.create', [
      'bendaharas' => $bendahara->get(),
      'barangs' => Barang::orderBy('nama')->get(),
      'suppliers' => Supplier::orderBy('nama')->get(),
      'pembelian' => new PembelianBarang([
        'tanggal' => date('Y-m-d')
      ])
    ]);
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'bendahara_id' => 'required|exists:users,id',
      'tanggal' => 'required|date',
      'items' => 'required|array|min:1',
      'items.*.barang_id' => 'required|exists:barangs,id',
      'items.*.jumlah' => 'required|integer|min:1',
      'items.*.supplier_id' => 'required|exists:suppliers,id',
      'items.*.harga_satuan' => 'required|integer|min:1',
    ]);

    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->with('warning', 'Gagal diproses, periksa kembali form!')
        ->withInput();
    }

    $validated = $validator->validated();

    DB::beginTransaction();
    try {
      $pembelian = PembelianBarang::create([
        'bendahara_id' => $validated['bendahara_id'],
        'tanggal' => $validated['tanggal'],
        'status' => 'menunggu_persetujuan',
      ]);

      foreach ($validated['items'] as $item) {
        ItemPembelianBarang::create([
          'pembelian_barang_id' => $pembelian->id,
          'barang_id' => $item['barang_id'],
          'jumlah' => $item['jumlah'],
          'supplier_id' => $item['supplier_id'],
          'harga_satuan' => $item['harga_satuan'],
        ]);
      }

      LogPembelianBarang::create([
        'pembelian_barang_id' => $pembelian->id,
        'status' => 'menunggu_persetujuan',
      ]);
      DB::commit();
      return redirect(route('pembelian-barang.index'))->with('success', 'Pembelian barang berhasil diajukan!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }


  public function show(PembelianBarang $pembelian_barang)
  {
    return view('pages.pembelian-barang.show', [
      'pembelian' => $pembelian_barang->load('itemPembelianBarang', 'bendahara')
    ]);
  }
  public function edit(PembelianBarang $pembelian_barang)
  {
    $bendahara = User::where('role', 'bendahara');
    if (auth()->user()->isBendahara()) {
      $bendahara->where('id', auth()->user()->id);
    }
    return view('pages.pembelian-barang.edit', [
      'bendaharas' => $bendahara->get(),
      'barangs' => Barang::orderBy('nama')->get(),
      'pembelian' => $pembelian_barang,
      'suppliers' => Supplier::orderBy('nama')->get(),
    ]);
  }

  public function update(Request $request, PembelianBarang $pembelian_barang)
  {
    $pembelian = $pembelian_barang;
    $validator = Validator::make($request->all(), [
      'bendahara_id' => 'required|exists:users,id',
      'tanggal' => 'required|date',
      'items' => 'required|array|min:1',
      'items.*.barang_id' => 'required|exists:barangs,id',
      'items.*.jumlah' => 'required|integer|min:1',
      'items.*.supplier_id' => 'required|exists:suppliers,id',
      'items.*.harga_satuan' => 'required|integer|min:1',
    ]);

    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->with('warning', 'Gagal diproses, periksa kembali form!')
        ->withInput();
    }

    $validated = $validator->validated();

    DB::beginTransaction();
    try {
      // Update data pembelian
      $pembelian->update([
        'bendahara_id' => $validated['bendahara_id'],
        'tanggal' => $validated['tanggal'],
      ]);

      // Hapus item lama dan insert ulang
      $pembelian->itemPembelianBarang()->delete();

      foreach ($validated['items'] as $item) {
        ItemPembelianBarang::create([
          'pembelian_barang_id' => $pembelian->id,
          'barang_id' => $item['barang_id'],
          'supplier_id' => $item['supplier_id'],
          'jumlah' => $item['jumlah'],
          'harga_satuan' => $item['harga_satuan'],
        ]);
      }

      DB::commit();
      return redirect(route('pembelian-barang.index'))->with('success', 'Pembelian barang berhasil diperbarui!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function updateStatus(Request $request, $id)
  {
    $request->validate([
      'status' => 'required|in:menunggu_persetujuan,disetujui,selesai,ditolak'
    ]);

    $pembelian = PembelianBarang::with('itemPembelianBarang.barang')->findOrFail($id);

    DB::beginTransaction();
    try {
      $pembelian->update([
        'status' => $request->status,
      ]);

      LogPembelianBarang::create([
        'pembelian_barang_id' => $pembelian->id,
        'status' => $request->status,
      ]);

      if ($request->status === 'selesai') {
        foreach ($pembelian->itemPembelianBarang as $item) {
          $barang = $item->barang;
          $barang->increment('stok', $item->jumlah);
        }
      }

      DB::commit();
      return redirect()->back()->with('success', 'Status berhasil diperbarui menjadi ' . Utilities::getStatusLabel($request->status));
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function updateFeedback(Request $request, $id)
  {
    $request->validate([
      'feedback' => 'nullable|string|max:1000',
    ]);

    $pembelian = PembelianBarang::findOrFail($id);
    $pembelian->update([
      'feedback' => $request->feedback,
    ]);

    return back()->with('success', 'Feedback berhasil diperbarui!');
  }

  public function destroy(PembelianBarang $pembelian_barang)
  {
    DB::beginTransaction();
    try {
      $pembelian_barang->delete();
      DB::commit();
      return back()->withSuccess('Data berhasil dihapus!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }
}
