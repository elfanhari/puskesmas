<?php

namespace Database\Seeders;

use App\Models\KategoriBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriBarangSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $kategori = [
      'Alat Tulis Kantor (ATK)',
      'Elektronik',
      'Peralatan Kebersihan',
      'Peralatan Laboratorium',
      'Perlengkapan Kelas',
      'Meja & Kursi',
      'Perangkat Komputer',
      'Peralatan Olahraga',
      'Buku Pelajaran',
      'Perlengkapan Upacara',
      'Peralatan Multimedia',
      'Peralatan Prakarya',
      'Inventaris Kantor',
      'Kebutuhan Toilet',
      'Perlengkapan UKS',
    ];

    foreach ($kategori as $nama) {
      KategoriBarang::create(['nama' => $nama]);
    }
  }
}
