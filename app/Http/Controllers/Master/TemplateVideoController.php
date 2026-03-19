<?php

namespace App\Http\Controllers\Master;

use App\DataTables\Masters\TemplateVideoDataTable;
use App\Models\Master\Kategori;
use App\Models\Master\Jenis;
use App\Models\Master\TemplateVideo;
use App\Http\Requests\Master\StoreTemplateVideoRequest;
use App\Http\Requests\Master\UpdateTemplateVideoRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class TemplateVideoController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    public function index(TemplateVideoDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('masters.read')) {
            abort(403, 'Unauthorized');
        }

        return $dataTable->render('pages.masters.template_video.index');
    }

    public function create()
    {
        $jenis = Jenis::all();
        $kategori = Kategori::all();

        return view('pages.masters.template_video.create', compact('jenis', 'kategori'));
    }

    public function store(StoreTemplateVideoRequest $request)
    {
        $data = $request->validated();

        // AUTO SLUG (ANTI DUPLIKAT)
        $slug = Str::slug($data['nama_template']);
        $count = TemplateVideo::where('slug', 'LIKE', "{$slug}%")->count();
        $data['slug'] = $count ? $slug . '-' . $count : $slug;

        // UPLOAD IMAGE
        if ($request->hasFile('preview_image')) {
            $data['preview_image'] = $request->file('preview_image')
                ->store('template_video/image', 'public');
        }

        // UPLOAD VIDEO
        if ($request->hasFile('preview_video')) {
            $data['preview_video'] = $request->file('preview_video')
                ->store('template_video/video', 'public');
        }

        // DEFAULT HARGA
        $data['harga'] = $data['harga'] ?? 0;

        TemplateVideo::create($data);

        return redirect()
            ->route('template_video.index')
            ->with('success', 'Template Video berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = TemplateVideo::findOrFail($id);
        $jenis = Jenis::all();
        $kategori = Kategori::all();

        return view('pages.masters.template_video.edit', compact('data', 'jenis', 'kategori'));
    }

    public function update(UpdateTemplateVideoRequest $request, $id)
    {
        $data = TemplateVideo::findOrFail($id);
        $input = $request->validated();

        if ($request->hasFile('preview_image')) {
            $input['preview_image'] = $request->file('preview_image')->store('template_video', 'public');
        }

        if ($request->hasFile('preview_video')) {
            $input['preview_video'] = $request->file('preview_video')->store('template_video', 'public');
        }

        $data->update($input);

        return redirect()->route('template_video.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = TemplateVideo::findOrFail($id);
        $data->delete();

        return redirect()->route('template_video.index')->with('success', 'Data berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $data = TemplateVideo::findOrFail($id);

        $data->status = $data->status == 'aktif' ? 'nonaktif' : 'aktif';
        $data->save();

        return response()->json([
            'status' => $data->status
        ]);
    }
}