<div class="tab-pane" id="medicalrecord" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="card-body p-0">
            <div class="timeline-label">
                @foreach($examinations as $exam)
                    <div class="timeline-item mb-5">
                        <!-- Timeline Header -->
                        <div class="timeline-label fw-bold text-gray-800 fs-6">
                            {{ $exam->created_at->format("d F Y") }}<br>{{ $exam->created_at->format("H:i:s") }}
                        </div>

                        <!-- Timeline Badge -->
                        <div class="timeline-badge">
                            <i class="fa fa-genderless text-{{ ['success', 'primary', 'warning', 'danger', 'info', 'dark'][array_rand(['success', 'primary', 'warning', 'danger', 'info', 'dark'])] }} fs-1"></i>
                        </div>

                        <!-- Timeline Content -->
                        <div class="timeline-content text-muted ps-3">
                            <!-- Basic Information -->
                            <div class="card card-custom gutter-b shadow-sm mb-5">
                                <div class="card-header bg-light">
                                    <h3 class="card-title">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        Basic Information
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><i class="fas fa-file-medical text-info me-2"></i> <strong class="w-25 d-inline-block">Medical Record:</strong> {{ $user->mr->medical_record_code }}</p>
                                            <p><i class="fas fa-clipboard-check text-success me-2"></i> <strong class="w-25 d-inline-block">Examination Code:</strong> {{ $exam->examination_code }}</p>
                                            <p><i class="fas fa-user text-primary me-2"></i> <strong class="w-25 d-inline-block">Full Name:</strong> {{ $user->name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><i class="fas fa-user-md text-warning me-2"></i> <strong class="w-25 d-inline-block">Doctor:</strong> {{ $exam->health_profesional->user->name ?? "-" }}</p>
                                            <p><i class="fas fa-stethoscope text-danger me-2"></i> <strong class="w-25 d-inline-block">Pemeriksaan Awal:</strong>
                                                {{ $exam->pemeriksaan_awal ? $exam->pemeriksaan_awal->interpretasi . ' / ' . $exam->pemeriksaan_awal->tindakan : '-' }}
                                            </p>
                                        </div>
                                    </div>

                                    @if(isset($exam->service_category))
                                        <h6 class="mt-3"><i class="fas fa-list-alt text-info me-2"></i> Jenis Pemeriksaan: {{ $exam->service_category->name }}</h6>
                                        <ul class="list-inline">
                                            @foreach(service_examination($exam->id) as $service)
                                                <li class="list-inline-item"><i class="fas fa-check text-success me-2"></i> {{ $service->service->name }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>

                            <!-- Vital Sign & BMI -->
                            <div class="card card-custom gutter-b shadow-sm mb-5">
                                <div class="card-header bg-light">
                                    <h3 class="card-title">
                                        <i class="fas fa-heartbeat text-danger me-2"></i>
                                        Vital Sign & BMI
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Weight, Height, BMI -->
                                        <div class="col-md-4">
                                            @php
                                                $vitalityData = [
                                                    'Weight' => ['value' => $exam->vitality->weight ?? "-", 'unit' => 'Kg', 'icon' => 'fas fa-weight'],
                                                    'Height' => ['value' => $exam->vitality->height ?? "-", 'unit' => 'cm', 'icon' => 'fas fa-ruler-vertical'],
                                                    'Body Mass Index' => ['value' => $exam->vitality->body_mass_index ?? "-", 'unit' => '', 'icon' => 'fas fa-calculator'],
                                                    'Ideal Weight' => ['value' => $exam->vitality->ideal_weight ?? "-", 'unit' => 'Kg', 'icon' => 'fas fa-balance-scale'],
                                                    'Body Fat' => ['value' => $exam->vitality->body_fat ?? "-", 'unit' => '', 'icon' => 'fas fa-percentage'],
                                                    'BMI Conclusion' => ['value' => $exam->vitality->bmi_conclusion ?? "-", 'unit' => '', 'icon' => 'fas fa-clipboard-list'],
                                                ];
                                            @endphp
                                            @foreach($vitalityData as $key => $data)
                                                <p><i class="{{ $data['icon'] }} text-primary me-2"></i> <strong class="w-50 d-inline-block">{{ $key }}:</strong> {{ $data['value'] }} {{ $data['unit'] }}</p>
                                            @endforeach
                                        </div>

                                        <!-- Blood Pressure, Heart Rate, etc. -->
                                        <div class="col-md-4">
                                            @php
                                                $vitalSignsData = [
                                                    'Blood Pressure' => ['value' => $exam->vitality->blood_pressure ?? "-", 'icon' => 'fas fa-tint'],
                                                    'Heart Rate' => ['value' => $exam->vitality->heart_rate ?? "-", 'icon' => 'fas fa-heartbeat'],
                                                    'Respiratory Rate' => ['value' => $exam->vitality->respiratory_rate ?? "-", 'icon' => 'fas fa-lungs'],
                                                    'Temperature' => ['value' => $exam->vitality->temperature ?? "-", 'icon' => 'fas fa-thermometer-half'],
                                                    'Oxygen Saturation' => ['value' => $exam->vitality->oxygen_saturation ?? "-", 'icon' => 'fas fa-wind'],
                                                ];
                                            @endphp
                                            @foreach($vitalSignsData as $key => $data)
                                                <p><i class="{{ $data['icon'] }} text-danger me-2"></i> <strong class="w-50 d-inline-block">{{ $key }}:</strong> {{ $data['value'] }}</p>
                                            @endforeach
                                        </div>

                                        <!-- Circumference Measurements -->
                                        <div class="col-md-4">
                                            @php
                                                $circumferenceData = [
                                                    'Waist Circumference' => ['value' => $exam->vitality->waist_circumferennce ?? "-", 'icon' => 'fas fa-circle-notch'],
                                                    'Neck Circumference' => ['value' => $exam->vitality->neck_circumference ?? "-", 'icon' => 'fas fa-circle-notch'],
                                                    'Arm Circumference' => ['value' => $exam->vitality->arm_circumference ?? "-", 'icon' => 'fas fa-circle-notch'],
                                                    'Chest Size' => ['value' => $exam->vitality->chest_size ?? "-", 'icon' => 'fas fa-circle-notch'],
                                                    'Abdominal Circumference' => ['value' => $exam->vitality->adbdominal_circumference ?? "-", 'icon' => 'fas fa-circle-notch'],
                                                ];
                                            @endphp
                                            @foreach($circumferenceData as $key => $data)
                                                <p><i class="{{ $data['icon'] }} text-info me-2"></i> <strong class="w-50 d-inline-block">{{ $key }}:</strong> {{ $data['value'] }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Check up Result -->
                            <div class="card card-custom gutter-b shadow-sm">
                                <div class="card-header bg-light">
                                    <h3 class="card-title">
                                        <i class="fas fa-clipboard-list text-success me-2"></i>
                                        Check up Result
                                    </h3>
                                </div>
                                <div class="card-body">
                                    @if(isset($exam->service_category->is_mcu) && $exam->service_category->is_mcu == 1)
                                        @include('pages.klinik.examinations.partials.mcu_result', ['exam' => $exam])
                                    @else
                                        @include('pages.klinik.examinations.partials.regular_checkup_result', ['exam' => $exam])
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
