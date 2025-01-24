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
        Schema::create('mgedungs', function (Blueprint $table) {
            $table->id();
            $table->string('NamaGedung');
            $table->string('KodeGedung');
            $table->Integer('JumlahLantaiGedung')->nullable();
            $table->integer('kapasitasGedung')->nullable();
            $table->unsignedBigInteger('FakultasID')->nullable()->index();
            $table->unsignedBigInteger('JurusanProgramID')->nullable()->index();
            $table->unsignedBigInteger('UniversitasID')->nullable()->index();
            $table->enum('StatusGedung', ['Active', 'InActive']);
            $table->enum('TipeGedung', ['Mandiri', 'Fakultas']);
            $table->text('Keterangan')->nullable();
            $table->enum('statusGedungMandiri', ['Booked', 'Available'])->nullable();
            $table->timestamps();

            $table->foreign('FakultasID')->references('id')->on('mfakultas')->onDelete('cascade');
            $table->foreign('JurusanProgramID')->references('id')->on('mjurusanprograms')->onDelete('cascade');
            $table->foreign('UniversitasID')->references('id')->on('muniversitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mgedungs');
    }
};
