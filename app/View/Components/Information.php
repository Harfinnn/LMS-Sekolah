<?php

namespace App\View\Components;

use App\Models\InformationImage;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class information extends Component
{
    public $informasi;

    public function __construct()
    {
        $this->informasi = InformationImage::latest()->take(6)->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.information');
    }
}
