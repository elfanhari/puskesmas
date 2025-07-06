<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeederKosongan extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    User::factory()->create(['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => 'password', 'role' => 'admin', 'is_aktif' => true]);
    User::factory()->create(['name' => 'Petugas', 'email' => 'petugas@gmail.com', 'password' => 'password', 'role' => 'petugas', 'is_aktif' => true]);
    $dokterUser = User::factory()->create(['name' => 'Dokter', 'email' => 'dokter@gmail.com', 'password' => 'password', 'role' => 'dokter', 'is_aktif' => true]);
    User::factory()->create(['name' => 'Kepala', 'email' => 'kepala@gmail.com', 'password' => 'password', 'role' => 'kepala', 'is_aktif' => true]);

    $this->call(PuskesmasSeeder::class);
  }
}
