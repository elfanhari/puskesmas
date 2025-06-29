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
    Schema::create('pendaftarans', function (Blueprint $table) {
      $table->id();
      $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
      $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
      $table->date('tanggal');
      $table->text('keluhan')->nullable();
      $table->string('tekanan_darah')->nullable();
      $table->float('suhu')->nullable();
      $table->float('tinggi_badan')->nullable();
      $table->float('berat_badan')->nullable();
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
    Schema::dropIfExists('pendaftarans');
  }
};
