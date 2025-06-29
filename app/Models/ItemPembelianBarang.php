<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPembelianBarang extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function pembelianBarang()
  {
    return $this->belongsTo(PembelianBarang::class);
  }

  public function barang()
  {
    return $this->belongsTo(Barang::class);
  }

  public function supplier()
  {
    return $this->belongsTo(Supplier::class);
  }

  public function getHargaSatuanFormattedAttribute()
  {
    return number_format($this->harga_satuan, 0, ',', '.');
  }
}
