{{-- Header Card dengan Navigation Tabs untuk Vitality Form --}}
<div class="card-header position-relative py-0 border-bottom-1">
    {{-- Card Title --}}
    <h3 class="card-title text-gray-800 fw-bold">
        Examination {{ $examination->examination_code }}
    </h3>

    {{-- Navigation Tabs --}}
    <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-4">
        {{-- Patient Profile Tab --}}
        @include('pages.klinik.examinations.partials._vitality-nav-item', [
            'href' => '#user',
            'title' => 'Patient Profile',
            'active' => false
        ])

        {{-- Skrining Rawat Jalan Tab --}}
        @include('pages.klinik.examinations.partials._vitality-nav-item', [
            'href' => '#skrining',
            'title' => 'Skrining Rawat Jalan',
            'active' => true
        ])

        {{-- Vitality Examination Tab --}}
        @include('pages.klinik.examinations.partials._vitality-nav-item', [
            'href' => '#vitality-examination',
            'title' => 'Vitality Examination',
            'active' => false
        ])
    </ul>
</div>
