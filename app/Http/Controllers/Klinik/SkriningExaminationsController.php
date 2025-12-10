<?php

namespace App\Http\Controllers\Klinik;

use Illuminate\View\View;
use App\DataTables\Klinik\SkriningExaminationsDataTable;
use App\Models\Klinik\SkriningExamination;
use App\Models\Klinik\SkriningExaminationType;
use App\Models\Klinik\SkriningExaminationLocation;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SkriningExaminationsExport;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Gender;
// use App\Http\Requests\Klinik\StoreReligionRequest;
// use App\Http\Requests\Klinik\UpdateReligionRequest;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SkriningExaminationsController extends Controller
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
    public function index(SkriningExaminationsDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        // Ambil data lokasi untuk dropdown filter
        $locations = SkriningExaminationLocation::select('id', 'name')->get();

        return $dataTable->render('pages.klinik.skriningexaminations.index', compact('locations'));
        // // ambil semua data tanpa relasi gender
        // $data = \App\Models\Master\SkriningExamination::all();

        // // return JSON ke browser
        // return response()->json($data);
    }

    // public function filter(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'location_id' => 'required',
    //         'examination_date' => 'required|date',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $validator->errors()->first(),
    //             'data'    => []
    //         ], 422);
    //     }

    //     $data = SkriningExamination::with(['gender', 'location'])
    //         ->where('location_id', $request->location_id)
    //         ->whereDate('examination_date', $request->examination_date)
    //         ->get();

    //     return response()->json([
    //         'success' => true,
    //         'data' => $data
    //     ]);
    // }

    public function filter(Request $request)
    {
        $query = SkriningExamination::with(['location', 'gender']);

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('examination_date')) {
            $query->whereDate('examination_date', $request->examination_date);
        }

        $data = $query->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function export(Request $request)
    {
        $locationId = $request->get('location');
        $date       = $request->get('date');

        return Excel::download(
            new SkriningExaminationsExport($locationId, $date),
            'skrining_examinations.xlsx'
        );
    }

    public function show(SkriningExamination $skriningexamination)
    {
        return redirect()->route('skriningexaminations.detail', $skriningexamination->id);
    }

    public function edit($id)
    {
        $info = SkriningExamination::findOrFail($id);
        $genders = Gender::all();
        $locations = SkriningExaminationLocation::all();

        return view('pages.klinik.skriningexaminations.edit', compact('info', 'genders','locations'));
    }

    public function update(Request $request, $id)
    {
        // Validasi dasar
        $validator = Validator::make($request->all(), [
            'first_name'           => 'required|string|max:255',
            'last_name'            => 'required|string|max:255',
            'date_of_birth'        => 'required|date',
            'gender_id'            => 'required|exists:genders,id',
            'location_id'          => 'required|string|max:255',
            'examination_date'     => 'required|date',
            'card_type'            => 'required|in:ktp,bpjs',
            'nik_bpjs'             => 'nullable|string|max:20', // sekarang nullable
            'phone'                => 'nullable|string|max:20',
            'address'              => 'nullable|string|max:255',
            'hasil'                => 'nullable|string',
            'keterangan'           => 'nullable|string',
        ]);

        // Validasi panjang, tapi skip jika nilainya "-"
        $validator->after(function ($validator) use ($request) {
            $nik = $request->nik_bpjs;

            // Jika nik = "-" → lewati semua validasi panjang
            if ($nik === '-' || $nik === null || $nik === '') {
                return;
            }

            if ($request->card_type === 'ktp' && strlen($nik) < 16) {
                $validator->errors()->add('nik_bpjs', 'No. NIK harus minimal 16 digit.');
            }

            if ($request->card_type === 'bpjs' && strlen($nik) < 10) {
                $validator->errors()->add('nik_bpjs', 'No. BPJS harus minimal 10 digit.');
            }
        });

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // Jika nik kosong atau "-" → tetap jadikan "-"
        $validated['nik_bpjs'] = $validated['nik_bpjs'] ?: '-';

        // Hitung usia
        $validated['age'] = Carbon::parse($validated['date_of_birth'])->age;

        // Update data
        $skrining = SkriningExamination::findOrFail($id);
        $skrining->update($validated);

        return redirect()->route('skriningexaminations.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function create()
    {
        $genders = Gender::all();
        $locations = SkriningExaminationLocation::all();
        $examinations = SkriningExaminationType::all();

        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        return view('pages.klinik.skriningexaminations.create', compact('genders', 'examinations', 'locations'));
    }

    public function store(Request $request)
    {
        // Validasi awal tanpa aturan panjang nik_bpjs
        $validator = Validator::make($request->all(), [
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'date_of_birth'    => 'required|date',
            'gender_id'        => 'required|exists:genders,id',
            'location_id'      => 'required|string|max:255',
            'examination_date' => 'required|date',
            'card_type'        => 'required|in:ktp,bpjs',
            'nik_bpjs'         => 'nullable|string|max:20', // ← berubah
            'phone'            => 'nullable|string|max:20',
            'address'          => 'nullable|string|max:255',
        ]);

        // Validasi panjang nik_bpjs tergantung card_type
        $validator->after(function ($validator) use ($request) {
            $nik = $request->nik_bpjs;

            if ($request->card_type === 'ktp' && $nik && strlen($nik) < 16) {
                $validator->errors()->add('nik_bpjs', 'No. NIK harus minimal 16 digit.');
            }

            if ($request->card_type === 'bpjs' && $nik && strlen($nik) < 10) {
                $validator->errors()->add('nik_bpjs', 'No. BPJS harus minimal 10 digit.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // Jika nik_bpjs kosong → jadikan "-"
        $validated['nik_bpjs'] = $validated['nik_bpjs'] ?: '-';

        // Hitung usia
        $validated['age'] = Carbon::parse($validated['date_of_birth'])->age;

        // Generate examination_id
        $lastExaminationId           = SkriningExamination::max('examination_id') ?? 0;
        $validated['examination_id'] = $lastExaminationId + 1;

        // Simpan data
        SkriningExamination::create($validated);

        return redirect()->route('skriningexaminations.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SkriningExamination $skriningexamination)
    {
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master data !');
        }

        $skriningexamination->delete();

        session()->flash('success', 'Skrining Examination has been deleted !!');

        return redirect()->route('skriningexaminations.index');
    }

    public function result(Request $request)
    {
        $skrining = SkriningExamination::with(['gender', 'location'])->findOrFail($request->id);

        // Ambil semua tipe dengan key id
        $types = SkriningExaminationType::all()->keyBy('id');

        $result = [];

        if (!empty($skrining->hasil)) {
            $decoded = json_decode($skrining->hasil, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                abort(500, 'Format data hasil tidak valid.');
            }

            foreach ($decoded as $item) {
                $type = $types[$item['id']] ?? null;

                if ($type) {
                    $result[] = (object) [
                        'id'           => $item['id'],
                        'ItemName'     => $type->name,
                        'hasil'        => $item['hasil'] ?? '',
                        'nilai_normal' => $type->nilai_normal ?? '-',
                        'satuan'       => $item['satuan'],
                        'keterangan'   => $item['keterangan'] ?? '',
                        'deskripsi'   => $item['deskripsi'] ?? '',
                    ];
                }
            }
        }

        return view('pages.klinik.skriningexaminations.result', compact('skrining', 'result', 'types'));
    }

    public function resultUpdate(Request $request, SkriningExamination $skriningexaminations)
    {
        $skrining = SkriningExamination::findOrFail($request->skriningexaminations);

        $result = [];
        if ($request->id[0]) {
            $jumlah = 0;
            foreach ($request->id as $key => $value) {
                if ($request->id[$key] != null) {
                    $jumlah++;
                }
            }

            for ($i = 0; $i < $jumlah; $i++) {
                $item = SkriningExaminationType::find($request->id[$i]);

                $data_ = [
                    "id"           => $request->id[$i],
                    "ItemName"     => $item->name,
                    "hasil"        => $request->hasil[$i],
                    "satuan"       => $request->satuan[$i],
                    "keterangan"   => $request->keterangan[$i],
                    "nilai_normal" => $item->nilai_normal,
                ];

                $result[] = $data_;
            }

            $skrining->hasil = json_encode($result);
        } else {
            $skrining->hasil = null;
        }

        $skrining->deskripsi = $request->deskripsi;

        $skrining->save();

        return redirect()->route('skriningexaminations.result', ["id" => $skrining->id]);
    }

    public function download(Request $request)
    {
        $id = $request->id;
        $skrining = SkriningExamination::with('gender', 'location')->findOrFail($id);
        $result = [];

        // Cek jika hasilnya ada dan valid
        if (!empty($skrining->hasil)) {
            // Decode langsung ke array
            $result = json_decode($skrining->hasil, true);
        }

        $deskripsi = $skrining->deskripsi ?? null;

        $pdf = Pdf::loadView('pages.klinik.skriningexaminations.pdf', [
            'skrining' => $skrining,
            'result' => $result, // Pastikan ini array
            'deskripsi' => $deskripsi
        ])->setPaper('a4');

        Storage::put("public/skrining/{$skrining->id}/hasil-skrining.pdf", $pdf->output());

        return $pdf->download("skrining-examination.pdf");
    }
}
