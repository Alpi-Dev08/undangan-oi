<div x-data="serviceForm()" class="service-form-container">
    @include('pages.klinik.examinations.partials._initial-assessment-alert')

    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        @include('pages.klinik.examinations.partials._service-header')

        <div class="card-body pb-0">
            <div class="tab-content">
                @include('pages.klinik.examinations.partials._patient-profile-tab')
                @include('pages.klinik.examinations.partials._medical-record-tab')
                @include('pages.klinik.examinations.partials._services-tab')
            </div>
        </div>
    </div>
</div>

@include('pages.klinik.examinations.partials._service-styles')
@include('pages.klinik.examinations.partials._service-scripts')

<script>
    function serviceForm() {
        return {
            selectedServices: [],
            isSubmitting: false,

            toggleService(serviceId) {
                const index = this.selectedServices.indexOf(serviceId);
                if (index > -1) {
                    this.selectedServices.splice(index, 1);
                } else {
                    this.selectedServices.push(serviceId);
                }
            },

            submitForm(action) {
                this.isSubmitting = true;
                // Form submission logic
            }
        }
    }
</script>
