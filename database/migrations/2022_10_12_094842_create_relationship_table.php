<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_perusahaan', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('nama', 50)->unique();
            $table->text('alamat');
            $table->string('tlp', 50);
            $table->string('pemilik', 50);
            $table->string('bank', 50);
            $table->string('no_rekening', 50);
            $table->string('npwp', 50);
            $table->string('slogan', 50);
            $table->string('email', 50);
            $table->string('logo', 50);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('t_kategori', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('nama', 50);
            $table->integer('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id')->on('t_perusahaan')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('t_supplier', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('nama', 50);
            $table->text('alamat');
            $table->string('tlp', 50);
            $table->string('salesman', 50);
            $table->string('bank', 50);
            $table->string('no_rekening', 50);
            $table->integer('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id')->on('t_perusahaan')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('t_satuan', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('nama', 50);
            $table->integer('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id')->on('t_perusahaan')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('t_merek', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('nama', 50);
            $table->integer('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id')->on('t_perusahaan')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('t_barang', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('kode', 50);
            $table->string('nama', 50);
            $table->string('barcode', 50);
            $table->string('tebal', 50);
            $table->string('panjang', 50);
            $table->integer('id_kategori');
            $table->integer('id_supplier');
            $table->integer('id_satuan');
            $table->integer('id_merek');
            $table->integer('id_perusahaan');
            $table->integer('stock');
            $table->integer('stock_minimal');
            $table->integer('harga_beli');
            $table->integer('keuntungan');
            $table->string('keterangan');
            $table->integer('status');
            $table->foreign('id_supplier')->references('id')->on('t_supplier')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_kategori')->references('id')->on('t_kategori')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_satuan')->references('id')->on('t_satuan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_merek')->references('id')->on('t_merek')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_perusahaan')->references('id')->on('t_perusahaan')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('t_kategori');
        Schema::dropIfExists('t_supplier');
        Schema::dropIfExists('t_merek');
        Schema::dropIfExists('t_satuan');
        Schema::dropIfExists('t_barang');
        Schema::dropIfExists('t_perusahaan');
    }
};
