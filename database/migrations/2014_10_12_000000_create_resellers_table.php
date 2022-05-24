<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // create table if not exist
    if (!Schema::hasTable('reseller')) {
      Schema::create('reseller', function (Blueprint $table) {
          $table->id();
          $table->string('nama_reseller');
          $table->string('email')->nullable()->unique();
          $table->timestamp('email_verified_at')->nullable();
          $table->string('password');
          $table->string('telp');
          $table->text('alamat');
          $table->string('foto_profil')->nullable();
          $table->rememberToken();
          $table->timestamps();
      });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reseller');
    }
}
