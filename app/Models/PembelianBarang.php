<?php

namespace App\Models;

use App\Helpers\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBarang extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function bendahara()
  {
    return $this->belongsTo(User::class, 'bendahara_id');
  }

  public function itemPembelianBarang()
  {
    return $this->hasMany(ItemPembelianBarang::class);
  }

  public function logPembelianBarang()
  {
    return $this->hasMany(LogPembelianBarang::class);
  }

  public function getStatusLabelAttribute()
  {
    return Utilities::getStatusLabel($this->status);
  }

  public function getStatusColorAttribute()
  {
    return Utilities::getStatusColor($this->status);
  }

  public function getStatusIconAttribute()
  {
    return Utilities::getStatusIcon($this->status);
  }
}
