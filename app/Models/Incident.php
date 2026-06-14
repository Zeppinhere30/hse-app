<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    // Relasi ke tabel User (Siapa yang melapor)
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    // Relasi ke tabel Area
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    // Relasi ke tabel Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke tabel User (Siapa supervisor yang ditugaskan)
    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab_id');
    }

    // Relasi ke tabel incident_photos (BARU DITAMBAHKAN)
    public function photos()
    {
        return $this->hasMany(IncidentPhoto::class);
    }

    // Relasi ke tabel incident_comments (BARU DITAMBAHKAN)
    public function comments()
    {
        return $this->hasMany(IncidentComment::class);
    }
}