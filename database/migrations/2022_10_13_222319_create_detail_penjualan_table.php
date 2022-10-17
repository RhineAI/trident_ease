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
        Schema::create('t_detail_penjualan', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->date('tgl');
            $table->integer('id_penjualan');
            $table->integer('id_barang');
            $table->integer('qty');
            $table->double('harga_beli');
            $table->double('harga_jual');
            $table->double('sub_total');
            $table->double('keuntungan');
            $table->foreign('id_penjualan')->references('id')->on('t_transaksi_penjualan')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('t_detail_penjualan');
    }
};
