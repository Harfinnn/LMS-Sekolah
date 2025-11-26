<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nis',
        'kelas',
        'sub_kelas',
        'phone',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'alamat_jalan',
        'rt',
        'rw',
        'kode_pos',
        'kampung',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::deleting(function ($siswa) {
            if ($siswa->user) {
                $siswa->user()->delete();
            }
        });
    }
}
