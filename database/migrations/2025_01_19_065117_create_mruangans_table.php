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
        Schema::create('mruangans', function (Blueprint $table) {
            $table->id();
            $table->string('NamaRuang');
            $table->string('KodeRuang');
            $table->Integer('KapasitasRuang');
            $table->unsignedBigInteger('GedungID');
            $table->enum('StatusRuang', ['Active', 'InActive']);
            $table->enum('StatusBooked', ['Booked', 'Available']);
            $table->text('Keterangan')->nullable();
            $table->timestamps();

            $table->foreign('GedungID')->references('id')->on('mgedungs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mruangans');
    }
};
