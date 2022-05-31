<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetAlamatNotnull extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('reseller', function (Blueprint $table) {
      $table->text('alamat')->nullable()->change();
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
      $table->text('alamat')->nullable(false)->change();
    });
  }
}
