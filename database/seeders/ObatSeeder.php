<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $obats = [
      ['name' => 'Paracetamol', 'stok' => 150, 'satuan' => 'tablet'],
      ['name' => 'Amoxicillin', 'stok' => 100, 'satuan' => 'kapsul'],
      ['name' => 'Cotrimoxazole', 'stok' => 80, 'satuan' => 'tablet'],
      ['name' => 'Ibuprofen', 'stok' => 90, 'satuan' => 'tablet'],
      ['name' => 'Salbutamol', 'stok' => 60, 'satuan' => 'tablet'],
      ['name' => 'Cetirizine', 'stok' => 70, 'satuan' => 'tablet'],
      ['name' => 'Loperamide', 'stok' => 50, 'satuan' => 'tablet'],
      ['name' => 'Vitamin C', 'stok' => 200, 'satuan' => 'tablet'],
      ['name' => 'Zinc', 'stok' => 120, 'satuan' => 'tablet'],
      ['name' => 'ORS', 'stok' => 90, 'satuan' => 'sachet'],
      ['name' => 'Antasida Doen', 'stok' => 110, 'satuan' => 'tablet'],
      ['name' => 'Metronidazole', 'stok' => 100, 'satuan' => 'tablet'],
      ['name' => 'Simvastatin', 'stok' => 60, 'satuan' => 'tablet'],
      ['name' => 'Captopril', 'stok' => 80, 'satuan' => 'tablet'],
      ['name' => 'Amlodipine', 'stok' => 70, 'satuan' => 'tablet'],
      ['name' => 'Furosemide', 'stok' => 50, 'satuan' => 'tablet'],
      ['name' => 'Diazepam', 'stok' => 40, 'satuan' => 'tablet'],
      ['name' => 'Omeprazole', 'stok' => 60, 'satuan' => 'kapsul'],
      ['name' => 'Albendazole', 'stok' => 100, 'satuan' => 'tablet'],
      ['name' => 'Mebendazole', 'stok' => 100, 'satuan' => 'tablet'],
      ['name' => 'Ranitidine', 'stok' => 80, 'satuan' => 'tablet'],
      ['name' => 'Dexamethasone', 'stok' => 90, 'satuan' => 'tablet'],
      ['name' => 'Chlorpheniramine (CTM)', 'stok' => 120, 'satuan' => 'tablet'],
      ['name' => 'Loratadine', 'stok' => 100, 'satuan' => 'tablet'],
      ['name' => 'Salep Gentamicin', 'stok' => 40, 'satuan' => 'tube'],
      ['name' => 'Betadine', 'stok' => 30, 'satuan' => 'botol'],
      ['name' => 'Erythromycin', 'stok' => 60, 'satuan' => 'tablet'],
      ['name' => 'Asam Mefenamat', 'stok' => 80, 'satuan' => 'tablet'],
      ['name' => 'Diazepam', 'stok' => 30, 'satuan' => 'ampul'],
      ['name' => 'Vitamin B Kompleks', 'stok' => 150, 'satuan' => 'tablet'],
    ];

    foreach ($obats as $obat) {
      Obat::create($obat);
    }
  }
}
