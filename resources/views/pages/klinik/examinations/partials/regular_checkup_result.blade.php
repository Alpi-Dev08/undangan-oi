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
                    $resep = json_decode($exam->resep ?? '{}');
                    $obat = $resep->obat ?? [];
                    $qty = $resep->qty ?? [];
                @endphp
                @if(!empty($obat))
                    <ul class="list-unstyled">
                        @foreach($obat as $key => $value)
                            @if(isset(getObat($value)->name))
                                <li><i class="fas fa-capsules text-muted me-2"></i>{{ getObat($value)->name }} x {{ $qty[$key] ?? '' }}</li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    : -
                @endif
            </div>
        </div>
    </div>
</div>
