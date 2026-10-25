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
        'id_quiz',
        'skor_diperoleh',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke Quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz', 'id_quiz');
    }

    // Relasi ke Jawaban User
    public function jawaban()
    {
        return $this->hasMany(JawabanUser::class, 'id_hasil', 'id_hasil');
    }
}
