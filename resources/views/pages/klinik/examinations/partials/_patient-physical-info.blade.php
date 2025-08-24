{{-- Physical Information Section --}}
@php
    $physicalInfoFields = [
        ['label' => __('Weight'), 'value' => $info->weight . ' Kg'],
        ['label' => __('Height'), 'value' => $info->height . ' cm'],
    ];
@endphp

@foreach($physicalInfoFields as $field)
    @include('pages.klinik.examinations.partials._info-row', $field)
@endforeach