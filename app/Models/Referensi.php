<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referensi extends Model
{
    protected $table = 'referensi';
    protected $primaryKey = 'id_referensi';
    public $timestamps = true;

    protected $fillable = ['id_materi', 'judul_referensi', 'url', 'deskripsi'];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi', 'id_materi');
    }
}
