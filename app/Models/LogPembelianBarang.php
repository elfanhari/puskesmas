<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPembelianBarang extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function pembelianBarang()
  {
    return $this->belongsTo(PembelianBarang::class);
  }
}
