<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Template;

class DemoController extends Controller
{   
    public function show($slug)
    {
        $template = Template::where('slug', $slug)
            ->where('status', 'aktif')
            ->firstOrFail();

        // ambil folder dari database
        $folder = $template->template_folder;

        $path = public_path('templates/' . $folder . '/index.html');

        // cek file ada atau tidak
        if (!file_exists($path)) {
            abort(404, 'Template tidak ditemukan.');
        }

        return redirect('templates/' . $folder . '/index.html');
    }
}
