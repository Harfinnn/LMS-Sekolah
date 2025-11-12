<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    protected $fillable = ['path', 'alt'];

    public function getUrlAttribute()
    {
        if (!$this->path) return null;
        if (preg_match('#^https?://#', $this->path)) return $this->path;
        return Storage::url($this->path);
    }

    protected static function booted()
    {
        static::deleting(function ($model) {
            if ($model->path && !preg_match('#^https?://#', $model->path)) {
                Storage::disk(config('filesystems.default'))->delete($model->path);
            }
        });
    }
}
