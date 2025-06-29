<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengambilanObat extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function rekamMedis()
  {
    return $this->belongsTo(RekamMedis::class);
  }

  public function getWaktuPengambilanFormattedAttribute()
  {
    return \Carbon\Carbon::parse($this->waktu_pengambilan ?? null)->translatedFormat('d/m/Y H:i') ?? '-';
  }
}
