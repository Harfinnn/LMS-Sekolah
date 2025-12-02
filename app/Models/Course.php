<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'subject',
        'grade_level',
        'class_group',
        'title',        // kalau memang ada di tabel
        'description',  // kalau kamu pakai
    ];

    public function materials()
    {
        return $this->hasMany(\App\Models\CourseMaterial::class)->orderBy('order');
    }
}
