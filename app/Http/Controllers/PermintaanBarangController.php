<?php

namespace App\Http\Controllers;

use App\Helpers\Utilities;
use App\Models\Barang;
use App\Models\ItemPermintaanBarang;
use App\Models\LogPermintaanBarang;
use App\Models\PermintaanBarang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class PermintaanBarangController extends Controller
{
  public function index(Request $request)
  {
    $permintaanBarang = PermintaanBarang::query();

    if (auth()->user()->isGuru()) {
      $permintaanBarang->where('guru_id', auth()->user()->id);
    }

    $permintaanBarang->when($request->guru_id, function ($query, $guruId) {
      $query->where('guru_id', $guruId);
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
      'diajukan'              => 'Diajukan',
      'menunggu_persetujuan'  => 'Menunggu Persetujuan',
      'disetujui'             => 'Disetujui',
      'selesai'              => 'Selesai',
      'ditolak'              => 'Ditolak',
    ];
    return view('pages.permintaan-barang.index', [
      'permintaanBarang' => $permintaanBarang
        ->with('guru')
        ->withCount('itemPermintaanBarang')
        ->orderBy('tanggal', 'desc')
        ->get(),
      'statuses' => $statuses,
      'gurus' => User::where('role', 'guru')->get(),
    ]);
  }

  public function create()
  {

    $guru = User::where('role', 'guru');
    if (auth()->user()->isGuru()) {
      $guru->where('id', auth()->user()->id);
    }

    return view('pages.permintaan-barang.create', [
      'gurus' => $guru->get(),
      'barangs' => Barang::orderBy('nama')->get(),
      'permintaan' => new PermintaanBarang([
        'tanggal' => date('Y-m-d')
      ])
    ]);
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'guru_id' => 'required|exists:users,id',
      'alasan' => 'required|string',
      'tanggal' => 'required|date',
      'items' => 'required|array|min:1',
      'items.*.barang_id' => 'required|exists:barangs,id',
      'items.*.jumlah' => 'required|integer|min:1',
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
      $permintaan = PermintaanBarang::create([
        'guru_id' => $validated['guru_id'],
        'alasan' => $validated['alasan'],
        'tanggal' => $validated['tanggal'],
        'status' => 'diajukan',
      ]);

      foreach ($validated['items'] as $item) {
        ItemPermintaanBarang::create([
          'permintaan_barang_id' => $permintaan->id,
          'barang_id' => $item['barang_id'],
          'jumlah' => $item['jumlah'],
        ]);
      }

      LogPermintaanBarang::create([
        'permintaan_barang_id' => $permintaan->id,
        'status' => 'diajukan',
      ]);
      DB::commit();
      return redirect(route('permintaan-barang.index'))->with('success', 'Permintaan barang berhasil diajukan!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }


  public function show(PermintaanBarang $permintaan_barang)
  {
    return view('pages.permintaan-barang.show', [
      'permintaan' => $permintaan_barang->load('itemPermintaanBarang', 'guru')
    ]);
  }
  public function edit(PermintaanBarang $permintaan_barang)
  {
    $guru = User::where('role', 'guru');
    if (auth()->user()->isGuru()) {
      $guru->where('id', auth()->user()->id);
    }
    return view('pages.permintaan-barang.edit', [
      'gurus' => $guru->get(),
      'barangs' => Barang::orderBy('nama')->get(),
      'permintaan' => $permintaan_barang
    ]);
  }

  public function update(Request $request, PermintaanBarang $permintaan_barang)
  {
    $permintaan = $permintaan_barang;
    $validator = Validator::make($request->all(), [
      'guru_id' => 'required|exists:users,id',
      'alasan' => 'required|string',
      'tanggal' => 'required|date',
      'items' => 'required|array|min:1',
      'items.*.barang_id' => 'required|exists:barangs,id',
      'items.*.jumlah' => 'required|integer|min:1',
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
      // Update data permintaan
      $permintaan->update([
        'guru_id' => $validated['guru_id'],
        'alasan' => $validated['alasan'],
        'tanggal' => $validated['tanggal'],
      ]);

      // Hapus item lama dan insert ulang
      $permintaan->itemPermintaanBarang()->delete();

      foreach ($validated['items'] as $item) {
        ItemPermintaanBarang::create([
          'permintaan_barang_id' => $permintaan->id,
          'barang_id' => $item['barang_id'],
          'jumlah' => $item['jumlah'],
        ]);
      }

      DB::commit();
      return redirect(route('permintaan-barang.index'))->with('success', 'Permintaan barang berhasil diperbarui!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function updateStatus(Request $request, $id)
  {
    $request->validate([
      'status' => 'required|in:diajukan,menunggu_persetujuan,disetujui,selesai,ditolak'
    ]);

    $permintaan = PermintaanBarang::with('itemPermintaanBarang.barang')->findOrFail($id);

    DB::beginTransaction();
    try {
      $permintaan->update([
        'status' => $request->status,
      ]);

      LogPermintaanBarang::create([
        'permintaan_barang_id' => $permintaan->id,
        'status' => $request->status,
      ]);

      if ($request->status === 'selesai') {
        foreach ($permintaan->itemPermintaanBarang as $item) {
          $barang = $item->barang;
          if ($barang->stok < $item->jumlah) {
            throw new \Exception("Stok barang {$barang->nama} tidak mencukupi.");
          }

          $barang->decrement('stok', $item->jumlah);
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

    $permintaan = PermintaanBarang::findOrFail($id);
    $permintaan->update([
      'feedback' => $request->feedback,
    ]);

    return back()->with('success', 'Feedback berhasil diperbarui!');
  }

  public function destroy(PermintaanBarang $permintaan_barang)
  {
    DB::beginTransaction();
    try {
      $permintaan_barang->delete();
      DB::commit();
      return back()->withSuccess('Data berhasil dihapus!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }
}
