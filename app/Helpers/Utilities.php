<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Utilities
{
  public static function getRoleFormatted($role)
  {
    return match ($role) {
      'admin'     => 'Admin',
      'petugas'      => 'Petugas',
      'dokter'        => 'Dokter',
      'kepala'    => 'Kepala Puskesmas',
      default     => ucfirst($role),
    };
  }

  public static function getStatusLabel($status)
  {
    return match ($status) {
      'menunggu_diperiksa' => 'Menunggu Diperiksa',
      'sedang_diperiksa'   => 'Sedang Diperiksa',
      'selesai_diperiksa'  => 'Selesai Diperiksa',
      'menunggu_obat'      => 'Menunggu Obat',
      'selesai'            => 'Selesai',
      default              => ucfirst($status),
    };
  }

  public static function getStatusColor($status)
  {
    return match ($status) {
      'menunggu_diperiksa' => 'light',
      'sedang_diperiksa'   => 'info',
      'selesai_diperiksa'  => 'primary',
      'menunggu_obat'      => 'warning',
      'selesai'            => 'success',
      default                  => 'dark',
    };
  }

  public static function getStatusIcon($status)
  {
    return match ($status) {
      'menunggu_diperiksa' => 'fas fa-clock',              // ⏰ Menunggu giliran
      'sedang_diperiksa'   => 'fas fa-stethoscope',        // 🩺 Dalam proses pemeriksaan
      'selesai_diperiksa'  => 'fas fa-clipboard-check',    // ✅ Sudah diperiksa
      'menunggu_obat'      => 'fas fa-pills',              // 💊 Menunggu obat
      'selesai'            => 'fas fa-check-circle',       // 🟢 Selesai semua proses
      default            => 'fas fa-question-circle',    // ❓ Tidak dikenal
    };
  }

  public static function generateNoKartuPasien()
  {
    return 'KRT-' . strtoupper(Str::random(6));
  }

  public static function getTeleponFormatted(string $telepon): string
  {
    $telepon = preg_replace('/[\s\-\.\(\)]+/', '', $telepon);
    $telepon = preg_replace('/[^+0-9]/', '', $telepon);
    // Ganti awalan 08 dengan +62
    if (str_starts_with($telepon, '08')) {
      $telepon = '62' . substr($telepon, 1);
    }
    return $telepon;
  }
}
