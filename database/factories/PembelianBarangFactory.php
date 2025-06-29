<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PembelianBarang>
 */
class PembelianBarangFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $status = fake()->randomElement(['menunggu_persetujuan', 'disetujui', 'ditolak', 'selesai']);
    if ($status == 'disetujui' || $status == 'ditolak') {
      $feedback = fake()->boolean(60) ? fake()->sentence() : null;
    } else {
      $feedback = null;
    }
    return [
      'bendahara_id' => User::where('role', 'bendahara')->inRandomOrder()->first()?->id,
      'tanggal' => fake()->dateTimeBetween('-10 months', 'now')->format('Y-m-d'),
      'status' => $status,
      'feedback' => $feedback,
    ];
  }
}
