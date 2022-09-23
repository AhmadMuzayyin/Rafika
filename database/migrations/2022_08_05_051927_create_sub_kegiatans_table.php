<?php

use App\Models\Pak;
use App\Models\User;
use App\Models\Pengadaan;
use App\Models\SumberDana;
use App\Models\Pelaksanaan;
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
        Schema::create('sub_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Pak::class);
            $table->foreignIdFor(SumberDana::class);
            $table->foreignIdFor(Pengadaan::class);
            $table->foreignIdFor(Pelaksanaan::class);
            $table->integer('rekening');
            $table->string('nama_sub_kegiatan');
            $table->string('bentuk_kegiatan');
            $table->boolean('dau')->nullable();
            $table->boolean('dak')->nullable();
            $table->boolean('dbhc')->nullable();
            $table->enum('program_bupati', ['Ya', 'Tidak']);
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
        Schema::dropIfExists('sub_kegiatans');
    }
};
