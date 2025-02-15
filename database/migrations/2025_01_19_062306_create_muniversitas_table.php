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
        Schema::create('muniversitas', function (Blueprint $table) {
            $table->id();
            $table->string('NamaUniversitas');
            $table->string('KodeUniversitas');
            $table->string('AlamatUniversitas');
            $table->string('NoTelpUniversitas');
            $table->string('EmailUniversitas');
            $table->enum('StatusUniversitas', ['Active', 'InActive']);
            $table->enum('TipeInstitusi', ['Universitas', 'Politeknik']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muniversitas');
    }
};
