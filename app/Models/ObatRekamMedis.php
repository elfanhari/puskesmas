<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatRekamMedis extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function rekamMedis()
  {
    return $this->belongsTo(RekamMedis::class);
  }

  public function obat()
  {
    return $this->belongsTo(Obat::class);
  }
}
