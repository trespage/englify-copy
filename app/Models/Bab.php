<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bab extends Model
{
    protected $table = 'bab';

    protected $fillable = [
        'id_kategori',
        'judul',
        'urutan',
        'durasi_menit',
        'is_active',
    ];

    protected $casts = [
        'durasi_menit' => 'integer',
        'is_active' => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'id_bab', 'id')->orderBy('urutan');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'id_bab', 'id');
    }

    /**
     * Scope hanya bab yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Judul bersih tanpa awalan 'Bab' ganda
     */
    public function getCleanJudulAttribute(): string
    {
        $clean = preg_replace('/^bab\s*(\d+)?\s*[:.-]?\s*/i', '', $this->judul ?? '');
        return trim($clean) !== '' ? trim($clean) : ($this->judul ?? '');
    }

    /**
     * Format tampilan judul dengan nomor Bab (Contoh: Bab 1: Uji Anti Retake)
     */
    public function getFormattedJudulAttribute(): string
    {
        return 'Bab ' . ($this->urutan ?? 1) . ': ' . $this->clean_judul;
    }
}
