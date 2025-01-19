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
        Schema::create('penggunaluars', function (Blueprint $table) {
            $table->id();
            $table->string('NamaPenggunaLuar');
            $table->string('EmailPenggunaLuar');
            $table->string('NoTelpPenggunaLuar');
            $table->string('AlamatPenggunaLuar');
            $table->enum('StatusPenggunaLuar', ['Active', 'InActive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunaluars');
    }
};
