<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'user_id', 'mata_pelajaran', 'phone',
        'provinsi','kabupaten','kecamatan','kelurahan',
        'alamat_jalan','rt','rw','kode_pos','kampung'
    ];
    

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::deleting(function ($guru) {
            $guru->user()->delete(); // hapus user terkait
        });
    }
}
