@php
    $basicInfoFields = [
        ['label' => __('Patient ID'), 'value' => $user->patient->patient_code],
        ['label' => __('Medical Record'), 'value' => $user->mr->medical_record_code],
        ['label' => __('Card Type'), 'value' => isset($info->card_type_id) ? $info->card->name : ''],
        ['label' => __('Card Number'), 'value' => $info->card_number],
        ['label' => __('Full Name'), 'value' => ($info->title_prefix != '' ? $info->title_prefix.'. ' : '').$user->name.($info->title_suffix != '' ? ', '.$info->title_suffix : '')],
        ['label' => __('Email'), 'value' => $user->email],
    ];
@endphp

@foreach($basicInfoFields as $field)
    @include('pages.klinik.examinations.partials._info-row', $field)
@endforeach

<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">
        {{ __('Contact Phone') }}
        <i class="fas fa-exclamation-circle ms-1 fs-7" 
           data-bs-toggle="tooltip"
           title="{{ __('Phone number must be active') }}"></i>
    </label>
    <div class="col-lg-8 d-flex align-items-center">
        <span class="fw-bolder fs-6 me-2">{{ $user->phone }}</span>
    </div>
</div>