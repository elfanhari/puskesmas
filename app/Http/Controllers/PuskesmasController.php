<?php

namespace App\Http\Controllers;

use App\Models\Puskesmas;
use Illuminate\Http\Request;

class PuskesmasController extends Controller
{
  public function index()
  {
    $puskesmas = Puskesmas::first();
    return  view('pages.puskesmas.index', compact('puskesmas'));
  }

  public function update(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'alamat' => 'nullable|string',
      'telepon' => 'nullable|string|max:20',
      'email' => 'nullable|email',
      'website' => 'nullable|string|max:255',
      'logo' => 'nullable|mimes:png,jpg,jpeg|max:2048',
    ]);

    $puskesmas = Puskesmas::first();

    if (!$puskesmas) {
      return back()->with('error', 'Data puskesmas tidak ditemukan!');
    }

    $puskesmas->fill($request->only(['name', 'alamat', 'telepon', 'email', 'website']));

    if ($request->hasFile('logo')) {
      $logo = $request->file('logo');
      $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
      $logo->move(public_path('img/logo'), $logoName);

      if ($puskesmas->logo !== 'logo.png') {
        @unlink(public_path('img/logo/' . $puskesmas->logo));
      }

      $puskesmas->logo = $logoName;
    }

    $puskesmas->save();

    return back()->with('success', 'Data puskesmas berhasil diperbarui!');
  }
}
