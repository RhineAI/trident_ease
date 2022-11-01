<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('t_detail_retur_pembelian', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('id_retur_pembelian');
            $table->integer('id_barang');
            $table->integer('qty');
            $table->double('harga_beli');
            $table->double('harga_jual');
            $table->double('sub_total');
            $table->double('keuntungan');
            $table->integer('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id')->on('t_perusahaan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_retur_pembelian')->references('id')->on('t_retur_pembelian')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_barang')->references('id')->on('t_barang')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_det_retur_pembelian');
    }
};
