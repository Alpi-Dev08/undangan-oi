<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Template;

class DemoController extends Controller
{   
    public function show($slug)
    {
        $template = Template::where('slug', $slug)
            ->where('status', 'aktif')
            ->firstOrFail();

        $viewPath = 'themes.' . $template->slug . '.index';

        if (!view()->exists($viewPath)) {
            abort(404, 'View template tidak ditemukan.');
        }

        return view($viewPath, compact('template'));
    }
}
