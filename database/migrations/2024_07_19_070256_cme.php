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
        Schema::create('cmes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sto_id');
            $table->unsignedBigInteger('type_id');
            $table->string('count')->nullable()->default(0);
            $table->string('underfive')->nullable()->default(0);       
            $table->string('morethanfive')->nullable()->default(0);       
            $table->string('morethanten')->nullable()->default(0);       
            $table->string('grandtotal')->nullable()->default(0);     
            // $table->string('year')->nullable()->default(0);            
            $table->timestamps();

            $table->foreign('sto_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('dropdowns')->onDelete('cascade');
            
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
