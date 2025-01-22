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
        Schema::create('mprodis', function (Blueprint $table) {
            $table->id();
            $table->string('NamaProdi');
            $table->string('KodeProdi');
            $table->string('strata');
            $table->unsignedBigInteger('JurusanProgramID')->nullable()->index();
            $table->unsignedBigInteger('FakultasID')->nullable()->index();
            $table->enum('StatusProdi', ['Active', 'InActive']);
            $table->timestamps();
            
            $table->foreign('JurusanProgramID')->references('id')->on('mjurusanprograms')->onDelete('cascade');
            $table->foreign('FakultasID')->references('id')->on('mfakultas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mprodis');
    }
};
