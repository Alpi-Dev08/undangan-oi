<div class="card card-custom gutter-b shadow-sm mb-5">
    <div class="card-header bg-light">
        <h3 class="card-title">
            <i class="fas fa-notes-medical text-primary me-2"></i>
            Regular Check-Up Result
        </h3>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3 fw-bold"><i class="fas fa-comment-alt text-info me-2"></i>Subjective</div>
            <div class="col-md-9">: {{ $exam->subjective ?? '-' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 fw-bold"><i class="fas fa-eye text-warning me-2"></i>Objective</div>
            <div class="col-md-9">: {{ $exam->objective ?? '-' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 fw-bold"><i class="fas fa-clipboard-check text-success me-2"></i>Assessment</div>
            <div class="col-md-9">: {{ $exam->assessment ?? '-' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 fw-bold"><i class="fas fa-tasks text-primary me-2"></i>Plan</div>
            <div class="col-md-9">: {{ $exam->plan ? $exam->plan->name : '-' }}</div>
        </div>

        <div class="row">
            <div class="col-md-3 fw-bold"><i class="fas fa-prescription text-danger me-2"></i>Resep</div>
            <div class="col-md-9">
                @php
                    // Coba tampilkan data prescription terbaru bila tersedia, serupa tampilan di PDF
                    $activePrescription = null;
                    try {
                        if (method_exists($exam, 'prescriptions')) {
                            $activePrescription = $exam->prescriptions()
                                ->with(['items.drug'])
                                ->orderByDesc('resep_date')
                                ->first();
                        }
                    } catch (\Throwable $e) {
                        $activePrescription = null;
                    }
                @endphp

                @if ($activePrescription && $activePrescription->items && $activePrescription->items->count())
                    @if ($activePrescription->resep_date || !empty($activePrescription->catatan_umum))
                        <div class="text-muted mb-2">
                            @if ($activePrescription->resep_date)
                                Tanggal Resep: {{ \Carbon\Carbon::parse($activePrescription->resep_date)->format('d/m/Y') }}
                            @endif
                            @if (!empty($activePrescription->catatan_umum))
                                @if ($activePrescription->resep_date) — @endif
                                Catatan: {{ $activePrescription->catatan_umum }}
                            @endif
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Dosis</th>
                                    <th>Aturan Pakai</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activePrescription->items as $item)
                                    <tr>
                                        <td>{{ $item->drug_name ?? data_get($item->drug, 'name') ?? $item->kfa_code }}</td>
                                        <td>{{ $item->dosis ?: '-' }}</td>
                                        <td>{{ $item->aturan_pakai ?: '-' }}</td>
                                        <td>{{ !empty($item->qty) ? ($item->qty . ' ' . ($item->unit ?: '')) : '-' }}</td>
                                        <td>{{ $item->keterangan ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    @php
                        // Fallback: dukung data lama yang disimpan di $exam->resep
                        $resepRaw = $exam->resep ?? null;
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
                                        <th>Dosis</th>
                                        <th>Aturan Pakai</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($obat as $key => $value)
                                        @php $drug = getObat($value); @endphp
                                        @if (isset($drug->name))
                                            <tr>
                                                <td>{{ $drug->name }}</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>{{ isset($qty[$key]) && $qty[$key] !== '' ? $qty[$key] : '-' }}</td>
                                                <td>{{ isset($keterangan[$key]) && $keterangan[$key] !== '' ? $keterangan[$key] : '-' }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        : -
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
