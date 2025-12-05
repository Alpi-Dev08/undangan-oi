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
                            @php
                                // Ambil seluruh resep pada pemeriksaan ini dengan item dan relasi drug
                                $historyPrescriptions = null;
                                try {
                                    if (isset($examination) && method_exists($examination, 'prescriptions')) {
                                        $historyPrescriptions = $examination->prescriptions()
                                            ->with(['items.drug'])
                                            ->orderByDesc('resep_date')
                                            ->get();
                                    }
                                } catch (\Throwable $e) {
                                    \Log::warning('Gagal memuat riwayat pengobatan: ' . $e->getMessage());
                                    $historyPrescriptions = collect();
                                }
                            @endphp

                            @if ($historyPrescriptions && $historyPrescriptions->count())
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 20%">Tanggal Resep</th>
                                                <th>Nama Obat</th>
                                                <th style="width: 12%">Dosis</th>
                                                <th style="width: 18%">Aturan Pakai</th>
                                                <th style="width: 12%">Jumlah</th>
                                                <th style="width: 18%">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($historyPrescriptions as $presc)
                                                @foreach ($presc->items as $item)
                                                    @php
                                                        $drugName = $item->drug_name ?? data_get($item->drug, 'name') ?? $item->kfa_code;
                                                        $unitDisplay = $item->unit ?: (data_get($item->drug, 'unit.name') ?? 'TAB');
                                                        $qtyDisplay = !empty($item->qty) ? ($item->qty . ' ' . $unitDisplay) : '-';
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $presc->resep_date ? \Carbon\Carbon::parse($presc->resep_date)->format('d/m/Y') : '-' }}</td>
                                                        <td>{{ $drugName }}</td>
                                                        <td>{{ $item->dosis ?: '-' }}</td>
                                                        <td>{{ $item->aturan_pakai ?: '-' }}</td>
                                                        <td>{{ $qtyDisplay }}</td>
                                                        <td>{{ $item->keterangan ?: '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                @php
                                    // Fallback: dukung data lama yang disimpan di $examination->resep
                                    $resepRaw = $examination->resep ?? null;
                                    $resepData = is_array($resepRaw)
                                        ? (object) $resepRaw
                                        : (is_string($resepRaw)
                                            ? json_decode($resepRaw ?: '{}', false)
                                            : null);

                                    $obat = data_get($resepData, 'obat', []);
                                    $keterangan = data_get($resepData, 'keterangan', []);
                                    $qty = data_get($resepData, 'qty', []);
                                @endphp

                                @if (!empty($obat))
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama Obat</th>
                                                    <th style="width: 12%">Dosis</th>
                                                    <th style="width: 18%">Aturan Pakai</th>
                                                    <th style="width: 12%">Jumlah</th>
                                                    <th style="width: 18%">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($obat as $key => $value)
                                                    @php $drug = function_exists('getObat') ? getObat($value) : null; @endphp
                                                    @if ($drug && isset($drug->name))
                                                        @php
                                                            $unitLegacy = $drug->unit->name ?? 'TAB';
                                                            $qtyLegacy = (isset($qty[$key]) && $qty[$key] !== '') ? $qty[$key] : '';
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $drug->name }}</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>{{ $qtyLegacy !== '' ? ($qtyLegacy . ' ' . $unitLegacy) : '-' }}</td>
                                                            <td>{{ isset($keterangan[$key]) && $keterangan[$key] !== '' ? $keterangan[$key] : '-' }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada data riwayat pengobatan</p>
                                @endif
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
