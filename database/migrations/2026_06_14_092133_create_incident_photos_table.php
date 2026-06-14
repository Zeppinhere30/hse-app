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
        Schema::create('incident_photos', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke laporan utama (jika laporan dihapus, fotonya ikut terhapus dari database)
            $table->foreignId('incident_id')->constrained('incidents')->onDelete('cascade');
            
            // Kolom untuk menyimpan lokasi file gambar di server
            $table->string('file_path');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_photos');
    }
};
