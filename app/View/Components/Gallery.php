<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\GalleryImage;

class Gallery extends Component
{
    public array $images;

    public function __construct(array $images = [])
    {
        $this->images = $images;
    }

    public function render(): View
    {
        if (empty($this->images)) {
            $models = GalleryImage::orderBy('order')->get();

            $this->images = $models->map(function ($m) {
                return [
                    'url' => $m->url,
                    'title' => $m->title,
                    'alt' => $m->alt,
                    'id' => $m->id,
                ];
            })->toArray();
        } else {
            $this->images = collect($this->images)->map(function ($i) {
                if (is_string($i)) {
                    return ['url' => $i, 'title' => null, 'alt' => null, 'id' => null];
                }
                if (is_array($i)) {
                    return [
                        'url' => $i['url'] ?? $i['path'] ?? $i['path'] ?? null,
                        'title' => $i['title'] ?? null,
                        'alt' => $i['alt'] ?? null,
                        'id' => $i['id'] ?? null,
                    ];
                }
                if (is_object($i) && property_exists($i, 'url')) {
                    return ['url' => $i->url, 'title' => $i->title ?? null, 'alt' => $i->alt ?? null, 'id' => $i->id ?? null];
                }
                return null;
            })->filter()->values()->toArray();
        }

        return view('components.gallery', ['images' => $this->images]);
    }
}
