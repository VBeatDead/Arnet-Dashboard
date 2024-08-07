<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bbm', function (Blueprint $table) {
            $table->id();
            $table->string('Lokasi')->nullable();
            $table->unsignedBigInteger('sto_id');
            $table->integer('BBM_L')->nullable();
            $table->timestamp('UPDATED_AT')->nullable();

            $table->foreign('sto_id')->references('id')->on('dropdowns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
