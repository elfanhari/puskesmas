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
    Schema::create('puskesmas', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('alamat')->nullable();
      $table->string('telepon')->nullable();
      $table->string('email')->nullable();
      $table->string('website')->nullable();
      $table->string('logo')->default('logo.png');
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
    Schema::dropIfExists('puskesmas');
  }
};
