@if (isset($pemeriksaan_awal))
    @if ($pemeriksaan_awal->kriteria_satu == 'ya' && $pemeriksaan_awal->kriteria_dua == 'ya')
        <div class="alert alert-danger d-flex align-items-center p-5">
        @elseif($pemeriksaan_awal->kriteria_satu == 'ya' || $pemeriksaan_awal->kriteria_dua == 'ya')
            <div class="alert alert-warning d-flex align-items-center p-5">
            @else
                <div class="alert alert-success d-flex align-items-center p-5">
    @endif
    <!--begin::Wrapper-->
    <div class="d-flex flex-column">
        <!--begin::Title-->
        <h4 class="mb-1 text-dark">{{ $pemeriksaan_awal->interpretasi }}</h4>
        <!--end::Title-->

        <!--begin::Content-->
        <span>{{ ucwords($pemeriksaan_awal->tindakan) }}</span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->
    </div>
    <!--end::Alert-->
@endif
<!--begin::Card-->
<div class="card card-xxl-stretch mb-5 mb-xl-8">
    <!--begin::Card body-->
    <!--begin::Card header-->
    <div class="card-header position-relative py-0 border-bottom-1">
        <!--begin::Card title-->
        <h3 class="card-title text-gray-800 fw-bold">
            Examination {{ $examination->examination_code }}
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
            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3 active" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#skrining">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Skrining Rawat Jalan</span>
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
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#vitality-examination">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Vitality Examination</span>
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
            @include('pages.klinik.examinations.partials.components.vitality')
            @include('pages.klinik.examinations.partials.components.skrining')
        </div>
    </div>
</div>

@push('customscript')
    <script>
        $(function() {
            var bmi, weight, height = 0;
            $('#weight').change(function() {
                weight = $(this).val();
                height = $('#height').val();

                height = height > 0 ? height / 100 : 0;
                bmi = weight / (height * height);
                $("#body_mass_index").val(bmi.toFixed(2));
                if (bmi < 18.5) {
                    $("#bmi_conclusion").val("Underweight");
                } else if (bmi >= 18.5 && bmi <= 24.9) {
                    $("#bmi_conclusion").val("Normal Weight");
                } else if (bmi >= 25 && bmi <= 29.9) {
                    $("#bmi_conclusion").val("Overweight");
                } else if (bmi >= 30 <= 34.9) {
                    $("#bmi_conclusion").val("Obesity class I");
                } else if (bmi >= 35 <= 39.9) {
                    $("#bmi_conclusion").val("Obesity class II");
                } else if (bmi >= 40) {
                    $("#bmi_conclusion").val("Obesity class III");
                }
            });

            $('#height').change(function() {
                weight = $('#weight').val();
                height = $(this).val();
                height = height > 0 ? height / 100 : 0;
                bmi = weight / (height * height);
                $("#body_mass_index").val(bmi.toFixed(2));

                if (bmi < 18.5) {
                    $("#bmi_conclusion").val("Underweight");
                } else if (bmi >= 18.5 && bmi <= 24.9) {
                    $("#bmi_conclusion").val("Normal Weight");
                } else if (bmi >= 25 && bmi <= 29.9) {
                    $("#bmi_conclusion").val("Overweight");
                } else if (bmi >= 30 <= 34.9) {
                    $("#bmi_conclusion").val("Obesity class I");
                } else if (bmi >= 35 <= 39.9) {
                    $("#bmi_conclusion").val("Obesity class II");
                } else if (bmi >= 40) {
                    $("#bmi_conclusion").val("Obesity class III");
                }

                var tinggiBadan = $(this).val() - 100;
                @if ($user->info->gender == '1')
                    tinggiBadan = tinggiBadan - (tinggiBadan * 10 / 100);
                @else
                    tinggiBadan = tinggiBadan - (tinggiBadan * 15 / 100);
                @endif
                tinggiBadan = tinggiBadan > 0 ? tinggiBadan : 0;
                $("#ideal_weight").val(tinggiBadan.toFixed(2));
            });


            $assesment = $("#assessment").html();
            $("#icdtens").change(function() {
                $("#assessment").append($(this).find("option:selected").text() + '\n');
            });
        })
    </script>
@endpush
