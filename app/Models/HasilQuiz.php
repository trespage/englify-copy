<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilQuiz extends Model
{
    use HasFactory;

    protected $table = 'hasil_quiz';
    protected $primaryKey = 'id_hasil';

    protected $fillable = [
        'id_user',
        'id_materi',
        'skor_total',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke Materi
    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi', 'id_materi');
    }

    // Relasi ke Jawaban User
    public function jawaban()
    {
        return $this->hasMany(JawabanUser::class, 'id_hasil', 'id_hasil');
    }
}
