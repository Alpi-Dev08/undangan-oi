{{-- Service Checkbox Component - Compact Version --}}
@php
    $inputName = $inputName ?? 'services[]';
    $checked = $checked ?? false;
    $disabled = $disabled ?? false;
    $serviceId = $service->id ?? '';
    $serviceName = $service->name ?? 'Unknown Service';
    $servicePrice = $service->price ?? null;
@endphp

<div class="form-check service-checkbox-compact" x-data="{ checked: {{ $checked ? 'true' : 'false' }} }" :class="{ 'checked': checked }">

    <input class="form-check-input" type="checkbox" value="{{ $serviceId }}" name="{{ $inputName }}"
        id="service_{{ $serviceId }}" x-model="checked"
        x-on:change="toggleService({{ $serviceId }}, checked, '{{ addslashes($serviceName) }}', {{ $servicePrice ?? 'null' }})"
        {{ $checked ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }}>

    <label class="form-check-label d-flex justify-content-between align-items-center w-100"
        for="service_{{ $serviceId }}">
        <div class="service-info">
            <span class="service-name fw-semibold">{{ $serviceName }}</span>
        </div>

        @if ($servicePrice)
            <span class="badge badge-light-primary fs-8">
                Rp {{ number_format($servicePrice, 0, ',', '.') }}
            </span>
        @endif
    </label>
</div>
