<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'order',
        'category',
        'video_url',
        'content',
        'file_path',
        'short_description',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
