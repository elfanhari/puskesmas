<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function kategoriBarang()
  {
    return $this->belongsTo(KategoriBarang::class);
  }

  public function itemPermintaanBarang()
  {
    return $this->hasMany(ItemPermintaanBarang::class);
  }

  public function itemPembelianBarang()
  {
    return $this->hasMany(ItemPembelianBarang::class);
  }
}
