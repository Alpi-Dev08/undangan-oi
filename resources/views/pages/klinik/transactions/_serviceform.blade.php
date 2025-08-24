<!--begin::Card-->
<div class="card card-xxl-stretch mb-5 mb-xl-8">
    <!--begin::Card body-->
    <!--begin::Card header-->
    <div class="card-header position-relative py-0 border-bottom-1">
        <!--begin::Card title-->
        <h3 class="card-title text-gray-800 fw-bold">
            Pilih Jenis Layanan
        </h3>
        <!--end::Card title-->
        <!--begin::Tabs-->
        <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-4">
            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#user">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Patient Profile</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span
                        class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#medicalrecord">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Medical Record</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span
                        class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3 active" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#examination">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Services</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span
                        class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->
        </ul>
        <!--end::Tabs-->
    </div>

    <div class="card-body pb-0">
        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab pane-->
            @include('pages.klinik.examinations.partials._profile')
            @include('pages.klinik.examinations.partials._medicalrecord')

            <div class="tab-pane active" id="examination" role="tabpanel" aria-labelledby="all-tab"
                data-kt-timeline-widget-4-blockui="true">
                <form id="kt_modal_add_permission_form" method="POST" class="form"
                    action="{{ route('examinations.storeservices') }}">
                    {{ csrf_field() }}
                    <ul style="margin-left:-40px;" class="row">
                        @foreach ($services as $service)
                            <li class="col-lg-4" style="list-style: none;">
                                <div class="form-check form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input"
                                        {{ in_array($service->id, $transactionDetail) ? 'checked' : '' }}
                                        type="checkbox" value="{{ $service->id }}" name="service_id[]"
                                        id="service_{{ $service->id }}">
                                    <label class="form-check-label" for="category_{{ $service->id }}">
                                        {{ $service->name }}
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <ul style="margin-left:-40px;border-top:1px solid gray;padding-top:10px" class="row">
                        @foreach ($servicecategories as $category)
                            <li class="col-lg-4 mb-6" style="list-style: none;">
                                <div class="form-check fw-bold form-check-custom form-check-solid mb-3">
                                    {{ $category->name }}
                                </div>
                                <ul>
                                    @foreach (services($category->id) as $service)
                                        <li style="list-style: none;">
                                            <div class="form-check form-check-custom form-check-solid mb-3">
                                                <input class="form-check-input"
                                                    {{ in_array($service->id, $transactionDetail) ? 'checked' : '' }}
                                                    type="checkbox" value="{{ $service->id }}" name="service_id[]"
                                                    id="service_{{ $service->id }}">
                                                <label class="form-check-label" for="type_{{ $service->id }}">
                                                    {{ $service->name }}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>

                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                        <button type="submit" class="btn btn-primary" name="payment" value="1"
                            data-kt-examinations-modal-action="submit">
                            <span class="indicator-label">Create Payment</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <button type="submit" class="btn btn-info" name="continue" value="1"
                            data-kt-examinations-modal-action="submit">
                            <span class="indicator-label">Continue</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
            </div>
        </div>
    </div>
</div>

@section('styles')
    <style>
        .timeline-label .timeline-label {
            width: 200px !important
        }

        .timeline-label:before {
            left: 201px !important;
        }
    </style>
@endsection

@push('customscript')
    <script>
        $(function() {
            $assesment = $("#assessment").html();
            $("#icdtens").change(function() {
                $("#assessment").append($(this).find("option:selected").text() + '\n');
            });
        })
    </script>
@endpush
