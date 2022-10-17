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
        Schema::create('t_detail_pembelian', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->date('tgl');
            $table->integer('id_pembelian');
            $table->integer('id_barang');
            $table->double('harga_beli');
            $table->integer('qty');
            $table->double('sub_total');
            $table->foreign('id_pembelian')->references('id')->on('t_transaksi_pembelian')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('t_detail_pembelian');
    }
};
