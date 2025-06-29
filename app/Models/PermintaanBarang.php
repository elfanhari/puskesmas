<?php

namespace App\Models;

use App\Helpers\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanBarang extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function guru()
  {
    return $this->belongsTo(User::class, 'guru_id', 'id');
  }

  public function itemPermintaanBarang()
  {
    return $this->hasMany(ItemPermintaanBarang::class);
  }

  public function logPermintaanBarang()
  {
    return $this->hasMany(LogPermintaanBarang::class);
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
