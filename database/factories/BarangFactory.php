<?php

namespace Database\Factories;

use App\Models\KategoriBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'kategori_barang_id' => KategoriBarang::inRandomOrder()->first()?->id ?? KategoriBarang::factory(),
      'nama' => fake()->word(),
      'kode' => strtoupper(fake()->bothify('BRG-###??')),
      'stok' => fake()->numberBetween(10, 100),
      'satuan' => fake()->randomElement(['pcs', 'buah', 'unit']),
      'keterangan' => fake()->sentence(),
    ];
  }
}
