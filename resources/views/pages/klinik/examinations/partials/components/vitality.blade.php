<div class="tab-pane" id="vitality-examination" role="tabpanel" aria-labelledby="all-tab"
    data-kt-timeline-widget-4-blockui="true" x-data="vitalityExamination()">

    @include('pages.klinik.examinations.partials.components.vitality._form-header')

    <div class="row">
        @include('pages.klinik.examinations.partials.components.vitality._hidden-inputs')
        @include('pages.klinik.examinations.partials.components.vitality._vital-signs')
        @include('pages.klinik.examinations.partials.components.vitality._body-measurements')
        @include('pages.klinik.examinations.partials.components.vitality._body-composition')
        @include('pages.klinik.examinations.partials.components.vitality._physical-findings')
        @include('pages.klinik.examinations.partials.components.vitality._others-field')
    </div>

    @include('pages.klinik.examinations.partials.components.vitality._form-actions')

    </form>
</div>

@include('pages.klinik.examinations.partials.components.vitality._vitality-scripts')
