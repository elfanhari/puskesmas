<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('rekam_medis', function (Blueprint $table) {
      $table->id();
      $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->onDelete('cascade');
      $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
      $table->foreignId('poli_id')->constrained('polis')->onDelete('cascade');
      $table->text('hasil_lab')->nullable();
      $table->text('diagnosa')->nullable();
      $table->text('tindakan')->nullable();
      $table->text('catatan')->nullable();
      $table->enum('status', ['menunggu_diperiksa', 'sedang_diperiksa', 'selesai_diperiksa', 'menunggu_obat', 'selesai']);
      $table->boolean('is_rujukan')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('rekam_medis');
  }
};
