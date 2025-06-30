{{-- Komponen Alert Pemeriksaan Awal --}}
@include('pages.klinik.examinations.partials._initial-assessment-alert', ['pemeriksaan_awal' => $pemeriksaan_awal ?? null])

{{-- Card Utama Examination --}}
<div class="card card-xxl-stretch mb-5 mb-xl-8" x-data="vitalityExamination()">
    {{-- Header Card dengan Navigation Tabs --}}
    @include('pages.klinik.examinations.partials._vitality-header', ['examination' => $examination])

    {{-- Body Card dengan Tab Content --}}
    <div class="card-body pb-0">
        <div class="tab-content">
            {{-- Tab Patient Profile --}}
            @include('pages.klinik.examinations.partials._profile')

            {{-- Tab Vitality Examination --}}
            @include('pages.klinik.examinations.partials.components.vitality')

            {{-- Tab Skrining Rawat Jalan --}}
            @include('pages.klinik.examinations.partials.components.skrining')
        </div>
    </div>
</div>

{{-- Scripts untuk Vitality Form --}}
@include('pages.klinik.examinations.partials.scripts._vitality-calculations')
