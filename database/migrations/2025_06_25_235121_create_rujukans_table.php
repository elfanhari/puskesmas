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
    Schema::create('rujukans', function (Blueprint $table) {
      $table->id();
      $table->foreignId('rekam_medis_id')->constrained('rekam_medis')->onDelete('cascade');
      $table->string('rumah_sakit_tujuan')->nullable();
      $table->text('alasan')->nullable();
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
    Schema::dropIfExists('rujukans');
  }
};
