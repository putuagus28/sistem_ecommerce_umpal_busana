<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pesanans_id')->nullable()->index();
            $table->foreign('pesanans_id')->references('id')->on('pesanans')->onDelete('cascade');
            $table->uuid('produks_id')->nullable()->index();
            $table->foreign('produks_id')->references('id')->on('produks')->onDelete('cascade');
            $table->integer('qty');
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
        Schema::dropIfExists('detail_pesanans');
    }
}
