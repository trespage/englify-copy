<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    // Relasi ke Bab
    public function babs()
    {
        return $this->hasMany(Bab::class, 'id_kategori', 'id_kategori')->orderBy('urutan');
    }

    // Relasi ke Materi
    public function materi()
    {
        return $this->hasMany(Materi::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Konfigurasi warna identitas tiap kategori:
     * - Speaking: Merah (Rose / Red)
     * - Writing: Biru (Blue)
     * - Reading: Hijau (Emerald)
     * - Listening: Ungu (Purple)
     */
    public function getColorAttribute(): array
    {
        return match(strtolower($this->nama_kategori)) {
            'speaking' => [
                'name'     => 'red',
                'badge'    => 'bg-rose-50 text-rose-600 border-rose-200',
                'text'     => 'text-rose-600',
                'border'   => 'border-rose-500',
                'bg'       => 'bg-rose-500',
                'bg_light' => 'bg-rose-50',
                'gradient' => 'from-rose-500 to-red-600',
                'ring'     => 'ring-rose-500',
            ],
            'writing' => [
                'name'     => 'blue',
                'badge'    => 'bg-blue-50 text-blue-600 border-blue-200',
                'text'     => 'text-blue-600',
                'border'   => 'border-blue-500',
                'bg'       => 'bg-blue-500',
                'bg_light' => 'bg-blue-50',
                'gradient' => 'from-blue-500 to-indigo-600',
                'ring'     => 'ring-blue-500',
            ],
            'reading' => [
                'name'     => 'emerald',
                'badge'    => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                'text'     => 'text-emerald-600',
                'border'   => 'border-emerald-500',
                'bg'       => 'bg-emerald-500',
                'bg_light' => 'bg-emerald-50',
                'gradient' => 'from-emerald-500 to-teal-600',
                'ring'     => 'ring-emerald-500',
            ],
            'listening' => [
                'name'     => 'purple',
                'badge'    => 'bg-purple-50 text-purple-600 border-purple-200',
                'text'     => 'text-purple-600',
                'border'   => 'border-purple-500',
                'bg'       => 'bg-purple-500',
                'bg_light' => 'bg-purple-50',
                'gradient' => 'from-purple-500 to-violet-600',
                'ring'     => 'ring-purple-500',
            ],
            default => [
                'name'     => 'slate',
                'badge'    => 'bg-slate-50 text-slate-600 border-slate-200',
                'text'     => 'text-slate-600',
                'border'   => 'border-slate-500',
                'bg'       => 'bg-slate-500',
                'bg_light' => 'bg-slate-50',
                'gradient' => 'from-slate-500 to-slate-700',
                'ring'     => 'ring-slate-500',
            ]
        };
    }
}
