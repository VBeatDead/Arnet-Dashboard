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
        Schema::create('maps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sto_id');
            $table->unsignedBigInteger('room_id');
            $table->string('file')->nullable();
            $table->string('converted_image')->nullable();
            $table->timestamps();

            $table->foreign('sto_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('dropdowns')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maps');
    }
};
