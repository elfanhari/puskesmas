<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function rekamMedis()
  {
    return $this->hasMany(RekamMedis::class);
  }

  public function dokterPoli()
  {
    return $this->hasMany(DokterPoli::class, 'dokter_id');
  }
}
