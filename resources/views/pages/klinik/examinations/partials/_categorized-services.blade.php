{{-- Group services by category dalam accordion --}}
<div class="accordion" id="servicesAccordion">
    @foreach ($servicecategories as $category)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $loop->index }}">
                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}">
                    {{ $category->name }}
                    <span class="badge badge-light-secondary ms-2">{{ count(services($category->id)) }}</span>
                </button>
            </h2>
            <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}">
                <div class="accordion-body">
                    <div class="row g-2">
                        @foreach (services($category->id)->chunk(2) as $serviceChunk)
                            @foreach ($serviceChunk as $service)
                                <div
                                    class="col-12 col-md-{{ count(services($category->id)) < 10 ? '12' : '6' }} col-xl-{{ count(services($category->id)) < 10 ? '12' : '4' }}">
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
            </div>
        </div>
    @endforeach
</div>
