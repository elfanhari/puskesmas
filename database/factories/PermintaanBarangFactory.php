<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PermintaanBarang>
 */
class PermintaanBarangFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $status = fake()->randomElement(['diajukan', 'menunggu_persetujuan', 'disetujui', 'ditolak', 'selesai']);
    if ($status == 'disetujui' || $status == 'ditolak') {
      $feedback = fake()->boolean(60) ? fake()->sentence() : null;
    } else {
      $feedback = null;
    }
    return [
      'guru_id' => User::where('role', 'guru')->inRandomOrder()->first()?->id,
      'alasan' => fake()->sentence(),
      'tanggal' => fake()->dateTimeBetween('-10 months', 'now')->format('Y-m-d'),
      'status' => $status,
      'feedback' => $feedback,
    ];
  }
}
