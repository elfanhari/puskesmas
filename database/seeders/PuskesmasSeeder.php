<?php

namespace Database\Seeders;

use App\Models\Puskesmas;
use App\Models\Sekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PuskesmasSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Puskesmas::create([
      'name' => 'PUSKESMAS PAPUA',
      'alamat' => fake()->address(),
      'telepon' => fake()->phoneNumber(),
      'email' => 'email@mail.com',
      'website' => 'nama-puskesmas.com',
      'logo' => 'logo.png',
    ]);
  }
}
