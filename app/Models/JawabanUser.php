<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanUser extends Model
{
    use HasFactory;

    protected $table = 'jawaban_user';
    protected $primaryKey = 'id_jawaban';

    protected $fillable = [
        'id_hasil',
        'id_quiz',
        'jawaban_user',
        'benar',
    ];

    protected $casts = [
        'benar' => 'boolean',
    ];

    public function hasil()
    {
        return $this->belongsTo(HasilQuiz::class, 'id_hasil', 'id_hasil');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz');
    }
}
