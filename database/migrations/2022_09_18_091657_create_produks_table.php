<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kategoris_id')->nullable()->index();
            $table->foreign('kategoris_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->string('nama_produk');
            $table->date('tgl_masuk');
            $table->integer('harga');
            $table->text('keterangan');
            $table->text('gambar');
            $table->char('size', 10);
            $table->integer('berat_satuan');
            $table->integer('stok');
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
        Schema::dropIfExists('produks');
    }
}
