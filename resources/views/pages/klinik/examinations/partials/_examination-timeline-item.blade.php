{{-- Timeline Item untuk Riwayat Pemeriksaan --}}
<div class="timeline-item" x-data="{ expanded: false }">
    <div class="timeline-line"></div>
    <div class="timeline-icon">
        <i class="ki-duotone ki-medical-cross fs-2 text-primary">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <div class="timeline-content">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="fw-bold text-gray-800 fs-6">
                {{ $examination->medical_record_code ?? 'N/A' }}
            </div>
            <div class="text-muted fs-7">
                {{ $examination->created_at ? $examination->created_at->format('d M Y, H:i') : 'N/A' }}
            </div>
        </div>

        <div class="text-gray-700 fs-7 mb-2">
            <span class="badge badge-light-info me-2">
                {{ $examination->examination_code ?? 'N/A' }}
            </span>
            @if($examination->doctor)
                <span class="text-muted">oleh {{ $examination->doctor->name ?? 'N/A' }}</span>
            @endif
        </div>

        @if($examination->examination_type)
            <div class="text-gray-600 fs-8 mb-2">
                <i class="ki-duotone ki-stethoscope fs-8 me-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                {{ $examination->examination_type->name ?? 'N/A' }}
            </div>
        @endif

        @if($examination->services && $examination->services->count() > 0)
            <div class="mb-2">
                <button
                    type="button"
                    class="btn btn-sm btn-light-primary"
                    @click="expanded = !expanded"
                    :class="{ 'active': expanded }"
                >
                    <i class="ki-duotone ki-down" :class="{ 'rotate-180': expanded }">
                        <span class="path1"></span>
                    </i>
                    Lihat Layanan ({{ $examination->services->count() }})
                </button>
            </div>

            <div x-show="expanded" x-transition class="mt-3">
                <div class="bg-light-primary rounded p-3">
                    <div class="fw-semibold text-primary mb-2 fs-7">Layanan yang Dilakukan:</div>
                    <div class="row">
                        @foreach($examination->services as $service)
                            <div class="col-md-6 mb-1">
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-check-circle fs-8 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="text-gray-700 fs-8">{{ $service->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if($examination->vital_signs)
            <div class="mt-2">
                <div class="text-muted fs-8 mb-1">
                    <i class="ki-duotone ki-heart fs-8 me-1 text-danger">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    Tanda Vital:
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @if($examination->vital_signs->weight)
                        <span class="badge badge-light-secondary fs-8">BB: {{ $examination->vital_signs->weight }} kg</span>
                    @endif
                    @if($examination->vital_signs->height)
                        <span class="badge badge-light-secondary fs-8">TB: {{ $examination->vital_signs->height }} cm</span>
                    @endif
                    @if($examination->vital_signs->blood_pressure_systolic && $examination->vital_signs->blood_pressure_diastolic)
                        <span class="badge badge-light-secondary fs-8">
                            TD: {{ $examination->vital_signs->blood_pressure_systolic }}/{{ $examination->vital_signs->blood_pressure_diastolic }} mmHg
                        </span>
                    @endif
                    @if($examination->vital_signs->temperature)
                        <span class="badge badge-light-secondary fs-8">Suhu: {{ $examination->vital_signs->temperature }}°C</span>
                    @endif
                </div>
            </div>
        @endif

        @if($examination->status)
            <div class="mt-2">
                @php
                    $statusClass = match($examination->status) {
                        'completed' => 'badge-light-success',
                        'in_progress' => 'badge-light-warning',
                        'cancelled' => 'badge-light-danger',
                        default => 'badge-light-secondary'
                    };
                    $statusText = match($examination->status) {
                        'completed' => 'Selesai',
                        'in_progress' => 'Sedang Berlangsung',
                        'cancelled' => 'Dibatalkan',
                        default => ucfirst($examination->status)
                    };
                @endphp
                <span class="badge {{ $statusClass }} fs-8">
                    {{ $statusText }}
                </span>
            </div>
        @endif
    </div>
</div>

<style>
.timeline-item {
    position: relative;
    padding-left: 3rem;
    padding-bottom: 2rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-line {
    position: absolute;
    left: 1.25rem;
    top: 2.5rem;
    bottom: 0;
    width: 2px;
    background-color: #e1e3ea;
}

.timeline-item:last-child .timeline-line {
    display: none;
}

.timeline-icon {
    position: absolute;
    left: 0.5rem;
    top: 0;
    width: 2.5rem;
    height: 2.5rem;
    background-color: #fff;
    border: 2px solid #e1e3ea;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
}

.timeline-content {
    background-color: #f9f9f9;
    border-radius: 0.5rem;
    padding: 1rem;
    border-left: 3px solid #009ef7;
}

.rotate-180 {
    transform: rotate(180deg);
    transition: transform 0.3s ease;
}
</style>
