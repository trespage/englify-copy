<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';
    protected $primaryKey = 'id_materi';

    protected $fillable = [
        'id_kategori',
        'id_admin',
        'judul',
        'bab',
        'urutan',
        'status',
        'deskripsi',
        'isi_materi',
        'audio_url',
        'transcript',
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // Relasi ke Admin yang membuat
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }

    // Relasi ke Quiz (BARU)
    public function quiz()
    {
        return $this->hasMany(Quiz::class, 'id_materi');
    }

    // Relasi ke Progress Materi (BARU)
    public function progressMateri()
    {
        return $this->hasMany(ProgressMateri::class, 'id_materi');
    }
}
