<div class="tab-pane active" id="examination" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
    <form id="kt_modal_add_permission_form"
          method="POST"
          class="form"
          action="{{ route('examinations.storeservices') }}"
          x-on:submit="isSubmitting = true">
        @csrf

        @include('pages.klinik.examinations.partials._individual-services')
        @include('pages.klinik.examinations.partials._categorized-services')
        @include('pages.klinik.examinations.partials._service-actions')
    </form>
</div>
