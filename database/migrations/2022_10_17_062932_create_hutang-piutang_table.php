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
        Schema::create('t_data_piutang', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->bigInteger('id_penjualan');
            $table->date('tgl');
            $table->double('total_bayar');
            $table->integer('id_user');
            $table->integer('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id')->on('t_perusahaan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_penjualan')->references('id')->on('t_transaksi_penjualan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_user')->references('id')->on('t_users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('t_data_hutang', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->bigInteger('id_pembelian');
            $table->date('tgl');
            $table->double('total_bayar');
            $table->integer('id_user');
            $table->integer('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id')->on('t_perusahaan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_pembelian')->references('id')->on('t_transaksi_pembelian')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_user')->references('id')->on('t_users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('t_data-piutang');
        Schema::dropIfExists('t_data-hutang');
    }
};
