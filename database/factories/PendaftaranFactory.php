<?php

namespace Database\Factories;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pendaftaran>
 */
class PendaftaranFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'pasien_id' => Pasien::factory(),
      'petugas_id' => User::where('role', 'petugas')->inRandomOrder()->first()->id ?? User::factory(),
      'tanggal' => $this->faker->dateTimeBetween('-6 months', 'now'),
      'keluhan' => $this->faker->sentence(6),
      'tekanan_darah' => $this->faker->numberBetween(90, 140) . '/' . $this->faker->numberBetween(60, 100),
      'suhu' => $this->faker->randomFloat(1, 36, 39),
      'tinggi_badan' => $this->faker->numberBetween(120, 180),
      'berat_badan' => $this->faker->numberBetween(40, 90),
    ];
  }
}
