<!--begin::Alert-->
<div class="container-fluid p-0 mb-5">
    <div class="row g-3">
        @if (isset($pemeriksaan_awal))
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-stethoscope me-2"></i>Pemeriksaan Awal
                        </h5>
                        <p
                            class="card-text {{ $pemeriksaan_awal->kriteria_satu == 'ya' && $pemeriksaan_awal->kriteria_dua == 'ya' ? 'text-danger' : ($pemeriksaan_awal->kriteria_satu == 'ya' || $pemeriksaan_awal->kriteria_dua == 'ya' ? 'text-warning' : 'text-success') }} fw-bold">
                            {{ $pemeriksaan_awal->interpretasi }} / {{ ucwords($pemeriksaan_awal->tindakan) }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if (isset($examination->service_category))
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-clipboard-list me-2"></i>Jenis Pemeriksaan
                        </h5>
                        <p class="card-text">{{ $examination->service_category->name }}</p>
                        <div class="row g-2">
                            @foreach (service_examination($examination->id) as $service)
                                <div class="col-md-4">
                                    <span class="badge bg-light text-dark">{{ $service->service->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-heartbeat me-2"></i>Vital Sign & BMI
                    </h5>
                    <div class="row g-3">
                        <div class="col-12">
                            @php
                                $vitalData = [
                                    [
                                        'label' => 'Weight',
                                        'value' => $examination->vitality->weight ?? '-',
                                        'unit' => 'Kg',
                                    ],
                                    [
                                        'label' => 'Height',
                                        'value' => $examination->vitality->height ?? '-',
                                        'unit' => 'cm',
                                    ],
                                    [
                                        'label' => 'Body Mass Index',
                                        'value' => $examination->vitality->body_mass_index ?? '-',
                                    ],
                                    [
                                        'label' => 'Ideal Weight',
                                        'value' => $examination->vitality->ideal_weight ?? '-',
                                        'unit' => 'Kg',
                                    ],
                                    ['label' => 'Body Fat', 'value' => $examination->vitality->body_fat ?? '-'],
                                    [
                                        'label' => 'BMI Conclusion',
                                        'value' => $examination->vitality->bmi_conclusion ?? '-',
                                    ],
                                    [
                                        'label' => 'Arm Circumference',
                                        'value' => $examination->vitality->arm_circumference ?? '-',
                                    ],
                                    [
                                        'label' => 'Abdominal Circumference',
                                        'value' => $examination->vitality->adbdominal_circumference ?? '-',
                                    ],
                                ];
                            @endphp
                            @foreach ($vitalData as $data)
                                <div class="row mb-2">
                                    <div class="col-6">{{ $data['label'] }}</div>
                                    <div class="col-6 fw-bold">: {{ $data['value'] }} {{ $data['unit'] ?? '' }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-12">
                            @php
                                $vitalData2 = [
                                    [
                                        'label' => 'Blood Pressure',
                                        'value' => $examination->vitality->blood_pressure ?? '-',
                                    ],
                                    ['label' => 'Heart Rate', 'value' => $examination->vitality->heart_rate ?? '-'],
                                    [
                                        'label' => 'Respiratory Rate',
                                        'value' => $examination->vitality->respiratory_rate ?? '-',
                                    ],
                                    ['label' => 'Temperature', 'value' => $examination->vitality->temperature ?? '-'],
                                    [
                                        'label' => 'Oxygen Saturation',
                                        'value' => $examination->vitality->oxygen_saturation ?? '-',
                                    ],
                                    [
                                        'label' => 'Waist Circumference',
                                        'value' => $examination->vitality->waist_circumferennce ?? '-',
                                    ],
                                    [
                                        'label' => 'Neck Circumference',
                                        'value' => $examination->vitality->neck_circumference ?? '-',
                                    ],
                                    ['label' => 'Chest Size', 'value' => $examination->vitality->chest_size ?? '-'],
                                ];
                            @endphp
                            @foreach ($vitalData2 as $data)
                                <div class="row mb-2">
                                    <div class="col-6">{{ $data['label'] }}</div>
                                    <div class="col-6 fw-bold">: {{ $data['value'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (isset($examination->vitality->skrining))
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-clipboard-check me-2"></i>Skrining Awal
                        </h5>
                        <div class="row g-3">
                            @php
                                // Parse data skrining menjadi array aman
                                // Menghindari error json_decode ketika input sudah berupa array
                                $rawSkrining = optional($examination->vitality)->skrining;
                                if (is_array($rawSkrining)) {
                                    $skrining = $rawSkrining;
                                } elseif (is_string($rawSkrining)) {
                                    $decoded = json_decode($rawSkrining, true);
                                    $skrining = is_array($decoded) ? $decoded : [];
                                } else {
                                    $skrining = [];
                                }

                                // Log: tipe data dan jumlah item setelah parsing
                                \Log::debug('View _alert skrining parsed', [
                                    'type' => is_array($rawSkrining) ? 'array' : gettype($rawSkrining),
                                    'items' => is_array($skrining) ? count($skrining) : 0,
                                ]);
                            @endphp
                            @foreach ($skrining as $key => $value)
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                                        <div class="col-6 fw-bold">: {{ $value }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (isset($examination->psikososial))
            @php $psikososial = json_decode($examination->psikososial,true); @endphp

            @if (isset($psikososial['riwayat_kesehatan']))
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-history me-2"></i>Riwayat Kesehatan
                            </h5>
                            <div class="row g-3">
                                @php $riwayat_kesehatan = $psikososial['riwayat_kesehatan']; @endphp
                                @if (is_array($riwayat_kesehatan))
                                    @foreach ($riwayat_kesehatan as $key => $value)
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                                                <div class="col-6 fw-bold">
                                                    @if ($key == 'alergi_obat' && $value == 'Ada')
                                                        : {{ $psikososial['riwayat_alergi_obat'] }}
                                                    @elseif($key == 'alergi_makanan' && $value == 'Ada')
                                                        : {{ $psikososial['riwayat_alergi_makanan'] }}
                                                    @elseif($key == 'penyakit_dahulu')
                                                        @if (is_array($value))
                                                            :
                                                            {{ implode(', ',array_map(function ($item) {return getPenyakitdahulu($item)->name;}, $value)) }}
                                                        @else
                                                            : {{ getPenyakitdahulu($value)?->name ?? 'N/A' }}
                                                        @endif
                                                    @elseif($key == 'penyakit_keluarga')
                                                        @if (is_array($value))
                                                            :
                                                            @php
                                                                $penyakitList = [];
                                                                if (is_array($value)) {
                                                                    $penyakitList = array_filter(array_map(function ($item) {
                                                                        $p = getPenyakitKeluarga($item);
                                                                        return data_get($p, 'name');
                                                                    }, $value));
                                                                }
                                                            @endphp
                                                            {{ !empty($penyakitList) ? implode(', ', $penyakitList) : '-' }}
                                                        @else
                                                            : {{ getPenyakitKeluarga($value)?->name ?? 'N/A' }}
                                                        @endif
                                                    @else
                                                        : {{ $value }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <p>{{ $riwayat_kesehatan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-pills me-2"></i>Riwayat Pengobatan
                    </h5>
                    <div class="row g-3">
                        <div class="col-12">
                            {{--
                                Riwayat Pengobatan (Sederhana)
                                - Tampilkan hanya daftar nama obat yang PERNAH diresepkan SEBELUMNYA
                                  dari semua pemeriksaan dengan patient_id yang sama dan status = 'done'.
                                - Eksklusi pemeriksaan saat ini (sebelumnya = id != current id).
                                - Sumber data:
                                  1) Resep baru: \App\Models\Klinik\Examination -> prescriptions -> items -> drug
                                  2) Data legacy: field JSON $exam->resep (key 'obat' berisi id obat)
                                - Dedup dan sort agar nama obat unik dan rapi.
                                - Logging jumlah item untuk audit.
                            --}}
                            @php
                                // Deteksi variabel pemeriksaan yang tersedia
                                $current = $examination ?? ($exam ?? null);

                                $drugNames = collect();
                                try {
                                    // 1) Ambil patient_id terlebih dahulu
                                    $patientId = $current->patient_id ?? null;
                                    $currentId = $current->id ?? null;

                                    // 2) Ambil semua examination berdasarkan patient_id yang berstatus 'done'
                                    $examsDone = collect();
                                    if ($patientId) {
                                        $examsDone = \App\Models\Klinik\Examination::with(['prescriptions.items.drug'])
                                            ->where('patient_id', $patientId)
                                            ->where('status', 'done')
                                            ->when($currentId, function ($q) use ($currentId) {
                                                return $q->where('id', '!=', $currentId);
                                            })
                                            ->orderByDesc('examination_date')
                                            ->get();
                                    }

                                    // 3) Kumpulkan riwayat nama obat dari semua pemeriksaan tersebut
                                    foreach ($examsDone as $examRow) {
                                        // a. Resep baru: ambil nama dari item
                                        foreach ($examRow->prescriptions as $presc) {
                                            foreach ($presc->items as $item) {
                                                $name = $item->drug_name ?? data_get($item->drug, 'name') ?? $item->kfa_code ?? null;
                                                if (!empty($name)) {
                                                    $drugNames->push($name);
                                                }
                                            }
                                        }

                                        // b. Legacy: $examRow->resep -> daftar id obat
                                        $resepRaw = $examRow->resep ?? null;
                                        $legacy = is_array($resepRaw)
                                            ? (object) $resepRaw
                                            : (is_string($resepRaw)
                                                ? json_decode($resepRaw ?: '{}', false)
                                                : null);
                                        $legacyObat = data_get($legacy, 'obat', []);
                                        if (is_array($legacyObat)) {
                                            foreach ($legacyObat as $oid) {
                                                $drug = function_exists('getObat') ? getObat($oid) : null;
                                                $name = $drug->name ?? null;
                                                if (!empty($name)) {
                                                    $drugNames->push($name);
                                                }
                                            }
                                        }
                                    }

                                    // 4) Dedup dan sort
                                    $drugNames = $drugNames->filter()->unique()->sort()->values();
                                    \Log::info('[Riwayat Pengobatan] Obat unik ditemukan: ' . $drugNames->count() . ' untuk patient_id=' . ($patientId ?? 'null'));
                                } catch (\Throwable $e) {
                                    \Log::warning('[Riwayat Pengobatan] Gagal memuat: ' . $e->getMessage());
                                    $drugNames = collect();
                                }
                            @endphp

                            @if ($drugNames->count())
                                <ul class="list-unstyled mb-0">
                                    @foreach ($drugNames as $name)
                                        <li><i class="fas fa-check-circle me-2 text-success"></i>{{ $name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Tidak ada data riwayat pengobatan</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-capsules me-2"></i>Riwayat Pengobatan (Obat bukan dari Fasyankes Sendiri)
                    </h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <p class="text-muted">Tidak ada data riwayat pengobatan dari luar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Alert-->
