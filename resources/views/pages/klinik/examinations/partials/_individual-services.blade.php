<div class="services-section mb-6">
    <h5 class="mb-4">{{ __('Individual Services') }}</h5>
    {{-- Gunakan grid layout untuk menghemat ruang --}}
    <div class="row g-3">
        @foreach ($services->chunk(2) as $serviceChunk)
            @foreach ($serviceChunk as $service)
                <div class="col-md-6">
                    @include('pages.klinik.examinations.partials._service-checkbox', [
                        'service' => $service,
                        'inputName' => 'selected_services[]',
                        'checked' => in_array($service->id, $selectedServices ?? []),
                    ])
                </div>
            @endforeach
        @endforeach
    </div>
</div>
