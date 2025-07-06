<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\DokterPoli;
use Illuminate\Http\Request;

class DokterController extends Controller
{
  public function getDokterByPoli($poli_id)
  {
    $dokterIds = DokterPoli::where('poli_id', $poli_id)->pluck('dokter_id');
    $dokters = Dokter::whereIn('id', $dokterIds)->get(['id', 'name']);
    return response()->json($dokters);
  }
}
