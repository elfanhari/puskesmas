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
    Schema::create('obat_rekam_medis', function (Blueprint $table) {
      $table->id();
      $table->foreignId('rekam_medis_id')->constrained('rekam_medis')->onDelete('cascade');
      $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
      $table->integer('jumlah')->nullable();
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
    Schema::dropIfExists('obat_rekam_medis');
  }
};
