{{-- Personal Information Section --}}
@php
    $personalInfoFields = [
        ['label' => __('Place and date of Birth'), 'value' => $info->place_of_birth.', '.$info->date_of_birth],
        ['label' => __('Religion'), 'value' => isset($info->religion) ? $info->religion->name : ''],
        ['label' => __('Gender'), 'value' => isset($info->gender) ? $info->gender->name : ''],
        ['label' => __('Marital Status'), 'value' => isset($info->marital_status_id) ? $info->marital->name : ''],
        ['label' => __('Education'), 'value' => isset($info->education_id) ? $info->education->name : ''],
        ['label' => __('Work'), 'value' => isset($info->work_id) ? $info->work->name : ''],
        ['label' => __('Blood Type'), 'value' => isset($info->blood_type_id) ? $info->blood->name : ''],
    ];
@endphp

@foreach($personalInfoFields as $field)
    @include('pages.klinik.examinations.partials._info-row', $field)
@endforeach
