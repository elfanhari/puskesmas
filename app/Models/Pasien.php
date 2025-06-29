<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function pendaftaran()
  {
    return $this->hasMany(Pendaftaran::class);
  }

  public function getJkFormattedAttribute()
  {
    return $this->jenis_kelamin == 'L' ? 'Laki-laki' : ($this->jenis_kelamin == 'P' ? 'Perempuan' : '-');
  }

  public function getTanggalLahirFormattedAttribute()
  {
    return \Carbon\Carbon::parse($this->tanggal_lahir ?? null)->translatedFormat('d F Y') ?? '-';
  }
}
