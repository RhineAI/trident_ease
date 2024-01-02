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
        Schema::create('t_transaksi_penjualan', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->date('tgl');
            $table->integer('id_pelanggan')->nullable();
            // $table->string('kode_invoice');
            $table->integer('total_harga');
            // $table->float('diskon')->default(0);
            $table->double('total_bayar');
            $table->double('keuntungan');
            $table->double('kembalian');
            $table->integer('jenis_pembayaran')->comment('1:Cash, 2:Credits');
            $table->double('dp');
            $table->double('sisa');
            $table->integer('id_user');
            $table->integer('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id')->on('t_perusahaan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_pelanggan')->references('id')->on('t_pelanggan')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('t_transaksi_penjualan');
    }
};
