<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'no_kartu' => 'RM-' . strtoupper(Str::random(6)),
      'name' => $this->faker->name(),
      'nik' => $this->faker->nik(),
      'tanggal_lahir' => $this->faker->date('Y-m-d', '-20 years'),
      'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
      'alamat' => $this->faker->address(),
      'telepon' => $this->faker->phoneNumber(),
    ];
  }
}
