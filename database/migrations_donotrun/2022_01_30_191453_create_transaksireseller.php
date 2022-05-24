<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksireseller extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::dropIfExists('transaksi_reseller');
    Schema::create('transaksi_reseller', function (Blueprint $table) {
      $table->id();
      $table->string('id_pesanan')->unique();
      $table->dateTime('tanggal')->nullable();
      $table->foreignId('id_produk')->constrained('produk');
      $table->foreignId('id_reseller')->constrained('reseller');
      $table->string('kuantitas');
      $table->string('total_harga');
      // $table->foreignId('id_metode_bayar')->constrained('pembayaran');
      $table->string('status')->nullable();
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
    Schema::dropIfExists('transaksi_reseller');
  }
}
