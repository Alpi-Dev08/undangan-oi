<x-base-layout>
    <!--begin::Card-->
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
         <!--begin::Card header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <!-- <span class="card-label fw-bolder fs-3 mb-1">Add Skrining Examination</span> -->
            </h3>

            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title=""
                 data-bs-original-title="Click to cancel">
                <a href="{{ route('skriningexaminations.index') }}" class="btn btn-sm btn-light-primary" x-bind:disabled="isSubmitting">
                    <!-- SVG icon -->
                    <span class="svg-icon svg-icon-muted svg-icon-2">
                        <!-- SVG content here -->
                    </span>
                    Cancel
                </a>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @include('pages.klinik.skriningexaminations._result')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</x-base-layout>
