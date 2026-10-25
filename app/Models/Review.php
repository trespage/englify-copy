<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'nama',
        'role',
        'rating',
        'pesan',
        'is_approved',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    /**
     * Generate 2-letter initials from name
     */
    public function getInitialsAttribute(): string
    {
        $words = preg_split('/\s+/', trim($this->nama));
        if (empty($words)) {
            return 'U';
        }
        if (count($words) === 1) {
            return strtoupper(substr($words[0], 0, 2));
        }
        return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
    }
}
