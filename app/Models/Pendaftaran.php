<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function pasien()
  {
    return $this->belongsTo(Pasien::class);
  }

  public function petugas()
  {
    return $this->belongsTo(User::class, 'petugas_id');
  }

  public function rekamMedis()
  {
    return $this->hasOne(RekamMedis::class, 'rekam_medis_id');
  }
}
