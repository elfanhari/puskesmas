<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
  use HasFactory;
  protected $guarded = ['id'];
  protected $table = 'puskesmas';

  public function getUrlLogoAttribute()
  {
    return asset('img/logo/' . ($this->logo ?? 'logo.png'));
  }
}
