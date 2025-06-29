<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemPembelianBarang>
 */
class ItemPembelianBarangFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'pembelian_barang_id' => null,
      'barang_id' => \App\Models\Barang::inRandomOrder()->first()?->id,
      'supplier_id' => Supplier::inRandomOrder()->first()?->id,
      'jumlah' => fake()->numberBetween(1, 10),
      'harga_satuan' => fake()->numberBetween(20000, 5000000) / 500 * 500,
    ];
  }
}
