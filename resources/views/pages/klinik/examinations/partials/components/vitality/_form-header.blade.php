{{-- Form Header dengan kondisi untuk update atau create --}}
@if (isset($vitalityexamination->id))
    <form id="kt_modal_add_examinations_form" method="POST" class="form"
        action="{{ route('vitalityexaminations.update', ['vitalityexamination' => $vitalityexamination->id]) }}">
        @method('PUT')
@else
    <form id="kt_modal_add_examinations_form" method="POST" class="form"
        action="{{ route('vitalityexaminations.store') }}">
        @method('POST')
@endif
{{ csrf_field() }}
