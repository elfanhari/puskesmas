<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokterPoli extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function dokter()
  {
    return $this->belongsTo(Dokter::class, 'dokter_id');
  }

  public function poli()
  {
    return $this->belongsTo(Poli::class, 'poli_id');
  }
}
