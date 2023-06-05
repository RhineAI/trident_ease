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
        Schema::create('t_users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('nama', 50);
            $table->text('alamat')->nullable();
            $table->string('tlp', 20);
            $table->enum('jenis_kelamin', ['L', 'P', 'Other']);
            $table->string('username', 100)->unique();
            $table->string('password');
            $table->string('hak_akses')->comment('1:Super Admin, 2:Owner, 3:Admin, 4:Cashier');
            $table->integer('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id')->on('t_perusahaan')->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('t_users');
    }
};
