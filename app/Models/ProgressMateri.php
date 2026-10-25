<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressMateri extends Model
{
    use HasFactory;

    protected $table = 'progress_materi';
    protected $primaryKey = 'id_progress';

    protected $fillable = [
        'id_user',
        'id_materi',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke Materi
    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi');
    }
}
