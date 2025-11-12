<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationImage extends Model
{
    use HasFactory;

    protected $table = 'information';
    protected $fillable = ['judul', 'deskripsi', 'gambar', 'link'];
}
