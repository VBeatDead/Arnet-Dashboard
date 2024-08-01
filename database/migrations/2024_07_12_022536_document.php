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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('type_id');
            $table->string('brand')->nullable();
            $table->string('serial');
            $table->unsignedBigInteger('first_sto_id');
            $table->unsignedBigInteger('last_sto_id');
            $table->string('evidence');
            $table->string('ba');
            $table->string('status');
            $table->string('additional')->nullable();
            $table->timestamps();

            $table->foreign('first_sto_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->foreign('last_sto_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('dropdowns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
