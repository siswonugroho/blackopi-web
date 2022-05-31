<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoresiColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi_reseller', function (Blueprint $table) {
            //
            $table->string('no_resi')->nullable()->after('id_kurir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_reseller', function (Blueprint $table) {
            //
            $table->dropColumn('no_resi');
        });
    }
}
