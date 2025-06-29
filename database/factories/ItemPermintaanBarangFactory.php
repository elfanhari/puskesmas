<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemPermintaanBarang>
 */
class ItemPermintaanBarangFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'permintaan_barang_id' => null, // diisi di seeder
      'barang_id' => \App\Models\Barang::inRandomOrder()->first()?->id,
      'jumlah' => fake()->numberBetween(1, 5),
    ];
  }
}
