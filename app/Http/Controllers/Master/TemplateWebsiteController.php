<?php

namespace App\Http\Controllers\Master;

use App\DataTables\Masters\TemplateWebsiteDataTable;
use App\Models\Master\Kategori;
use App\Models\Master\Jenis;
use App\Models\Master\Template;
use App\Http\Requests\Master\StoreTemplateWebsiteRequest;
use App\Http\Requests\Master\UpdateTemplateWebsiteRequest;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

// Call zip
use ZipArchive;


class TemplateWebsiteController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TemplateWebsiteDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('masters.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.masters.template_web.index');
    }
    
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            abort(403);
        }

        $kategori = Kategori::where('jenis_id', 3)->get();

        return view('pages.masters.template_web.create', compact('kategori'));
    }

    public function store(StoreTemplateWebsiteRequest $request)
    {
        $imagePath = null;

        // Upload image
        if ($request->hasFile('preview_image')) {
            $imagePath = $request->file('preview_image')
                ->store('templates', 'public');
        }

        // Upload template file
        $templatePath = null;

        if ($request->hasFile('template_file')) {

            $templatePath = $request->file('template_file')
                ->store('template_source', 'public');
        }

        $templateFolder = null;

        if ($request->hasFile('template_file')) {

            $file = $request->file('template_file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = $originalName.'.zip';
            $file->storeAs('template_source', $fileName, 'public');
            $zipPath = storage_path('app/public/template_source/'.$fileName);
            $folderName = pathinfo($fileName, PATHINFO_FILENAME);
            $extractPath = public_path('templates/'.$folderName);

            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0777, true);
            }

            $zip = new ZipArchive;

            if ($zip->open($zipPath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();
            }
        }

        // Generate unique slug
        $baseSlug = Str::slug($request->nama_template);
        $slug = $baseSlug;
        $counter = 1;

        while (Template::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        Template::create([
            'nama_template' => $request->nama_template,
            'slug'          => $slug,
            'jenis_id'      => 3, // FIXED WEBSITE
            'kategori_id'   => $request->kategori_id,
            'preview_image' => $imagePath, 
            'template_file' => $templatePath,
            'is_premium'    => $request->boolean('is_premium'),
            'harga'         => $request->boolean('is_premium') ? $request->harga : 0,
            'status'        => 'aktif',
        ]);

        return redirect()
            ->route('template_web.index')
            ->with('success', 'Template berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $template = Template::findOrFail($id);
        $template->delete();

        return back()->with('success', 'Template berhasil dihapus');
    }
}
