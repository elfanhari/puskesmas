<?php

namespace Database\Factories;

use App\Models\Dokter;
use App\Models\Pendaftaran;
use App\Models\Poli;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RekamMedis>
 */
class RekamMedisFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $status = $this->faker->randomElement(['selesai', 'menunggu_obat', 'menunggu_diperiksa']);
    return [
      'pendaftaran_id' => Pendaftaran::factory(),
      'dokter_id' => Dokter::inRandomOrder()->first()->id ?? Dokter::factory(),
      'poli_id' => Poli::inRandomOrder()->first()->id ?? Poli::factory(),
      'hasil_lab' => $this->faker->sentence(),
      'diagnosa' => $this->faker->sentence(),
      'tindakan' => $this->faker->sentence(),
      'catatan' => $this->faker->text(100),
      'status' => $status,
      'is_rujukan' => $status == 'selesai' ? $this->faker->boolean(20) : false,
    ];
  }
}
