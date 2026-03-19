<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Template;
use App\Models\Master\TemplateVideo;
use App\Http\Controllers\Controller;

class DemoController extends Controller
{ 
    public function show($slug)
    {
        $template = TemplateVideo::where('slug', $slug)
            ->where('status', 'aktif')
            ->firstOrFail();

        return view('pages.demo.template_video', compact('template'));
    }
}
