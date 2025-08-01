<?php

namespace Database\Factories;

use App\Models\Dokter;
use App\Models\DokterPoli;
use App\Models\Poli;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'name' => fake()->name(),
      'email' => fake()->unique()->safeEmail(),
      'password' => 'password',
      'role' => fake()->randomElement(['admin', 'petugas', 'dokter', 'kepala']),
      'is_aktif' => $this->faker->randomElement([1, 0]),
    ];
  }

  public function configure()
  {
    return $this->afterCreating(function ($user) {
      if ($user->role === 'dokter') {
        $dokter = Dokter::create([
          'user_id' => $user->id,
          'name' => $user->name,
        ]);

        //         $poliIds = Poli::pluck('id')->toArray();
        //         if (count($poliIds)) {
        //           $selectedPoli = fake()->randomElements($poliIds, rand(1, min(3, count($poliIds))));
        //
        //           foreach ($selectedPoli as $poliId) {
        //             DokterPoli::create([
        //               'dokter_id' => $dokter->id,
        //               'poli_id' => $poliId,
        //             ]);
        //           }
        //         }

        DokterPoli::create([
          'dokter_id' => $dokter->id,
          'poli_id' => Poli::inRandomOrder()->first()->id,
        ]);
      }
    });
  }

  /**
   * Indicate that the model's email address should be unverified.
   *
   * @return static
   */
  public function unverified()
  {
    return $this->state(fn(array $attributes) => [
      'email_verified_at' => null,
    ]);
  }
}
