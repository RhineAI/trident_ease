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
        Schema::create('t_retur_pembelian', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->bigInteger('id_pembelian');
            $table->date('tgl');
            $table->double('total_retur');
            $table->double('retur_keuntungan');
            $table->integer('id_user');
            $table->integer('id_perusahaan');
            $table->foreign('id_pembelian')->references('id')->on('t_transaksi_pembelian')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_perusahaan')->references('id')->on('t_perusahaan')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('t_retur_pembelian');
    }
};
