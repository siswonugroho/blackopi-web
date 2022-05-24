<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressColumnReseller extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('reseller', function (Blueprint $table) {
      $table->bigInteger('id_provinsi')->after('password')->nullable();
      $table->bigInteger('id_kota')->after('id_provinsi')->nullable();
      $table->bigInteger('id_kecamatan')->after('id_kota')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('reseller', function (Blueprint $table) {
      //
      $table->dropColumn('id_provinsi');
      $table->dropColumn('id_kota');
      $table->dropColumn('id_kecamatan');
    });
  }
}
