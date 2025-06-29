<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
  User,
  Supplier,
  KategoriBarang,
  Barang,
  PermintaanBarang,
  ItemPermintaanBarang,
  PembelianBarang,
  ItemPembelianBarang,
  LogPermintaanBarang,
  LogPembelianBarang
};

class DummySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Roles
    $roles = ['admin', 'guru', 'tu', 'bendahara', 'kepsek'];

    // Users
    foreach ($roles as $role) {
      User::factory()->count(10)->create(['role' => $role]);
    }

    // Master
    Supplier::factory()->count(10)->create();
    $this->call(KategoriBarangSeeder::class);

    // Barang
    $this->call(BarangSeeder::class);

    // Permintaan Barang oleh Guru
    $guruUsers = User::where('role', 'guru')->get();
    foreach ($guruUsers as $guru) {
      PermintaanBarang::factory()->count(10)->create([
        'guru_id' => $guru->id
      ])->each(function ($permintaan) {
        ItemPermintaanBarang::factory()->count(2)->create([
          'permintaan_barang_id' => $permintaan->id
        ]);

        // Cari semua status sebelumnya sesuai urutan
        $logStatus = match ($permintaan->status) {
          'diajukan' => ['diajukan'],
          'menunggu_persetujuan' => ['diajukan', 'menunggu_persetujuan'],
          'disetujui' => ['diajukan', 'menunggu_persetujuan', 'disetujui'],
          'selesai' => ['diajukan', 'menunggu_persetujuan', 'disetujui', 'selesai'],
          'ditolak' => ['diajukan', 'menunggu_persetujuan', 'ditolak'],
          default => ['diajukan']
        };

        foreach ($logStatus as $status) {
          LogPermintaanBarang::create([
            'permintaan_barang_id' => $permintaan->id,
            'status' => $status,
            'created_at' => now()->addSeconds(rand(1, 60))
          ]);
        }
      });
    }

    // Pembelian Barang oleh Bendahara
    $bendaharaUsers = User::where('role', 'bendahara')->get();
    foreach ($bendaharaUsers as $bendahara) {
      PembelianBarang::factory()->count(6)->create([
        'bendahara_id' => $bendahara->id,
      ])->each(function ($pembelian) {
        ItemPembelianBarang::factory()->count(2)->create([
          'pembelian_barang_id' => $pembelian->id,
          'supplier_id' => Supplier::inRandomOrder()->first()->id
        ]);

        $statusLog = match ($pembelian->status) {
          'menunggu_persetujuan' => ['menunggu_persetujuan'],
          'disetujui' => ['menunggu_persetujuan', 'disetujui'],
          'selesai' => ['menunggu_persetujuan', 'disetujui', 'selesai'],
          'ditolak' => ['menunggu_persetujuan', 'ditolak'],
          default => ['menunggu_persetujuan']
        };

        foreach ($statusLog as $status) {
          LogPembelianBarang::create([
            'pembelian_barang_id' => $pembelian->id,
            'status' => $status,
            'created_at' => now()->addSeconds(rand(1, 60))
          ]);
        }
      });
    }

    $mapping = [
      1 => 'admin@gmail.com',
      12 => 'guru@gmail.com',
      23 => 'tu@gmail.com',
      35 => 'bendahara@gmail.com',
      43 => 'kepsek@gmail.com',
    ];

    foreach ($mapping as $id => $email) {
      $user = User::find($id);
      if ($user) {
        $user->email = $email;
        $user->is_aktif = 1;
        $user->save();
        echo "✅ Email untuk user ID {$id} diubah menjadi {$email}\n";
      } else {
        echo "⚠️ User ID {$id} tidak ditemukan\n";
      }
    }
  }
}
