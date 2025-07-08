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
    Schema::create('pengambilan_obats', function (Blueprint $table) {
      $table->id();
      $table->foreignId('rekam_medis_id')->constrained('rekam_medis')->onDelete('cascade');
      $table->timestamp('waktu_pengambilan')->nullable();
      $table->text('catatan')->nullable();
      $table->boolean('is_notified')->default(false);
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
    Schema::dropIfExists('pengambilan_obats');
  }
};
