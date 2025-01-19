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
        Schema::create('mdosens', function (Blueprint $table) {
            $table->id();
            $table->string('NamaDosen');
            $table->string('EmailDosen');
            $table->string('NoTelpDosen');
            $table->unsignedBigInteger('ProdiID');
            $table->timestamps();

            $table->foreign('ProdiID')->references('id')->on('mprodis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mdosens');
    }
};
