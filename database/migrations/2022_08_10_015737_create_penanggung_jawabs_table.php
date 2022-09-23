<?php

use App\Models\SubKegiatan;
use App\Models\UserPenanggunJawab;
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
        Schema::create('penanggung_jawabs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SubKegiatan::class);
            $table->foreignIdFor(UserPenanggunJawab::class);
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
        Schema::dropIfExists('penanggung_jawabs');
    }
};
