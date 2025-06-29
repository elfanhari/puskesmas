<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Sekolah::create([
      'name' => 'SMA NEGERI 1 INDONESIA',
      'alamat' => fake()->address(),
      'telepon' => fake()->phoneNumber(),
      'email' => 'email@mail.com',
      'website' => 'nama-sekolah.sch.id',
      'logo' => 'logo.png',
    ]);
  }
}
