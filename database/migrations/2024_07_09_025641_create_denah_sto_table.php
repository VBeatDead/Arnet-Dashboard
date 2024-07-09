<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenahStoTable extends Migration
{
    public function up()
    {
        Schema::create('denah_sto', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi_sto'); // Menambahkan kolom lokasi_sto
            $table->binary('denah');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('denah_sto');
    }
}
