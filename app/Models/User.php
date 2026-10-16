<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'nama',
        'email',
        'password',
        'id_role',
        'id_kategori',
        'status',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'must_change_password' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function hasilQuiz()
    {
        return $this->hasMany(HasilQuiz::class, 'id_user');
    }

    public function progressMateri()
    {
        return $this->hasMany(ProgressMateri::class, 'id_user');
    }

    public function materiDibuat()
    {
        return $this->hasMany(Materi::class, 'id_admin');
    }
}
