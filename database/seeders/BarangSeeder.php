<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BarangSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $data = [
      'Alat Tulis Kantor (ATK)' => [
        ['Pulpen Biru', 'pcs'],
        ['Pulpen Merah', 'pcs'],
        ['Pensil 2B', 'pcs'],
        ['Penghapus Karet', 'pcs'],
        ['Stabilo Warna', 'pcs'],
        ['Kertas HVS A4', 'rim'],
        ['Kertas Folio Bergaris', 'rim'],
        ['Map Snelhecter', 'pcs'],
        ['Binder Klip', 'box'],
        ['Lakban Bening', 'roll'],
      ],
      'Elektronik' => [
        ['Proyektor LCD', 'unit'],
        ['Printer Inkjet', 'unit'],
        ['Mesin Fotocopy', 'unit'],
        ['Speaker Aktif', 'unit'],
        ['Kipas Angin', 'unit'],
        ['Modem Wifi', 'unit'],
        ['Stop Kontak', 'pcs'],
        ['Kabel Roll', 'unit'],
      ],
      'Peralatan Kebersihan' => [
        ['Sapu Ijuk', 'pcs'],
        ['Pel Lantai', 'pcs'],
        ['Tempat Sampah', 'unit'],
        ['Ember Air', 'pcs'],
        ['Kemoceng', 'pcs'],
        ['Sikat Lantai', 'pcs'],
        ['Tisu Gulung', 'roll'],
        ['Sabun Pembersih Lantai', 'botol'],
      ],
      'Peralatan Laboratorium' => [
        ['Tabung Reaksi', 'pcs'],
        ['Mikroskop', 'unit'],
        ['Bunsen', 'unit'],
        ['Neraca Digital', 'unit'],
        ['Botol Reagen', 'pcs'],
        ['Kaca Pembesar', 'pcs'],
        ['Pipet Tetes', 'pcs'],
      ],
      'Perlengkapan Kelas' => [
        ['Spidol Whiteboard', 'pcs'],
        ['Penghapus Whiteboard', 'pcs'],
        ['Papan Tulis', 'unit'],
        ['Jam Dinding', 'unit'],
        ['Gantungan Absensi', 'pcs'],
        ['Poster Edukasi', 'lembar'],
        ['Lampu Kelas LED', 'pcs'],
      ],
      'Meja & Kursi' => [
        ['Meja Guru Kayu', 'unit'],
        ['Kursi Siswa Plastik', 'unit'],
        ['Meja Siswa Lipat', 'unit'],
        ['Lemari Arsip', 'unit'],
        ['Rak Buku Besi', 'unit'],
        ['Bangku Panjang', 'unit'],
      ],
      'Perangkat Komputer' => [
        ['Monitor LED', 'unit'],
        ['Keyboard USB', 'pcs'],
        ['Mouse Wireless', 'pcs'],
        ['CPU Intel Core i5', 'unit'],
        ['Kabel LAN', 'meter'],
        ['Switch Hub 8-Port', 'unit'],
        ['UPS 1000VA', 'unit'],
      ],
      'Peralatan Olahraga' => [
        ['Bola Sepak', 'pcs'],
        ['Bola Basket', 'pcs'],
        ['Raket Badminton', 'pcs'],
        ['Peluit Wasit', 'pcs'],
        ['Matras Senam', 'pcs'],
        ['Net Voli', 'set'],
        ['Cones Latihan', 'pcs'],
      ],
      'Buku Pelajaran' => [
        ['Buku Matematika Kelas 10', 'buku'],
        ['Buku Bahasa Indonesia Kelas 9', 'buku'],
        ['Buku IPA Terpadu', 'buku'],
        ['Buku Sejarah Nasional', 'buku'],
        ['Buku Pendidikan Pancasila', 'buku'],
        ['Buku Bahasa Inggris Kelas 8', 'buku'],
        ['Buku Praktikum Kimia', 'buku'],
      ],
      'Perlengkapan Upacara' => [
        ['Bendera Merah Putih', 'pcs'],
        ['Tiang Bendera', 'unit'],
        ['Seragam Paskibra', 'set'],
        ['Toa Portable', 'unit'],
        ['Tali Bendera', 'meter'],
        ['Sepatu Paskibra', 'pasang'],
      ],
    ];

    foreach ($data as $kategori => $barangs) {
      $kategoriId = KategoriBarang::where('nama', $kategori)->first()?->id;

      if (!$kategoriId) continue;

      foreach ($barangs as [$nama, $satuan]) {
        Barang::create([
          'kategori_barang_id' => $kategoriId,
          'nama' => $nama,
          'kode' => strtoupper(fake()->bothify('BRG-###??')),
          'stok' => rand(5, 50),
          'satuan' => $satuan,
          'keterangan' => fake()->sentence()
        ]);
      }
    }
  }
}
