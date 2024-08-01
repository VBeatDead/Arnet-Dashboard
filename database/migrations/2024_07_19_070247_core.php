<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cores', function (Blueprint $table) {
            $table->id();
            $table->string('segment');            
            $table->string('ccount')->nullable()->default(0);
            $table->string('good')->nullable()->default(0);
            $table->string('bad')->nullable()->default(0);
            $table->string('used')->nullable()->default(0);
            $table->string('total')->nullable()->default(0);
            $table->timestamps();
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
