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
        Schema::create('t_transaksi_pembelian', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->date('tgl');
            // $table->string('kode_invoice');
            $table->integer('id_supplier');
            $table->double('total_pembelian');
            $table->double('bayar');
            $table->double('kembali');
            $table->integer('jenis_pembayaran')->comment('1:Cash, 2:Credits, 3:Transfer');
            $table->double('dp');
            $table->double('sisa');
            $table->integer('id_user');
            $table->integer('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id')->on('t_perusahaan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_supplier')->references('id')->on('t_supplier')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('t_transaksi_pembelian');
    }
};
