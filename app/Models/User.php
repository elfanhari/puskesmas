<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $guarded = ['id'];
  // protected $fillable = [
  //     'name',
  //     'email',
  //     'password',
  // ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function setPasswordAttribute($password)
  {
    $this->attributes['password'] = bcrypt($password);
  }

  public function isAktif()
  {
    return $this->is_aktif == '1';
  }

  public function dokter()
  {
    return $this->hasOne(Dokter::class);
  }

  public function pendaftaran()
  {
    return $this->hasMany(Pendaftaran::class, 'petugas_id');
  }

  public function isAdmin()
  {
    return $this->role === 'admin';
  }

  public function isPetugas()
  {
    return $this->role === 'petugas';
  }

  public function isDokter()
  {
    return $this->role === 'dokter';
  }

  public function isKepala()
  {
    return $this->role === 'kepala';
  }

  public function getRoleFormattedAttribute()
  {
    return match ($this->role) {
      'admin'     => 'Admin',
      'petugas'  => 'Petugas',
      'dokter'    => 'Dokter',
      'kepala'    => 'Kepala Puskesmas',
      default     => ucfirst($this->role),
    };
  }

  public function getUrlFotoAttribute()
  {
    return asset('img/profile/' . ($this->foto ?? 'profile.jpg'));
  }

  public function getDokterIdAttribute()
  {
    if ($this->isDokter()) {
      return $this->dokter->id ?? null;
    } else {
      return null;
    }
  }
}
