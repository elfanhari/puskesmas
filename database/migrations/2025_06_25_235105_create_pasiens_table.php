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
    Schema::create('pasiens', function (Blueprint $table) {
      $table->id();
      $table->string('no_kartu')->unique();
      $table->string('name');
      $table->string('nik');
      $table->date('tanggal_lahir');
      $table->enum('jenis_kelamin', ['L', 'P']);
      $table->text('alamat');
      $table->string('telepon');
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
    Schema::dropIfExists('pasiens');
  }
};
