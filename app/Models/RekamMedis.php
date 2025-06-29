<?php

namespace App\Models;

use App\Helpers\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function pendaftaran()
  {
    return $this->belongsTo(Pendaftaran::class);
  }

  public function dokter()
  {
    return $this->belongsTo(Dokter::class);
  }

  public function poli()
  {
    return $this->belongsTo(Poli::class);
  }

  public function obatRekamMedis()
  {
    return $this->hasMany(ObatRekamMedis::class);
  }

  public function pengambilanObat()
  {
    return $this->hasOne(PengambilanObat::class);
  }

  public function rujukan()
  {
    return $this->hasOne(Rujukan::class);
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

  public function getKeputusanAttribute()
  {
    if ($this->is_rujukan && $this->rujukan()->exists()) {
      return 'dirujuk';
    }

    if ($this->obatRekamMedis()->exists()) {
      return 'diberi_obat';
    }

    return null;
  }

  public function getKeputusanFormattedAttribute()
  {
    return match ($this->keputusan) {
      'diberi_obat' => 'Diberi Obat',
      'dirujuk' => 'Dirujuk',
      default => '-',
    };
  }
}
