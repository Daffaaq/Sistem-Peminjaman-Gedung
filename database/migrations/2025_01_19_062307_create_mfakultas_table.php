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
        Schema::create('mfakultas', function (Blueprint $table) {
            $table->id();
            $table->string('NamaFakultas');
            $table->string('KodeFakultas');
            $table->unsignedBigInteger('UniversitasID')->index();
            $table->enum('StatusFakultas', ['Active', 'InActive']);
            $table->timestamps();
            
            $table->foreign('UniversitasID')->references('id')->on('muniversitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mfakultas');
    }
};
