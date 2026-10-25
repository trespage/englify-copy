<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesanAdmin extends Model
{
    protected $table = 'pesan_admin';

    protected $fillable = [
        'id_user',
        'id_admin',
        'pesan',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }
}
