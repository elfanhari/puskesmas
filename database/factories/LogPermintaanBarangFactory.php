<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LogPermintaanBarang>
 */
class LogPermintaanBarangFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'permintaan_barang_id' => null,
      'status' => fake()->randomElement(['diajukan', 'menunggu_persetujuan', 'disetujui', 'ditolak']),
      'created_at' => now(),
    ];
  }
}
