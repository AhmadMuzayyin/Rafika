<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->enum('kode_skpd', ['1', '2', '3', '4', '5']);
            $table->text('nama_skpd');
            $table->string('nomor_tlp_kantor');
            $table->text('alamat_kantor');
            $table->string('nama_operator');
            $table->string('nomor_tlp_operator');
            $table->text('alamat_operator');
            $table->string('nama_kpa');
            $table->string('images');
            $table->boolean('isAdmin');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
