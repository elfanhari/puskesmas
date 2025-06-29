<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Dokter;
use App\Models\Obat;
use App\Models\ObatRekamMedis;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\PengambilanObat;
use App\Models\Poli;
use App\Models\RekamMedis;
use App\Models\Rujukan;
use App\Models\User;
use Illuminate\Database\Seeder;
use tidy;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // \App\Models\User::factory()->create([
    //   'name' => 'Elfan Admin',
    //   'email' => 'admin@gmail.com',
    //   'password' => 'password', // password
    //   'foto' => 'profile.jpg',
    //   'role' => 'admin',
    //   'is_aktif' => 1,
    // ]);
    // $this->call(DummySeeder::class);
    // $this->call(SekolahSeeder::class);

    User::factory()->create(['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => 'password', 'role' => 'admin']);
    User::factory()->create(['name' => 'Petugas', 'email' => 'petugas@gmail.com', 'password' => 'password', 'role' => 'petugas']);
    $dokterUser = User::factory()->create(['name' => 'Dokter', 'email' => 'dokter@gmail.com', 'password' => 'password', 'role' => 'dokter']);
    User::factory()->create(['name' => 'Kepala', 'email' => 'kepala@gmail.com', 'password' => 'password', 'role' => 'kepala']);

    User::factory()->count(40)->create();
    // Dokter::factory()->create(['user_id' => $dokterUser->id, 'name' => 'dr. Fauzi']);
    $this->call(PuskesmasSeeder::class);

    Poli::insert([
      ['name' => 'Poli Umum', 'created_at' => now(), 'updated_at' => now()],
      ['name' => 'Poli Gigi', 'created_at' => now(), 'updated_at' => now()],
      ['name' => 'Poli KIA', 'created_at' => now(), 'updated_at' => now()],
    ]);

    $this->call(ObatSeeder::class);
    Pasien::factory(100)->create();
    Pendaftaran::factory(100)->create()->each(function ($pendaftaran) {

      $status = fake()->randomElement(['selesai', 'menunggu_obat', 'menunggu_diperiksa']);
      $isRujukan = $status === 'selesai' ? fake()->boolean(20) : false;
      $rekam = RekamMedis::factory()->create(['pendaftaran_id' => $pendaftaran->id, 'status' => $status, 'is_rujukan' => $isRujukan]);

      if (($status === 'menunggu_obat' || $status === 'selesai') && $isRujukan == false) {
        $obats = Obat::inRandomOrder()->take(rand(1, 3))->get();
        foreach ($obats as $obat) {
          ObatRekamMedis::create([
            'rekam_medis_id' => $rekam->id,
            'obat_id' => $obat->id,
            'jumlah' => rand(1, 5),
          ]);
        }

        PengambilanObat::create([
          'rekam_medis_id' => $rekam->id,
          'waktu_pengambilan' => now()->addDays(rand(0, 2)),
          'catatan' => 'Ambil di loket obat',
        ]);
      }

      if ($isRujukan && $status === 'selesai') {
        Rujukan::create([
          'rekam_medis_id' => $rekam->id,
          'rumah_sakit_tujuan' => 'RSUD Kota',
          'alasan' => 'Butuh pemeriksaan lanjutan',
        ]);
      }
    });
  }
}
