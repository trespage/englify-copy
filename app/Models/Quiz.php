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
        'id_bab',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'audio',
        'audio_title',
        'audio_petunjuk',
        'kunci_jawaban',
        'poin',
        'status',
        'urutan',
    ];

    protected $appends = [
        'audio_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Resolusi URL Audio yang fleksibel
     */
    public function getAudioUrlAttribute(): ?string
    {
        if (empty($this->audio)) {
            return null;
        }

        if (str_starts_with($this->audio, 'http://') || str_starts_with($this->audio, 'https://')) {
            return $this->audio;
        }

        if (str_starts_with($this->audio, 'quiz_audio/')) {
            return asset($this->audio);
        }

        if (str_starts_with($this->audio, 'storage/')) {
            return asset($this->audio);
        }

        return asset('quiz_audio/' . ltrim($this->audio, '/'));
    }

    // Relasi ke Materi
    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi');
    }

    // Relasi ke Bab
    public function bab()
    {
        return $this->belongsTo(Bab::class, 'id_bab', 'id');
    }

    // Relasi ke Hasil Quiz
    public function hasilQuiz()
    {
        return $this->hasMany(HasilQuiz::class, 'id_quiz', 'id_quiz');
    }

    /**
     * Scope soal quiz yang aktif dan dapat dilihat siswa:
     * 1. Status quiz harus Aktif atau Published (bukan Draft / Nonaktif)
     * 2. Jika terhubung ke materi: materi harus Published/Aktif DAN bab induknya harus aktif (is_active = true)
     * 3. Jika terhubung langsung ke bab: bab induknya harus aktif (is_active = true)
     */
    public function scopeVisibleForSiswa($query)
    {
        return $query->where(function ($q) {
                $q->whereIn('status', ['Aktif', 'Published'])
                  ->orWhereNull('status');
            })
            ->where(function ($q) {
                $q->where(function ($qm) {
                    $qm->whereNotNull('id_materi')
                       ->whereHas('materi', function ($m) {
                           $m->where(function ($ms) {
                               $ms->whereIn('status', ['Published', 'Aktif'])
                                  ->orWhereNull('status');
                           })->where(function ($mb) {
                               $mb->whereHas('babModel', function ($b) {
                                   $b->where('is_active', true);
                               })->orWhereNull('id_bab');
                           });
                       });
                })->orWhere(function ($qb) {
                    $qb->whereNull('id_materi')
                       ->where(function ($b2) {
                           $b2->whereHas('bab', function ($b) {
                               $b->where('is_active', true);
                           })->orWhereNull('id_bab');
                       });
                });
            });
    }
}
