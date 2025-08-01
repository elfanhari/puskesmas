<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Obat>
 */
class ObatFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'name' => $this->faker->unique()->words(2, true),
      'stok' => $this->faker->numberBetween(50, 200),
      'satuan' => $this->faker->randomElement(['tablet', 'kapsul', 'botol']),
    ];
  }
}
