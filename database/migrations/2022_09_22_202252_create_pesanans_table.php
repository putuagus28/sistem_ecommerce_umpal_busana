<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('users_global')->nullable()->index();
            $table->integer('total_bayar')->nullable();
            $table->integer('ongkir');
            $table->string('bukti')->nullable();  // upload bukti bayar dari pelanggan
            $table->text('alamat_pengiriman');
            $table->text('catatan')->nullable();
            $table->integer('status')->default(0); // status 0 =belum bayar, 1= kirim, 2 = kemas,1 = terima
            $table->string('kurir')->nullable();
            $table->string('kode_resi')->nullable();
            $table->string('estimasi_sampai')->nullable();
            $table->date('tgl_terima')->nullable();
            $table->date('tgl_kirim')->nullable();
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('pesanans');
        Schema::dropIfExists('detail_pesanans');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
