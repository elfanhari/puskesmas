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
    Schema::create('dokter_polis', function (Blueprint $table) {
      $table->id();
      $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
      $table->foreignId('poli_id')->constrained('polis')->onDelete('cascade');
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
    Schema::dropIfExists('dokter_polis');
  }
};
