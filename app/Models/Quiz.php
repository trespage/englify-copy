<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';
    protected $primaryKey = 'id_quiz';

    protected $fillable = [
        'id_materi',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'kunci_jawaban',
        'poin',
    ];

    // Relasi ke Materi
    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi');
    }

    // Relasi ke Hasil Quiz (BARU)
    public function hasilQuiz()
    {
        return $this->hasMany(HasilQuiz::class, 'id_quiz');
    }
}   
