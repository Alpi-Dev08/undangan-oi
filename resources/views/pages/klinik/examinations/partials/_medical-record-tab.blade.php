<div class="tab-pane" id="medicalrecord" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="timeline-label">
            @foreach($examinations as $exam)
                @include('pages.klinik.examinations.partials._examination-timeline-item', ['exam' => $exam])
            @endforeach
        </div>
    </div>
</div>