<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\PembelianBarang;
use App\Models\PermintaanBarang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Pendaftaran;
use App\Models\RekamMedis;

class DashboardController extends Controller
{
  public function index()
  {
    $data = [];
    $user = Auth::user();

    switch ($user->role) {
      case 'admin':
        $data = $this->dataAdmin();
        break;
      case 'petugas':
        $data = $this->dataPetugas();
        break;
      case 'dokter':
        $data = $this->dataDokter();
        break;
      case 'kepala':
        $data = $this->dataKepala();
        break;
    }

    return view('pages.dashboard.index', compact('data'));
  }

  private function dataAdmin()
  {
    return [
      [
        'title' => 'Admin',
        'icon' => '<i class="fas fa-user-shield"></i>',
        'color' => 'primary',
        'count' => User::where('role', 'admin')->count(),
      ],
      [
        'title' => 'Petugas',
        'icon' => '<i class="fas fa-user-cog"></i>',
        'color' => 'info',
        'count' => User::where('role', 'petugas')->count(),
      ],
      [
        'title' => 'Dokter',
        'icon' => '<i class="fas fa-user-md"></i>',
        'color' => 'success',
        'count' => User::where('role', 'dokter')->count(),
      ],
      [
        'title' => 'Pasien',
        'icon' => '<i class="fas fa-address-card"></i>',
        'color' => 'secondary',
        'count' => \App\Models\Pasien::count(),
      ],
      [
        'title' => 'Poli',
        'icon' => '<i class="fas fa-clinic-medical"></i>',
        'color' => 'warning',
        'count' => \App\Models\Poli::count(),
      ],
      [
        'title' => 'Obat',
        'icon' => '<i class="fas fa-pills"></i>',
        'color' => 'danger',
        'count' => \App\Models\Obat::count(),
      ],
      [
        'title' => 'Pendaftaran Hari Ini',
        'icon' => '<i class="fas fa-clipboard-list"></i>',
        'color' => 'light',
        'count' => \App\Models\Pendaftaran::whereDate('tanggal', now()->toDateString())->count(),
      ],
      [
        'title' => 'Rekam Medis (Total)',
        'icon' => '<i class="fas fa-notes-medical"></i>',
        'color' => 'primary',
        'count' => \App\Models\RekamMedis::count(),
      ],

    ];
  }


  private function dataPetugas()
  {
    return [
      [
        'title' => 'Pasien',
        'icon' => '<i class="fas fa-address-card"></i>',
        'color' => 'success',
        'count' => Pasien::count(),
      ],
      [
        'title' => 'Pendaftaran',
        'icon' => '<i class="fas fa-clipboard-list"></i>',
        'color' => 'info',
        'count' => Pendaftaran::count(),
      ],
      [
        'title' => 'Rekam Medis',
        'icon' => '<i class="fas fa-notes-medical"></i>',
        'color' => 'warning',
        'count' => RekamMedis::count(),
      ],
      [
        'title' => 'Pengambilan Obat',
        'icon' => '<i class="fas fa-capsules"></i>',
        'color' => 'primary',
        'count' => \App\Models\PengambilanObat::count(),
      ],
    ];
  }

  private function dataDokter()
  {
    $dokterId = Auth::user()->dokter_id;

    return [
      [
        'title' => 'Rekam Medis Saya',
        'icon' => '<i class="fas fa-notes-medical"></i>',
        'color' => 'primary',
        'count' => RekamMedis::where('dokter_id', $dokterId)->count(),
      ],
      [
        'title' => 'Menunggu',
        'icon' => '<i class="fas fa-stethoscope"></i>',
        'color' => 'info',
        'count' => RekamMedis::where('dokter_id', $dokterId)->where('status', 'menunggu_diperiksa')->count(),
      ],
      [
        'title' => 'Sedang Diperiksa',
        'icon' => '<i class="fas fa-stethoscope"></i>',
        'color' => 'warning',
        'count' => RekamMedis::where('dokter_id', $dokterId)->where('status', 'sedang_diperiksa')->count(),
      ],
      [
        'title' => 'Selesai Diperiksa',
        'icon' => '<i class="fas fa-check-circle"></i>',
        'color' => 'success',
        'count' => RekamMedis::where('dokter_id', $dokterId)->where('status', 'selesai')->count(),
      ],
    ];
  }

  private function dataKepala()
  {
    return [
      [
        'title' => 'Total Pasien',
        'icon' => '<i class="fas fa-users"></i>',
        'color' => 'primary',
        'count' => Pasien::count(),
      ],
      [
        'title' => 'Rekam Medis',
        'icon' => '<i class="fas fa-notes-medical"></i>',
        'color' => 'info',
        'count' => RekamMedis::count(),
      ],
      [
        'title' => 'Dokter Aktif',
        'icon' => '<i class="fas fa-user-md"></i>',
        'color' => 'success',
        'count' => User::where('role', 'dokter')->count(),
      ],
    ];
  }
}
