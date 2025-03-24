<!--begin::Alert-->
<div class="container-fluid p-0 mb-5">
    <div class="row g-3">
        @if(isset($pemeriksaan_awal))
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-stethoscope me-2"></i>Pemeriksaan Awal
                        </h5>
                        <p class="card-text {{ $pemeriksaan_awal->kriteria_satu=='ya' && $pemeriksaan_awal->kriteria_dua=='ya' ? 'text-danger' : ($pemeriksaan_awal->kriteria_satu=='ya' || $pemeriksaan_awal->kriteria_dua=='ya' ? 'text-warning' : 'text-success') }} fw-bold">
                            {{ $pemeriksaan_awal->interpretasi }} / {{ ucwords($pemeriksaan_awal->tindakan) }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($examination->service_category))
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-clipboard-list me-2"></i>Jenis Pemeriksaan
                        </h5>
                        <p class="card-text">{{ $examination->service_category->name }}</p>
                        <div class="row g-2">
                            @foreach(service_examination($examination->id) as $service)
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
                                    ['label' => 'Weight', 'value' => $examination->vitality->weight ?? "-", 'unit' => 'Kg'],
                                    ['label' => 'Height', 'value' => $examination->vitality->height ?? "-", 'unit' => 'cm'],
                                    ['label' => 'Body Mass Index', 'value' => $examination->vitality->body_mass_index ?? "-"],
                                    ['label' => 'Ideal Weight', 'value' => $examination->vitality->ideal_weight ?? "-", 'unit' => 'Kg'],
                                    ['label' => 'Body Fat', 'value' => $examination->vitality->body_fat ?? "-"],
                                    ['label' => 'BMI Conclusion', 'value' => $examination->vitality->bmi_conclusion ?? "-"],
                                    ['label' => 'Arm Circumference', 'value' => $examination->vitality->arm_circumference ?? "-"],
                                    ['label' => 'Abdominal Circumference', 'value' => $examination->vitality->adbdominal_circumference ?? "-"],
                                ];
                            @endphp
                            @foreach($vitalData as $data)
                                <div class="row mb-2">
                                    <div class="col-6">{{ $data['label'] }}</div>
                                    <div class="col-6 fw-bold">: {{ $data['value'] }} {{ $data['unit'] ?? '' }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-12">
                            @php
                                $vitalData2 = [
                                    ['label' => 'Blood Pressure', 'value' => $examination->vitality->blood_pressure ?? "-"],
                                    ['label' => 'Heart Rate', 'value' => $examination->vitality->heart_rate ?? "-"],
                                    ['label' => 'Respiratory Rate', 'value' => $examination->vitality->respiratory_rate ?? "-"],
                                    ['label' => 'Temperature', 'value' => $examination->vitality->temperature ?? "-"],
                                    ['label' => 'Oxygen Saturation', 'value' => $examination->vitality->oxygen_saturation ?? "-"],
                                    ['label' => 'Waist Circumference', 'value' => $examination->vitality->waist_circumferennce ?? "-"],
                                    ['label' => 'Neck Circumference', 'value' => $examination->vitality->neck_circumference ?? "-"],
                                    ['label' => 'Chest Size', 'value' => $examination->vitality->chest_size ?? "-"],
                                ];
                            @endphp
                            @foreach($vitalData2 as $data)
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

        @if(isset($examination->vitality->skrining))
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-clipboard-check me-2"></i>Skrining Awal
                        </h5>
                        <div class="row g-3">
                            @php $skrining = json_decode($examination->vitality->skrining); @endphp
                            @foreach($skrining as $key => $value)
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">{{ ucwords(str_replace('_',' ',$key)) }}</div>
                                        <div class="col-6 fw-bold">: {{ $value }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!--end::Alert-->
