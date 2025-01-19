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
        Schema::create('madmins', function (Blueprint $table) {
            $table->id();
            $table->string('NamaAdmin');
            $table->string('EmailAdmin');
            $table->string('NotelpAdmin');
            $table->unsignedBigInteger('GedungID');
            $table->timestamps();

            $table->foreign('GedungID')->references('id')->on('mgedungs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('madmins');
    }
};
