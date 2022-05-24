<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksitoko extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('transaksi_toko', function (Blueprint $table) {
      $table->id();
      $table->date('tanggal');
      $table->foreignId('id_produk')->constrained('produk');
      $table->string('kuantitas');
      $table->string('total_harga');
      $table->string('jumlah_bayar');
      $table->string('kembalian');
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
    Schema::dropIfExists('transaksi_toko');
  }
}
