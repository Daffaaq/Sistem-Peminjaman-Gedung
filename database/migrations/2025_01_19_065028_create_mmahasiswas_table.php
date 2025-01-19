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
        Schema::create('mmahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('NamaMahasiswa');
            $table->string('NIM');
            $table->unsignedBigInteger('ProdiID');
            $table->string('EmailMahasiswa');
            $table->string('AlamatMahasiswa');
            $table->string('NoTelpMahasiswa');
            $table->timestamps();

            $table->foreign('ProdiID')->references('id')->on('mprodis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mmahasiswas');
    }
};
