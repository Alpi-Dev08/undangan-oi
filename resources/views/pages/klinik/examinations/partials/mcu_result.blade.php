<div class="card card-custom gutter-b shadow-sm mb-5">
    <div class="card-header bg-light">
        <h3 class="card-title">
            <i class="fas fa-clipboard-list text-primary me-2"></i>
            Medical Check-Up Result
        </h3>
    </div>
    <div class="card-body">
        @if(isset($exam->anamnesis->anamnesis_value))
            <h4 class="mt-4 mb-3"><i class="fas fa-history text-info me-2"></i>1. Anamnesis</h4>
            @php
                $anamnesis = json_decode($exam->anamnesis->anamnesis_value);
                $header = '';
            @endphp
            @foreach($anamnesis as $key => $value)
                @php
                    $radio = isset($value->radio) ? json_decode(json_encode($value->radio), true) : [];
                    $radioKeys = array_keys($radio);
                    $additional = json_decode(json_encode($value->additional), true);
                    $additionalKeys = array_keys($additional);
                @endphp

                @if($header != getAnamnesis($key)->anamnesis_category_id)
                    <h5 class="mt-3 mb-2 text-primary"><i class="fas fa-folder-open me-2"></i>{{ getAnamnesisCategory(getAnamnesis($key)->anamnesis_category_id)->name }}</h5>
                    @php $header = getAnamnesis($key)->anamnesis_category_id; @endphp
                @endif

                <div class="row mb-2">
                    <div class="col-md-4 fw-bold"><i class="fas fa-chevron-right text-muted me-2"></i>{{ getAnamnesis($key)->name }}</div>
                    <div class="col-md-8">
                        @if(!empty($radio) && !empty($additional[$additionalKeys[0]]))
                            : {{ ucwords($radio[$radioKeys[0]]) }}, {{ $additional[$additionalKeys[0]] }}
                        @elseif(!empty($radio))
                            : {{ ucwords($radio[$radioKeys[0]]) }}
                        @elseif(!empty($additional[$additionalKeys[0]]))
                            : {{ $additional[$additionalKeys[0]] }}
                        @else
                            : -
                        @endif
                    </div>
                </div>
            @endforeach
        @endif

        @if(isset($exam->physical->physical_value))
            <h4 class="mt-4 mb-3"><i class="fas fa-stethoscope text-warning me-2"></i>2. Physical Examination</h4>
            @php
                $physicals = json_decode($exam->physical->physical_value);
                $header = '';
            @endphp
            @foreach($physicals as $key => $value)
                @php
                    $radio = isset($value->radio) ? json_decode(json_encode($value->radio), true) : [];
                    $radioKeys = array_keys($radio);
                    $additional = json_decode(json_encode($value->additional), true);
                    $additionalKeys = array_keys($additional);
                @endphp

                @if($header != getPhysicals($key)->physical_category_id)
                    <h5 class="mt-3 mb-2 text-primary"><i class="fas fa-folder-open me-2"></i>{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</h5>
                    @php $header = getPhysicals($key)->physical_category_id; @endphp
                @endif

                <div class="row mb-2">
                    <div class="col-md-4 fw-bold"><i class="fas fa-chevron-right text-muted me-2"></i>{{ getPhysicals($key)->name }}</div>
                    <div class="col-md-8">
                        @if(!empty($radio) && !empty($additional[$additionalKeys[0]]))
                            : {{ ucwords($radio[$radioKeys[0]]) }}, {{ $additional[$additionalKeys[0]] }}
                        @elseif(!empty($radio))
                            : {{ ucwords($radio[$radioKeys[0]]) }}
                        @elseif(!empty($additional[$additionalKeys[0]]))
                            : {{ $additional[$additionalKeys[0]] }}
                        @else
                            : -
                        @endif
                    </div>
                </div>
            @endforeach
        @endif

        @if(isset($exam->other->other_value))
            <h4 class="mt-4 mb-3"><i class="fas fa-plus-circle text-success me-2"></i>3. Other</h4>
            @php
                $others = json_decode($exam->other->other_value);
                $header = '';
            @endphp
            @foreach($others as $key => $value)
                @php
                    $radio = isset($value->radio) ? json_decode(json_encode($value->radio), true) : [];
                    $radioKeys = array_keys($radio);
                    $additional = json_decode(json_encode($value->additional), true);
                    $additionalKeys = array_keys($additional);
                @endphp

                @if($header != getPhysicals($key)->physical_category_id)
                    <h5 class="mt-3 mb-2 text-primary"><i class="fas fa-folder-open me-2"></i>{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</h5>
                    @php $header = getPhysicals($key)->physical_category_id; @endphp
                @endif

                <div class="row mb-2">
                    <div class="col-md-4 fw-bold"><i class="fas fa-chevron-right text-muted me-2"></i>{{ getPhysicals($key)->name }}</div>
                    <div class="col-md-8">
                        @if(!empty($radio) && !empty($additional[$additionalKeys[0]]))
                            : {{ ucwords($radio[$radioKeys[0]]) }}, {{ $additional[$additionalKeys[0]] }}
                        @elseif(!empty($radio))
                            : {{ ucwords($radio[$radioKeys[0]]) }}
                        @elseif(!empty($additional[$additionalKeys[0]]))
                            : {{ $additional[$additionalKeys[0]] }}
                        @else
                            : -
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="row mt-4">
                <div class="col-md-4 fw-bold"><i class="fas fa-clipboard-check text-success me-2"></i>Result</div>
                <div class="col-md-8">: {{ $exam->other->result }}</div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4 fw-bold"><i class="fas fa-comment-medical text-info me-2"></i>Description</div>
                <div class="col-md-8">: {{ $exam->other->description }}</div>
            </div>
        @endif
    </div>
</div>
