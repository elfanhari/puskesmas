<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  public function rekamMedis()
  {
    return $this->hasMany(RekamMedis::class);
  }

  public function dokterPoli()
  {
    return $this->hasMany(DokterPoli::class, 'poli_id');
  }
}
