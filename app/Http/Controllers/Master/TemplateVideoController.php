<?php

namespace App\Http\Controllers\Master;

use App\DataTables\Masters\TemplateVideoDataTable;
use App\Models\Master\Kategori;
use App\Models\Master\Jenis;
use App\Http\Requests\Master\StoreTemplateVideoRequest;
use App\Http\Requests\Master\UpdateTemplateVideoRequest;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TemplateVideoDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('masters.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.masters.template_video.index');
    }
}
