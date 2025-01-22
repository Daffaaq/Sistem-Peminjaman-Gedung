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
        Schema::create('mjurusanprograms', function (Blueprint $table) {
            $table->id();
            $table->string('NamaJurusanPrograms');
            $table->string('KodeJurusanProgram');
            $table->unsignedBigInteger('FakultasID')->index()->nullable();
            $table->unsignedBigInteger('UniversitasID')->index()->nullable();
            $table->enum('StatusJurusanPrograms', ['Active', 'InActive']);
            $table->timestamps();

            $table->foreign('FakultasID')->references('id')->on('mfakultas')->onDelete('cascade');
            $table->foreign('UniversitasID')->references('id')->on('muniversitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mjurusanprograms');
    }
};
