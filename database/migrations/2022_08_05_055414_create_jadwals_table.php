<?php

use App\Models\Bulan;
use App\Models\SubKegiatan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SubKegiatan::class);
            $table->foreignIdFor(Bulan::class);
            $table->boolean('pelaksanaan');
            $table->bigInteger('target_kegiatan')->nullable();
            $table->bigInteger('kegiatan_bulan_sebelumnya')->nullable();
            $table->bigInteger('kegiatan_bulan_sekarang')->nullable();
            $table->bigInteger('target_keuangan')->nullable();
            $table->bigInteger('keuangan_bulan_sebelumnya')->nullable();
            $table->bigInteger('keuangan_bulan_sekarang')->nullable();
            $table->text('kendala')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('jadwals');
    }
};
