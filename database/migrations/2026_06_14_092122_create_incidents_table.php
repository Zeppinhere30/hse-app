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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('kode_laporan')->unique();
            
            // Relasi ke tabel users (pelapor)
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            
            // Relasi ke tabel areas dan categories
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            // Detail Laporan
            $table->dateTime('tanggal_kejadian');
            $table->string('lokasi_spesifik');
            $table->text('deskripsi_temuan');
            $table->enum('tingkat_keparahan', ['Rendah', 'Sedang', 'Tinggi', 'Kritis']);
            $table->enum('status', ['Baru', 'Dalam Peninjauan', 'Sedang Diperbaiki', 'Menunggu Validasi', 'Selesai'])->default('Baru');
            
            // Relasi ke tabel users (untuk supervisor yang ditugaskan)
            $table->foreignId('penanggung_jawab_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
