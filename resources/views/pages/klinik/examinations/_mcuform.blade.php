<!--begin::Card-->
<div class="card card-xxl-stretch mb-5 mb-xl-8">
    <!--begin::Card body-->
    <!--begin::Card header-->
    <div class="card-header position-relative py-0 border-bottom-1">
        <!--begin::Card title-->
        <h3 class="card-title text-gray-800 fw-bold">
            Examination
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
                    data-bs-toggle="tab" href="#anamnesis">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Anamnesis</span>
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
                    data-bs-toggle="tab" href="#physical">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Physical</span>
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
                    data-bs-toggle="tab" href="#other">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Other</span>
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
                    data-bs-toggle="tab" href="#additional">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Additional</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span
                        class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0 d-none">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#examination">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Examination</span>
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

            <div class="tab-pane active" id="anamnesis" role="tabpanel" aria-labelledby="all-tab"
                data-kt-timeline-widget-4-blockui="true">
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <!--begin::Alert-->
                    <div
                        class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10 row">
                        <!--begin::Wrapper-->
                        <div class="row col-12 pe-0 pe-sm-10">
                            <!--begin::Title-->
                            <h5 class="mb-1">Jenis Pemeriksaan</h5>
                            <!--end::Title-->
                            <div class="col-12">{{ $examination->service_category->name }}
                                <ul class="row">
                                    @foreach (service_examination($examination->id) as $service)
                                        <li class="col-4">{{ $service->service->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Alert-->

                    @if (isset($anamnesisexamination->id))
                        <form id="kt_modal_add_examinations_form" method="POST" class="form"
                            action="{{ route('anamnesisexaminations.update', ['anamnesisexamination' => $anamnesisexamination->id]) }}">
                            @method('PUT')
                            {{ csrf_field() }}
                        @else
                            <form id="kt_modal_add_examinations_form" method="POST" class="form"
                                action="{{ route('anamnesisexaminations.store') }}">
                                @method('POST')
                                {{ csrf_field() }}
                    @endif
                    <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                    <div class="row col-12 mb-6">
                        <label for="request" class="form-label">Present Complaint / Keluhan Saat Ini</label>
                        <textarea id="request" name="request" row="5"
                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('request') is-invalid @enderror"
                            placeholder="Present Complaint / Keluhan Saat Ini">{{ $anamnesisexamination->request ?? '' }}</textarea>
                        @error('request')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <ol type="I" style="margin-left:-25px">
                        @foreach ($anamnesiscategories as $anamnesiscategory)
                            <li class="fw-bolder text-lg">
                                {{ $anamnesiscategory->name }}
                                <ol>
                                    @foreach (anamnesis($anamnesiscategory->id) as $anamnesis)
                                        <li class="fw-normal text-base mb-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    {{ $anamnesis->name }}
                                                    <input type="hidden" name="anamnesis[{{ $anamnesis->id }}]">
                                                </div>
                                                <div class="col-6">
                                                    @php
                                                        $options = json_decode($anamnesis->options);
                                                        $option = [];
                                                        if (isset($anamnesisexamination->anamnesis_value)) {
                                                            $option = json_decode(
                                                                $anamnesisexamination->anamnesis_value,
                                                                true,
                                                            );
                                                        }

                                                    @endphp
                                                    <div
                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                        @if (isset($options->radio))
                                                            @foreach ($options->radio as $radio)
                                                                @php
                                                                    $r = [];
                                                                    if (isset($option[$anamnesis->id])) {
                                                                        if (isset($option[$anamnesis->id]['radio'])) {
                                                                            $r = $option[$anamnesis->id]['radio'];
                                                                        }
                                                                    }
                                                                @endphp
                                                                <div
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="radio"
                                                                        @if (in_array($radio->id, $r)) {{ 'checked' }}
                                                                                           @elseif($radio->id == 'no' || $radio->id == 'good' || $radio->id == 'never')
                                                                                               {{ 'checked' }}
                                                                                           @else
                                                                                               {{ '' }} @endif
                                                                        name = "anamnesis[{{ $anamnesis->id }}][radio][]"
                                                                        value="{{ $radio->id }}"
                                                                        id="radio-{{ $anamnesis->id }}" />
                                                                    <label class="form-check-label"
                                                                        for="radio-{{ $anamnesis->id }}">
                                                                        {{ $radio->value }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                        @if (isset($options->additional))
                                                            @foreach ($options->additional as $additional)
                                                                @php
                                                                    $adt = [];
                                                                    if (isset($option[$anamnesis->id])) {
                                                                        if (
                                                                            isset($option[$anamnesis->id]['additional'])
                                                                        ) {
                                                                            $adt =
                                                                                $option[$anamnesis->id]['additional'];
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if ($additional->type == 'text')
                                                                    <input type="text"
                                                                        value="{{ $adt[$additional->name] ?? '' }}"
                                                                        name="anamnesis[{{ $anamnesis->id }}][additional][{{ $additional->name }}]"
                                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                                        placeholder="{{ ucwords($additional->name) }}" />
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ol>
                            </li>
                        @endforeach
                    </ol>

                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <a href="{{ route('examinations.index') }}" class="btn btn-sm btn-light-primary">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.5"
                                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                        fill="currentColor" />
                                    <path
                                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary" name="selesai" value="1"
                            data-kt-examinations-modal-action="submit">
                            <span class="indicator-label">Finish</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>

                        <button type="submit" class="btn btn-info" name="continue" value="1"
                            data-kt-examinations-modal-action="submit">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                    </form>
                </div>
                <!--end::details View-->

            </div>

            @include('pages.klinik.examinations.partials.components.physic')

            <div class="tab-pane" id="other" role="tabpanel" aria-labelledby="all-tab"
                data-kt-timeline-widget-4-blockui="true">
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <!--begin::Alert-->
                    <div
                        class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10 row">
                        <!--begin::Wrapper-->
                        <div class="row col-12 pe-0 pe-sm-10">
                            <!--begin::Title-->
                            <h5 class="mb-1">Jenis Pemeriksaan</h5>
                            <!--end::Title-->
                            <div class="col-12">{{ $examination->service_category->name }}
                                <ul class="row">
                                    @foreach (service_examination($examination->id) as $service)
                                        <li class="col-4">{{ $service->service->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Alert-->

                    @if (isset($otherexamination->id))
                        <form id="kt_modal_add_examinations_form" method="POST" class="form"
                            enctype="multipart/form-data"
                            action="{{ route('otherexaminations.update', ['otherexamination' => $otherexamination->id]) }}">
                            @method('PUT')
                            {{ csrf_field() }}
                        @else
                            <form id="kt_modal_add_examinations_form" method="POST" class="form"
                                enctype="multipart/form-data" action="{{ route('otherexaminations.store') }}">
                                @method('POST')
                                {{ csrf_field() }}
                    @endif
                    <input type="hidden" name="examination_id" value="{{ $examination->id }}">

                    @foreach ($otherscategories as $otherscategory)
                        <h2 class="font-bold">{{ $otherscategory->name }}</h2>
                        <ol style="margin-left:-10px">
                            @foreach (physicals($otherscategory->id) as $others)
                                <li class="fw-normal text-base mb-6">
                                    <div class="row">
                                        <div class="col-4">
                                            {{ $others->name }}
                                            <input type="hidden" name="other[{{ $others->id }}]">
                                        </div>
                                        <div class="col-8">
                                            @php
                                                $options = json_decode($others->options);
                                                $option = [];
                                                if (isset($otherexamination->id)) {
                                                    $option = json_decode($otherexamination->other_value, true);
                                                }

                                            @endphp
                                            <div
                                                class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                @if (isset($options->radio))
                                                    @foreach ($options->radio as $radio)
                                                        @php
                                                            $r = [];
                                                            if (isset($option[$others->id])) {
                                                                if (isset($option[$others->id]['radio'])) {
                                                                    $r = $option[$others->id]['radio'];
                                                                }
                                                            }
                                                        @endphp
                                                        <div
                                                            class="form-check form-check-custom form-check-solid w-200px">
                                                            <input class="form-check-input" type="radio"
                                                                @if (in_array($radio->id, $r)) {{ 'checked' }}
                                                                                   @elseif($radio->id == 'normal' || $radio->id == 'good' || $radio->id == 'no')
                                                                                       {{ 'checked' }}
                                                                                   @else
                                                                                       {{ '' }} @endif
                                                                name = "other[{{ $others->id }}][radio][]"
                                                                value="{{ $radio->id }}"
                                                                id="radio-{{ $others->id }}" />
                                                            <label class="form-check-label"
                                                                for="radio-{{ $others->id }}">
                                                                {{ $radio->value }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                @if (isset($options->additional))
                                                    @foreach ($options->additional as $additional)
                                                        @php
                                                            $adt = [];
                                                            if (isset($option[$anamnesis->id])) {
                                                                if (isset($option[$others->id]['additional'])) {
                                                                    $adt = $option[$others->id]['additional'];
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($additional->type == 'text')
                                                            <input type="text"
                                                                value="{{ $adt[$additional->name] ?? '' }}"
                                                                name="other[{{ $others->id }}][additional][{{ $additional->name }}]"
                                                                class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                                placeholder="{{ ucwords($additional->name) }}" />
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">&nbsp;</div>
                                        <div class="col-8">
                                            <input type="file" accept="application/pdf"
                                                name="file[{{ $others->id }}]" id=""
                                                class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0">
                                            @if (isset($otherexamination->file))
                                                @php $file = json_decode($otherexamination->file,true); @endphp
                                                @if (isset($file[$others->id]))
                                                    <a href="{{ Storage::url('examinations/' . $examination->examination_code . '/' . $file[$others->id]) }}"
                                                        target="_blank">Lihat File</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    @endforeach

                    <!--begin::Input group-->
                    <div class="row mb-6 d-none">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span>{{ __('Result') }}</span>

                        </label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <select name="result" aria-label="{{ __('Select a Plan') }}" data-control="select2"
                                data-placeholder="{{ __('Select a Plan...') }}"
                                class="form-select form-select-solid form-select-lg fw-bold">
                                <option value="">{{ __('Select a Plan...') }}</option>
                                @if (isset($otherexamination->result))
                                    <option value="fitwork"
                                        {{ $otherexamination->result == 'fitwork' ? 'selected' : '' }}>Fit to Work
                                    </option>
                                    <option value="fit" {{ $otherexamination->result == 'fit' ? 'selected' : '' }}>
                                        Fit with Note</option>
                                    <option value="unfit"
                                        {{ $otherexamination->result == 'unfit' ? 'selected' : '' }}>
                                        Unfit</option>
                                @else
                                    <option value="fitwork">Fit to Work</option>
                                    <option value="fit">Fit with Note</option>
                                    <option value="unfit">Unfit</option>
                                @endif
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <div class="row mb-6 d-none">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-bold fs-6">Description</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-8">
                            <div class="input-group input-group-solid has-validation mb-3">
                                <textarea name="description"
                                    class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('description') is-invalid @enderror"
                                    placeholder="Description">{{ $otherexamination->description ?? '' }}</textarea>
                            </div>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Input-->
                    </div>


                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <a href="{{ route('examinations.index') }}" class="btn btn-sm btn-light-primary">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.5"
                                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                        fill="currentColor" />
                                    <path
                                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary" name="selesai" value="1"
                            data-kt-examinations-modal-action="submit">
                            <span class="indicator-label">Finish</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>

                        <button type="submit" class="btn btn-info" name="continue" value="1"
                            data-kt-examinations-modal-action="submit">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                    </form>

                </div>
                <!--end::details View-->

            </div>
            <div class="tab-pane" id="additional" role="tabpanel" aria-labelledby="all-tab"
                data-kt-timeline-widget-4-blockui="true">
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <!--begin::Alert-->
                    <div
                        class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10 row">
                        <!--begin::Wrapper-->
                        <div class="row col-12 pe-0 pe-sm-10">
                            <!--begin::Title-->
                            <h5 class="mb-1">Jenis Pemeriksaan</h5>
                            <!--end::Title-->
                            <div class="col-12">{{ $examination->service_category->name }}
                                <ul class="row">
                                    @foreach (service_examination($examination->id) as $service)
                                        <li class="col-4">{{ $service->service->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Alert-->

                    @if (isset($additionalexamination->id))
                        <form id="kt_modal_add_examinations_form" method="POST" class="form"
                            enctype="multipart/form-data"
                            action="{{ route('additionalexaminations.update', ['additionalexamination' => $additionalexamination->id]) }}">
                            @method('PUT')
                            {{ csrf_field() }}
                        @else
                            <form id="kt_modal_add_examinations_form" method="POST" class="form"
                                enctype="multipart/form-data" action="{{ route('additionalexaminations.store') }}">
                                @method('POST')
                                {{ csrf_field() }}
                    @endif
                    <input type="hidden" name="examination_id" value="{{ $examination->id }}">

                    @foreach ($additionalsscategories as $additionalscategory)
                        <h2 class="font-bold">{{ $additionalscategory->name }}</h2>
                        <ol style="margin-left:-10px">
                            @foreach (additionals($additionalscategory->id) as $additionals)
                                <li class="fw-normal text-base mb-6">
                                    <div class="row">
                                        <div class="col-4">
                                            {{ $additionals->name }}
                                            <input type="hidden" name="other[{{ $additionals->id }}]">
                                        </div>
                                        <div class="col-8">
                                            @php
                                                $options = json_decode($additionals->options);
                                                $option = [];
                                                if (isset($additionalexamination->id)) {
                                                    $option = json_decode(
                                                        $additionalexamination->additional_value,
                                                        true,
                                                    );
                                                }

                                            @endphp
                                            <div
                                                class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">

                                                @if (isset($options->additional))
                                                    @foreach ($options->additional as $additional)
                                                        @php
                                                            $adt = [];
                                                            if (isset($option[$additionals->id])) {
                                                                if (isset($option[$additionals->id]['additional'])) {
                                                                    $adt = $option[$additionals->id]['additional'];
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($additional->type == 'text' || $additional->type == 'number')

                                                            <input type="{{ $additional->type }}"
                                                                @if (isset($additional->id)) id="{{ $additional->id }}" @endif
                                                                value="{{ $adt[$additional->name] ?? '' }}"
                                                                name="additional[{{ $additionals->id }}][additional][{{ $additional->name }}]"
                                                                class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                                placeholder="{{ ucwords(str_replace('_', ' ', $additional->name)) }}" />
                                                        @elseif($additional->type == 'select')
                                                            <select
                                                                @if (isset($additional->id)) id="{{ $additional->id }}" @endif
                                                                name="additional[{{ $additionals->id }}][additional][{{ $additional->name }}]"
                                                                class="form-select form-select-solid border border-gray-300 mb-3 mb-lg-0">
                                                                @foreach (explode('_', $additional->value) as $option)
                                                                    <option value="{{ $option }}"
                                                                        @if (isset($adt[$additional->name])) @if ($adt[$additional->name] == $option)
                                                                                                    selected="selected" @endif
                                                                        @endif
                                                                        >{{ ucwords(str_replace('-', ' ', $option)) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    @endforeach

                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <a href="{{ route('examinations.index') }}" class="btn btn-sm btn-light-primary">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.5"
                                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                        fill="currentColor" />
                                    <path
                                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary" name="selesai" value="1"
                            data-kt-examinations-modal-action="submit">
                            <span class="indicator-label">Finish</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>

                        <button type="submit" class="btn btn-info" name="continue" value="1"
                            data-kt-examinations-modal-action="submit">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                    </form>

                </div>
                <!--end::details View-->

            </div>
            <div class="tab-pane d-none" id="examination" role="tabpanel" aria-labelledby="all-tab"
                data-kt-timeline-widget-4-blockui="true">
                <!--begin::Alert-->
                <div
                    class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column pe-0 pe-sm-10">
                        <!--begin::Title-->
                        <h5 class="mb-1">Jenis Pemeriksaan</h5>
                        <!--end::Title-->
                        <div class="col-10">{{ $examination->service_category->name }}
                            <ul class="row">
                                @foreach (service_examination($examination->id) as $service)
                                    <li class="col-4">{{ $service->service->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!--end::Wrapper-->

                    <div class="row col-12 pe-0 pe-sm-10">
                        <h5 class="mb-1">Vital Sign & BMI</h5>
                        <div class="row col-12">
                            <div class="row col-6">
                                <div class="col-12 row">
                                    <div class="col-4">Weight</div>
                                    <div class="col-8">: {{ $exam->vitality->weight ?? '-' }} Kg</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Height</div>
                                    <div class="col-8">: {{ $exam->vitality->height ?? '-' }} cm</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Body Mass Index</div>
                                    <div class="col-8">: {{ $exam->vitality->body_mass_index ?? '-' }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Ideal Weight</div>
                                    <div class="col-8">: {{ $exam->vitality->ideal_weight ?? '-' }} Kg</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Body Fat</div>
                                    <div class="col-8">: {{ $exam->vitality->body_fat ?? '-' }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">BMI Conclusion</div>
                                    <div class="col-8">: {{ $exam->vitality->bmi_conclusion ?? '-' }}</div>
                                </div>
                                <div class="col-12">&nbsp;</div>
                                <div class="col-12 row">
                                    <div class="col-4">Arm Circumference</div>
                                    <div class="col-8">: {{ $exam->vitality->arm_circumference ?? '-' }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Abdominal Circumference</div>
                                    <div class="col-8">: {{ $exam->vitality->adbdominal_circumference ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="row col-6">
                                <div class="col-12 row">
                                    <div class="col-4">Blood Pressure</div>
                                    <div class="col-8">: {{ $exam->vitality->blood_pressure ?? '-' }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Heart Rate</div>
                                    <div class="col-8">: {{ $exam->vitality->heart_rate ?? '-' }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Respiratory Rate</div>
                                    <div class="col-8">: {{ $exam->vitality->respiratory_rate ?? '-' }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Temperature</div>
                                    <div class="col-8">: {{ $exam->vitality->temperature ?? '-' }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Oxygen Saturation</div>
                                    <div class="col-8">: {{ $exam->vitality->oxygen_saturation ?? '-' }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Waist Circumference</div>
                                    <div class="col-8">: {{ $exam->vitality->waist_circumferennce ?? '-' }}</div>
                                </div>
                                <div class="col-12">&nbsp;</div>
                                <div class="col-12 row">
                                    <div class="col-4">Neck Circumference</div>
                                    <div class="col-8">: {{ $exam->vitality->neck_circumference ?? '-' }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Chest Size</div>
                                    <div class="col-8">: {{ $exam->vitality->chest_size ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Alert-->

                <form id="kt_modal_add_examinations_form" method="POST" class="form"
                    action="{{ route('examinations.update', ['examination' => $examination->id]) }}">
                    @method('PUT')
                    {{ csrf_field() }}
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column flex-row-fluid">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label
                                class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Health Profesional Type') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <select name="health_profesional_id" aria-label="{{ __('Health Profesional') }}"
                                    data-control="select2"
                                    data-placeholder="{{ __('Select a Health Profesional...') }}"
                                    class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Health Profesional...') }}</option>
                                    @foreach ($healthprofesionals as $healthprofesional)
                                        <option value="{{ $healthprofesional->id }}"
                                            {{ $healthprofesional->id === old('health_profesional_id', $examination->health_profesional_id ?? '') ? 'selected' : '' }}>
                                            @if (isset($healthprofesional->user->info))
                                                {{ ($healthprofesional->user->info->title_prefix != '' ? $healthprofesional->user->info->title_prefix . '. ' : '') . $healthprofesional->user->name . ($healthprofesional->user->info->title_suffix != '' ? ', ' . $healthprofesional->user->info->title_suffix : '') }}
                                            @else
                                                @if (isset($healthprofesional->user))
                                                    {{ $healthprofesional->user->name }}
                                                @endif
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Subjective</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <textarea name="subjective"
                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('subjective') is-invalid @enderror"
                                        placeholder="Subjective">{{ $examination->subjective }}</textarea>
                                </div>
                                @error('subjective')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Objective</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <textarea name="objective"
                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('objective') is-invalid @enderror"
                                        placeholder="Objective">{{ $examination->objective }}</textarea>
                                </div>
                                @error('objective')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Assessment</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <select id="icdtens" aria-label="{{ __('Select a Diagnosa') }}"
                                    data-control="select2" data-placeholder="{{ __('Select a Diagnosa...') }}"
                                    class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Diagnosa...') }}</option>
                                    @foreach ($icdtens as $icdten)
                                        <option value="{{ $icdten->id }}">
                                            {{ $icdten->code . ' ' . $icdten->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group input-group-solid has-validation mb-3 mt-3">
                                    <textarea name="assessment" id="assessment"
                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('assessment') is-invalid @enderror"
                                        placeholder="Assessment">{{ $examination->assessment }}</textarea>
                                </div>
                                @error('assessment')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span>{{ __('Plan') }}</span>

                            </label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <select name="plan_id" aria-label="{{ __('Select a Plan') }}"
                                    data-control="select2" data-placeholder="{{ __('Select a Plan...') }}"
                                    class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Plan...') }}</option>
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}"
                                            {{ $plan->id === old('plan_id', $examination->plan_id ?? '') ? 'selected' : '' }}>
                                            {{ $plan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Resep</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <textarea name="resep"
                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('resep') is-invalid @enderror"
                                        placeholder="Resep">{{ $examination->resep }}</textarea>
                                </div>
                                @error('resep')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <a href="{{ route('examinations.index') }}" class="btn btn-sm btn-light-primary">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.5"
                                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                        fill="currentColor" />
                                    <path
                                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary" data-kt-examinations-modal-action="submit">
                            <span class="indicator-label">Submit</span>
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
        const gender_id = {{ $info->gender->id }};
        const gender = "{{ $info->gender->name }}";
        const age = {{ \Carbon\Carbon::parse($info->date_of_birth)->age }};
        const blood_pressure = {{ $examination->vitality->blood_pressure ?? 0 }};
        const body_mass_index = {{ $examination->vitality->body_mass_index ?? 0 }};

        $(function() {
            $assesment = $("#assessment").html();
            $("#icdtens").change(function() {
                $("#assessment").append($(this).find("option:selected").text() + '\n');
            });

            $("#farmingage").val(age);
            $("#farmingscoreage").val(farmingScoreAge(age));

            $("#farmingage").change(function() {
                $("#farmingscoreage").val(farmingScoreAge($(this).val()));
            });

            if (gender_id == 1) {
                $("#farming_diabetes_melitus").val() == "yes" ? $("#farming_score_diabetes_melitus").val(2) : $(
                    "#farming_score_diabetes_melitus").val(0);
            } else {
                $("#farming_diabetes_melitus").val() == "yes" ? $("#farming_score_diabetes_melitus").val(4) : $(
                    "#farming_score_diabetes_melitus").val(0);
            }
            $("#farming_diabetes_melitus").change(function() {
                if ($(this).val().toLowerCase() == "yes") {
                    if (gender_id == 1) {
                        $("#farming_score_diabetes_melitus").val(2);
                    } else {
                        $("#farming_score_diabetes_melitus").val(4);
                    }
                } else {
                    $("#farming_score_diabetes_melitus").val(0);
                }
            });

            $("#farmig_score_total_cholesterol").val(farmingScoreTotalColesterol($("#total_cholesterol").val(),
                gender_id));
            $("#total_cholesterol").change(function() {
                $("#farmig_score_total_cholesterol").val(farmingScoreTotalColesterol($(this).val(),
                    gender_id));
            });

            $("#farming_score_hdl_cholesterol").val(farmingScoreHdlColesterol($("#hdl_cholesterol").val(),
                gender_id));
            $("#hdl_cholesterol").change(function() {
                $("#farming_score_hdl_cholesterol").val(farmingScoreHdlColesterol($(this).val(),
                    gender_id));
            });

            $("#farming_score_systolic_blood_pressure").val(farmingScoreSystolicBloodPlessure($(
                "#systolic_blood_pressure").val(), gender_id));
            $("#systolic_blood_pressure").change(function() {
                $("#farming_score_systolic_blood_pressure").val(farmingScoreSystolicBloodPlessure($(this)
                    .val(), gender_id));
            });

            $("#farming_smoking").val() == "yes" ? $("#farming_score_smoking").val(2) : $("#farming_score_smoking")
                .val(0);
            $("#farming_smoking").change(function() {
                $(this).val() == "yes" ? $("#farming_score_smoking").val(2) : $("#farming_score_smoking")
                    .val(0);
            });

            $("#sex").val(gender);
            $("#score_sex").val(gender_id == 1 ? 1 : 0);
            $("#sex").change(function() {
                if ($(this).val().toLowerCase() == 0 || $(this).val().toLowerCase() == "female" || $(this)
                    .val().toLowerCase() == "wanita" || $(this).val().toLowerCase() == "perempuan") {
                    $("#score_sex").val(0);
                } else {
                    $("#score_sex").val(1);
                }
            });

            $("#cardioage").val(age);
            $("#cardioscoreage").val(cardioScoreAge(age));
            $("#cardioage").change(function() {
                $("#cardioscoreage").val(cardioScoreAge($(this).val()));
            });

            if (blood_pressure < 120) {
                $("#blood_pressure").val("normal");
                $("#cardio_score_blood_pressure").val(0);
            } else if (blood_pressure < 129) {
                $("#blood_pressure").val("high-normal");
                $("#cardio_score_blood_pressure").val(1);
            } else if (blood_pressure < 139) {
                $("#blood_pressure").val("grade-1-hypertension");
                $("#cardio_score_blood_pressure").val(2);
            } else if (blood_pressure > 140) {
                $("#blood_pressure").val("grade-2-hypertension");
                $("#cardio_score_blood_pressure").val(3);
            } else if (blood_pressure < 180) {
                $("#blood_pressure").val("grade-3-hypertension");
                $("#cardio_score_blood_pressure").val(4);
            }

            $("#blood_pressure").change(function() {
                if ($(this).val().toLowerCase() == "normal") {
                    $("#cardio_score_blood_pressure").val(0);
                } else if ($(this).val().toLowerCase() == "high-normal") {
                    $("#cardio_score_blood_pressure").val(1);
                } else if ($(this).val().toLowerCase() == "grade-1-hypertension") {
                    $("#cardio_score_blood_pressure").val(2);
                } else if ($(this).val().toLowerCase() == "grade-2-hypertension") {
                    $("#cardio_score_blood_pressure").val(3);
                } else if ($(this).val().toLowerCase() == "grade-3-hypertension") {
                    $("#cardio_score_blood_pressure").val(4);
                }
            });

            $("#body_mass_index").val(body_mass_index);
            $("#cardio_score_body_mass_index").val(cardioScoreBodyMassIndex(body_mass_index));
            $("#body_mass_index").change(function() {
                $("#cardio_score_body_mass_index").val(cardioScoreBodyMassIndex($(this).val()));
            });

            if ($("#cardio_smoking").val().toLowerCase() == "never") {
                $("#cardio_score_smoking").val(0);
            } else if ($("#cardio_smoking").val().toLowerCase() == "ex-smoker") {
                $("#cardio_score_smoking").val(3);
            } else if ($("#cardio_smoking").val().toLowerCase() == "smoker") {
                $("#cardio_score_smoking").val(4);
            }
            $("#cardio_smoking").change(function() {
                if ($(this).val().toLowerCase() == "never") {
                    $("#cardio_score_smoking").val(0);
                } else if ($(this).val().toLowerCase() == "ex-smoker") {
                    $("#cardio_score_smoking").val(3);
                } else if ($(this).val().toLowerCase() == "smoker") {
                    $("#cardio_score_smoking").val(4);
                }
            });

            $("#cardio_diabetes_melitus").val() == "yes" ? $("#cardio_score_diabetes_melitus").val(2) : $(
                "#cardio_score_diabetes_melitus").val(0);
            $("#cardio_diabetes_melitus").change(function() {
                if ($(this).val().toLowerCase() == "yes") {
                    $("#cardio_score_diabetes_melitus").val(2);
                } else {
                    $("#cardio_score_diabetes_melitus").val(0);
                }
            });

            if ($("#phyisical_exercise").val().toLowerCase() == "no") {
                $("#cardio_score_phyisical_exercise").val(2);
            } else if ($("#phyisical_exercise").val().toLowerCase() == "low") {
                $("#cardio_score_phyisical_exercise").val(1);
            } else if ($("#phyisical_exercise").val().toLowerCase() == "medium") {
                $("#cardio_score_phyisical_exercise").val(0);
            } else if ($("#phyisical_exercise").val().toLowerCase() == "high") {
                $("#cardio_score_phyisical_exercise").val(-3);
            }
            $("#phyisical_exercise").change(function() {
                if ($(this).val().toLowerCase() == "no") {
                    $("#cardio_score_phyisical_exercise").val(2);
                } else if ($(this).val().toLowerCase() == "low") {
                    $("#cardio_score_phyisical_exercise").val(1);
                } else if ($(this).val().toLowerCase() == "medium") {
                    $("#cardio_score_phyisical_exercise").val(0);
                } else if ($(this).val().toLowerCase() == "high") {
                    $("#cardio_score_phyisical_exercise").val(-3);
                }
            });
        });



        function farmingScoreAge(age) {
            if (age < 35) {
                if (gender_id == 1) {
                    return -1;
                } else {
                    return -9;
                }
            } else if (age <= 39) {
                if (gender_id == 1) {
                    return 0;
                } else {
                    return -4;
                }
            } else if (age <= 44) {
                if (gender_id == 1) {
                    return 1;
                } else {
                    return 0;
                }
            } else if (age <= 49) {
                if (gender_id == 1) {
                    return 2;
                } else {
                    return 3;
                }
            } else if (age <= 54) {
                if (gender_id == 1) {
                    return 3;
                } else {
                    return 6;
                }
            } else if (age <= 59) {
                if (gender_id == 1) {
                    return 4;
                } else {
                    return 7;
                }
            } else if (age <= 65) {
                if (gender_id == 1) {
                    return 5;
                } else {
                    return 8;
                }
            } else if (age <= 69) {
                if (gender_id == 1) {
                    return 6;
                } else {
                    return 8;
                }
            } else if (age <= 74) {
                if (gender_id == 1) {
                    return 7;
                } else {
                    return 8;
                }
            }
        }

        function farmingScoreTotalColesterol(score, gender) {
            if (score < 160) {
                return gender == 1 ? -3 : -2;
            } else if (score >= 169 && score <= 199) {
                return 0;
            } else if (score >= 200 && score <= 239) {
                return 1;
            } else if (score >= 240 && score <= 279) {
                return 2;
            } else if (score >= 280) {
                return 3;
            }
        }

        function farmingScoreHdlColesterol(score, gender) {
            if (score >= 60) {
                return gender == 1 ? -2 : -3;
            } else if (score >= 50 && score <= 59) {
                return 0;
            } else if (score >= 45 && score <= 49) {
                return gender == 1 ? 0 : 1;
            } else if (score >= 35 && score <= 44) {
                return gender == 1 ? 1 : 2;
            } else if (score <= 35) {
                return gender == 1 ? 2 : 5;
            }
        }

        function farmingScoreSystolicBloodPlessure(score, gender) {
            if (score < 120) {
                return gender == 1 ? 0 : -3;
            } else if (score >= 120 && score <= 129) {
                return 0;
            } else if (score >= 130 && score <= 139) {
                return 1;
            } else if (score >= 140 && score <= 159) {
                return 2;
            } else if (score >= 160) {
                return 3;
            }
        }

        function cardioScoreBodyMassIndex(bmi) {
            if (bmi >= 13.79 && bmi <= 25.99) {
                return 0;
            } else if (bmi >= 26 && bmi <= 29.99) {
                return 1;
            } else if (bmi >= 30 && bmi <= 35.58) {
                return 2;
            }
        }

        function cardioScoreAge(age) {
            if (age >= 25 && age <= 34) {
                return -4;
            } else if (age >= 35 && age <= 39) {
                return -3;
            } else if (age >= 40 && age <= 44) {
                return -2;
            } else if (age >= 45 && age <= 49) {
                return 0;
            } else if (age >= 50 && age <= 54) {
                return 1;
            } else if (age >= 55 && age <= 59) {
                return 2;
            } else if (age >= 60 && age <= 64) {
                return 3;
            }
        }
    </script>
@endpush
