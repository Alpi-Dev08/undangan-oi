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
            <div class="tab-pane" id="user" role="tabpanel" aria-labelledby="all-tab"
                 data-kt-timeline-widget-4-blockui="true">
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <!--end::Name-->
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted"></label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                    <img
                                        src="{!!  $user->avatar_url !='' ? $user->avatar_url : asset(theme()->getMediaUrlPath().'photos/blank.png') !!}"
                                        alt="image"/>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Patien ID') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $user->patient->patient_code }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Medical Record') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $user->mr->medical_record_code }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Card Type') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span
                                    class="fw-bold fs-6">{{ isset($info->card_type_id) ? $info->card->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Card Type') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span
                                    class="fw-bold fs-6">{{ isset($info->card_type_id) ? $info->card->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Full Name') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span
                                    class="fw-bold fs-6">{{ ($info->title_prefix !='' ? $info->title_prefix.'. ' : '').$user->name.($info->title_suffix!='' ? ', '.$info->title_suffix : '') }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Card Number') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->card_number }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Full Name') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                <span
                    class="fw-bolder fs-6 text-dark">{{ ($info->title_prefix !='' ? $info->title_prefix.'. ' : '').$user->name.($info->title_suffix!='' ? ', '.$info->title_suffix : '') }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Email') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $user->email }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">
                                {{ __('Contact Phone') }}
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                   title="Phone number must be active"></i>
                            </label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 d-flex align-items-center">
                                <span class="fw-bolder fs-6 me-2">{{ $user->phone }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Place and date of Birth') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->place_of_birth.', '.$info->date_of_birth }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Religion') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span
                                    class="fw-bold fs-6">{{ isset($info->religion) ? $info->religion->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Gender') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ isset($info->gender) ? $info->gender->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Marital Status') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span
                                    class="fw-bold fs-6">{{ isset($info->marital_status_id) ? $info->marital->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Education') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span
                                    class="fw-bold fs-6">{{ isset($info->education_id) ? $info->education->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Work') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ isset($info->work_id) ? $info->work->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Blood Type') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span
                                    class="fw-bold fs-6">{{ isset($info->blood_type_id) ? $info->blood->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Weight') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->weight }} Kg</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Height') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->height}} cm</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Address') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <a href="#"
                                   class="fw-bold fs-6 text-dark text-hover-primary">{{ $info->address }}{{ isset($info->subdistrict) ? ', '.$info->subdistrict->name : '' }}{{ isset($info->district) ? ', '.$info->district->name : '' }}{{ isset($info->city) ? ', '.$info->city->name : '' }}{{ isset($info->province) ? ', '.$info->province->name : '' }}{{ isset($info->country) ? ', '.$info->country->name : '' }}{{ $info->postal_code!='' ? $info->postal_code : (isset($info->subdistrict) ? ' - '.$info->subdistrict->postal_code : '') }}</a>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Patient Trustee Name') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->patient_trustee_name ?? "" }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Company Name') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->company_name ?? "" }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Date of Hire') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->date_of_hire ?? "" }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Job Title') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->job_title ?? "" }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Division') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->division ?? "" }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Department') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->department ?? "" }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Section') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->section ?? "" }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Employee ID') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->employee_id ?? "" }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Kind of Job') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->kind_of_job ?? "" }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Shift') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->shift ?? "" }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::details View-->
            </div>

            <div class="tab-pane" id="medicalrecord" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <div class="timeline-label">
                        @foreach($examinations as $exam)
                            <!--begin::Item-->
                            <div class="timeline-item">
                                <!--begin::Label-->
                                <div class="timeline-label fw-bold text-gray-800 fs-6">{{ $exam->created_at->format("d F Y") }} <br>{{ $exam->created_at->format("H:i:s") }}</div>
                                <!--end::Label-->
                                <!--begin::Badge-->
                                <div class="timeline-badge">
                                    @php
                                        $array = array('success', 'primary', 'warning', 'danger', 'info', 'dark');
                                        $color = array_rand($array,1);
                                    @endphp
                                    <i class="fa fa-genderless text-{{ $array[$color] }} fs-1"></i>
                                </div>
                                <!--end::Badge-->
                                <!--begin::Text-->
                                <div class="fw-mormal timeline-content text-muted ps-3">
                                    <div class="row p-2 border border-gray-200 bg-gray-100 rounded">
                                        <div class="col-12 row">
                                            <div class="col-2 fw-bolder">Medical Record</div>
                                            <div class="col-10">: {{ $user->mr->medical_record_code }}</div>
                                        </div>
                                        <div class="col-12 row">
                                            <div class="col-2 fw-bolder">Examination Code</div>
                                            <div class="col-10">: {{ $exam->examination_code }}</div>
                                        </div>
                                        <div class="col-12 row">
                                            <div class="col-2 fw-bolder">Full Name</div>
                                            <div class="col-10">: {{ $user->name }}</div>
                                        </div>
                                        <div class="col-12 row">
                                            <div class="col-2 fw-bolder">Doctor</div>
                                            <div class="col-10">: {{ $exam->health_profesional->user->name }}</div>
                                        </div>
                                        <div class="col-12 row">
                                            <div class="col-2 fw-bolder">Jenis Pemeriksaan</div>
                                            <div class="col-10">: {{ $exam->service_category->name }}
                                                <ul class="row">
                                                    @foreach(service_examination($exam->id) as $service)
                                                        <li class="col-4">{{ $service->service->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row p-2 border border-gray-200 bg-gray-100 rounded">
                                        <h5 class="mb-1">Vital Sign & BMI</h5>
                                        <div class="row col-12">
                                            <div class="row col-4">
                                                <div class="col-12 row">
                                                    <div class="col-4">Weight</div>
                                                    <div class="col-8">: {{ $exam->vitality->weight ?? "-" }} Kg</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">Height</div>
                                                    <div class="col-8">: {{ $exam->vitality->height ?? "-" }} cm</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">Body Mass Index</div>
                                                    <div class="col-8">: {{ $exam->vitality->body_mass_index ?? "-" }}</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">Ideal Weight</div>
                                                    <div class="col-8">: {{ $exam->vitality->ideal_weight ?? "-" }} Kg</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">Body Fat</div>
                                                    <div class="col-8">: {{ $exam->vitality->body_fat ?? "-" }}</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">BMI Conclusion</div>
                                                    <div class="col-8">: {{ $exam->vitality->bmi_conclusion ?? "-" }}</div>
                                                </div>
                                            </div>
                                            <div class="row col-4">
                                                <div class="col-12 row">
                                                    <div class="col-4">Blood Pressure</div>
                                                    <div class="col-8">: {{ $exam->vitality->blood_pressure ?? "-" }}</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">Heart Rate</div>
                                                    <div class="col-8">: {{ $exam->vitality->heart_rate ?? "-" }}</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">Respiratory Rate</div>
                                                    <div class="col-8">: {{ $exam->vitality->respiratory_rate ?? "-" }}</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">Temperature</div>
                                                    <div class="col-8">: {{ $exam->vitality->temperature ?? "-" }}</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">Oxygen Saturation</div>
                                                    <div class="col-8">: {{ $exam->vitality->oxygen_saturation ?? "-" }}</div>
                                                </div>
                                            </div>
                                            <div class="row col-4">
                                                <div class="col-12 row">
                                                    <div class="col-4">Waist Circumference</div>
                                                    <div class="col-8">: {{ $exam->vitality->waist_circumferennce ?? "-" }}</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">Neck Circumference</div>
                                                    <div class="col-8">: {{ $exam->vitality->neck_circumference ?? "-" }}</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">Arm Circumference</div>
                                                    <div class="col-8">: {{ $exam->vitality->arm_circumference ?? "-" }}</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">Chest Size</div>
                                                    <div class="col-8">: {{ $exam->vitality->chest_size ?? "-" }}</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">Abdominal Circumference</div>
                                                    <div class="col-8">: {{ $exam->vitality->adbdominal_circumference ?? "-" }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        @if($exam->service_category->is_mcu == 1)
                                            <h5 class="col-12">Check up Result</h5>
                                            @if(isset($exam->anamnesis->anamnesis_value))
                                                <h3 class="col-12">1. Anamnesis</h3>
                                                @php
                                                    $anamnesis = json_decode($exam->anamnesis->anamnesis_value);
                                                    $header = '';
                                                @endphp
                                                @foreach($anamnesis as $key => $value)
                                                    @php
                                                        $radio = '';
                                                        if(isset($value->radio)){
                                                            $radio = json_decode(json_encode($value->radio),true);
                                                            $radioKeys = array_keys($radio);
                                                        }
                                                        $additional = json_decode(json_encode($value->additional),true);
                                                        $additionalKeys = array_keys($additional);
                                                    @endphp

                                                    @if($radio && $additional[$additionalKeys[0]])
                                                        @if($header != getAnamnesis($key)->anamnesis_category_id)
                                                            <div class="col-12" style="padding-left:35px">{{ getAnamnesisCategory(getAnamnesis($key)->anamnesis_category_id)->name }}</div>
                                                            @php $header = getAnamnesis($key)->anamnesis_category_id; @endphp
                                                        @endif
                                                        <div class="col-12 row">
                                                            <div class="col-4 fw-bold" style="padding-left:50px">{{getAnamnesis($key)->name }}</div>
                                                            <div class="col-8">: {{ ucwords($radio[$radioKeys[0]]).', '.$additional[$additionalKeys[0]] }}</div>
                                                        </div>
                                                    @elseif($radio)
                                                        @if($header != getAnamnesis($key)->anamnesis_category_id)
                                                            <div class="col-12" style="padding-left:35px">{{ getAnamnesisCategory(getAnamnesis($key)->anamnesis_category_id)->name }}</div>
                                                            @php $header = getAnamnesis($key)->anamnesis_category_id; @endphp
                                                        @endif
                                                        <div class="col-12 row">
                                                            <div class="col-4 fw-bold" style="padding-left:50px">{{getAnamnesis($key)->name }}</div>
                                                            <div class="col-8">: {{ ucwords($radio[$radioKeys[0]])}}</div>
                                                        </div>
                                                    @elseif($additional[$additionalKeys[0]])
                                                        @if($header != getAnamnesis($key)->anamnesis_category_id)
                                                            <div class="col-12" style="padding-left:35px">{{ getAnamnesisCategory(getAnamnesis($key)->anamnesis_category_id)->name }}</div>
                                                            @php $header = getAnamnesis($key)->anamnesis_category_id; @endphp
                                                        @endif
                                                        <div class="col-12 row">
                                                            <div class="col-4 fw-bold" style="padding-left:50px">{{getAnamnesis($key)->name }}</div>
                                                            <div class="col-8">: {{$additional[$additionalKeys[0]] }}</div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if(isset($exam->physical->physical_value))
                                                <h3 class="col-12">2. Physical</h3>
                                                @php
                                                    $physicals = json_decode($exam->physical->physical_value);
                                                    $header = '';
                                                @endphp
                                                @foreach($physicals as $key => $value)
                                                    @php
                                                        $radio = '';
                                                        if(isset($value->radio)){
                                                            $radio = json_decode(json_encode($value->radio),true);
                                                            $radioKeys = array_keys($radio);
                                                        }
                                                        $additional = json_decode(json_encode($value->additional),true);
                                                        $additionalKeys = array_keys($additional);
                                                    @endphp

                                                    @if($radio && $additional[$additionalKeys[0]])
                                                        @if($header != getPhysicals($key)->physical_category_id)
                                                            <div class="col-12" style="padding-left:35px">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</div>
                                                            @php $header = getPhysicals($key)->physical_category_id; @endphp
                                                        @endif
                                                        <div class="col-12 row">
                                                            <div class="col-4 fw-bold" style="padding-left:50px">{{getPhysicals($key)->name }}</div>
                                                            <div class="col-8">: {{ ucwords($radio[$radioKeys[0]]).', '.$additional[$additionalKeys[0]] }}</div>
                                                        </div>
                                                    @elseif($radio)
                                                        @if($header != getPhysicals($key)->physical_category_id)
                                                            <div class="col-12" style="padding-left:35px">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</div>
                                                            @php $header = getPhysicals($key)->physical_category_id; @endphp
                                                        @endif
                                                        <div class="col-12 row">
                                                            <div class="col-4 fw-bold" style="padding-left:50px">{{getPhysicals($key)->name }}</div>
                                                            <div class="col-8">: {{ ucwords($radio[$radioKeys[0]])}}</div>
                                                        </div>
                                                    @elseif($additional[$additionalKeys[0]])
                                                        @if($header != getPhysicals($key)->physical_category_id)
                                                            <div class="col-12" style="padding-left:35px">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</div>
                                                            @php $header = getPhysicals($key)->physical_category_id; @endphp
                                                        @endif
                                                        <div class="col-12 row">
                                                            <div class="col-4 fw-bold" style="padding-left:50px">{{getPhysicals($key)->name }}</div>
                                                            <div class="col-8">: {{$additional[$additionalKeys[0]] }}</div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if(isset($exam->other->other_value))
                                                <h3 class="col-12">3. Other</h3>
                                                @php
                                                    $others = json_decode($exam->other->other_value);
                                                    $header = '';
                                                @endphp
                                                @foreach($others as $key => $value)
                                                    @php
                                                        $radio = '';
                                                        if(isset($value->radio)){
                                                            $radio = json_decode(json_encode($value->radio),true);
                                                            $radioKeys = array_keys($radio);
                                                        }
                                                        $additional = json_decode(json_encode($value->additional),true);
                                                        $additionalKeys = array_keys($additional);
                                                    @endphp

                                                    @if($radio && $additional[$additionalKeys[0]])
                                                        @if($header != getPhysicals($key)->anamnesis_category_id)
                                                            <div class="col-12" style="padding-left:35px">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</div>
                                                            @php $header = getPhysicals($key)->physical_category_id; @endphp
                                                        @endif
                                                        <div class="col-12 row">
                                                            <div class="col-4 fw-bold" style="padding-left:50px">{{getPhysicals($key)->name }}</div>
                                                            <div class="col-8">: {{ ucwords($radio[$radioKeys[0]]).', '.$additional[$additionalKeys[0]] }}</div>
                                                        </div>
                                                    @elseif($radio)
                                                        @if($header != getPhysicals($key)->physical_category_id)
                                                            <div class="col-12" style="padding-left:35px">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</div>
                                                            @php $header = getPhysicals($key)->physical_category_id; @endphp
                                                        @endif
                                                        <div class="col-12 row">
                                                            <div class="col-4 fw-bold" style="padding-left:50px">{{getPhysicals($key)->name }}</div>
                                                            <div class="col-8">: {{ ucwords($radio[$radioKeys[0]])}}</div>
                                                        </div>
                                                    @elseif($additional[$additionalKeys[0]])
                                                        @if($header != getPhysicals($key)->physical_category_id)
                                                            <div class="col-12" style="padding-left:35px">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</div>
                                                            @php $header = getPhysicals($key)->physical_category_id; @endphp
                                                        @endif
                                                        <div class="col-12 row">
                                                            <div class="col-4 fw-bold" style="padding-left:50px">{{getPhysicals($key)->name }}</div>
                                                            <div class="col-8">: {{$additional[$additionalKeys[0]] }}</div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                <div class="col-12 row mt-5">
                                                    <div class="col-4 fw-bold" style="padding-left:35px">Result</div>
                                                    <div class="col-8">: {{ $exam->other->result  }}</div>
                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4 fw-bold" style="padding-left:35px">Description</div>
                                                    <div class="col-8">: {{$exam->other->description }}</div>
                                                </div>
                                            @endif
                                        @else
                                            <h5 class="col-12">Check up Result</h5>
                                            <div class="col-12 row">
                                                <div class="col-2 fw-bolder">Subjective</div>
                                                <div class="col-10">: {{ $exam->subjective }}</div>
                                            </div>
                                            <div class="col-12 row">
                                                <div class="col-2 fw-bolder">Objective</div>
                                                <div class="col-10">: {{ $exam->objective }}</div>
                                            </div>
                                            <div class="col-12 row">
                                                <div class="col-2 fw-bolder">Assessment</div>
                                                <div class="col-10">: {{ $exam->assessment }}</div>
                                            </div>
                                            <div class="col-12 row">
                                                <div class="col-2 fw-bolder">Plan</div>
                                                <div class="col-10">: {{ $exam->plan }}</div>
                                            </div>
                                            <div class="col-12 row">
                                                <div class="col-2 fw-bolder">Resep</div>
                                                <div class="col-10">: {{ $exam->resep }}</div>
                                            </div>
                                        @endif;
                                    </div>

                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Item-->
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="tab-pane active" id="anamnesis" role="tabpanel" aria-labelledby="all-tab"
                 data-kt-timeline-widget-4-blockui="true">
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <!--begin::Alert-->
                    <div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10 row">
                        <!--begin::Wrapper-->
                        <div class="row col-12 pe-0 pe-sm-10">
                            <!--begin::Title-->
                            <h5 class="mb-1">Jenis Pemeriksaan</h5>
                            <!--end::Title-->
                            <div class="col-12">{{ $examination->service_category->name }}
                                <ul class="row">
                                    @foreach(service_examination($examination->id) as $service)
                                        <li class="col-4">{{ $service->service->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Alert-->

                    @if(isset($anamnesisexamination->id))
                        <form id="kt_modal_add_examinations_form" method="POST" class="form"
                              action="{{ route('anamnesisexaminations.update',['anamnesisexamination' => $anamnesisexamination->id]) }}">
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
                                        <textarea id="request" name="request" row="5" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('request') is-invalid @enderror" placeholder="Present Complaint / Keluhan Saat Ini">{{ $anamnesisexamination->request ?? "" }}</textarea>
                                        @error('request')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <ol type="I" style="margin-left:-25px">
                                        @foreach($anamnesiscategories as $anamnesiscategory)
                                            <li class="fw-bolder text-lg">
                                                {{$anamnesiscategory->name}}
                                                <ol>
                                                    @foreach(anamnesis($anamnesiscategory->id) as $anamnesis)
                                                        <li class="fw-normal text-base mb-6">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    {{$anamnesis->name}}
                                                                    <input type="hidden" name="anamnesis[{{$anamnesis->id}}]">
                                                                </div>
                                                                <div class="col-6">
                                                                    @php
                                                                        $options = json_decode($anamnesis->options);
																		$option = [];
																		if(isset($anamnesisexamination->anamnesis_value)){
                                                                            $option = json_decode($anamnesisexamination->anamnesis_value,true);
																		}

                                                                    @endphp
                                                                    <div
                                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                                        @if(isset($options->radio))
                                                                            @foreach($options->radio as $radio)
                                                                                @php
                                                                                    $r=[];
                                                                                    if(isset($option[$anamnesis->id])){
                                                                                        if(isset($option[$anamnesis->id]['radio'])){
                                                                                            $r = $option[$anamnesis->id]['radio'];
                                                                                        }

                                                                                    }
                                                                                @endphp
                                                                                <div
                                                                                    class="form-check form-check-custom form-check-solid">
                                                                                    <input class="form-check-input"
                                                                                           type="checkbox"
                                                                                           {{ in_array($radio->id,$r) ? 'checked' : '' }}
                                                                                           name = "anamnesis[{{$anamnesis->id}}][radio][{{$radio->id}}]"
                                                                                           value="{{$radio->id}}"
                                                                                           id="radio-{{$anamnesis->id}}"/>
                                                                                    <label class="form-check-label"
                                                                                           for="radio-{{$anamnesis->id}}">
                                                                                        {{$radio->value}}
                                                                                    </label>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                        @if(isset($options->additional))
                                                                            @foreach($options->additional as $additional)
                                                                                    @php
                                                                                        $adt=[];
                                                                                        if(isset($option[$anamnesis->id])){
                                                                                            if(isset($option[$anamnesis->id]['additional'])){
                                                                                             $adt = $option[$anamnesis->id]['additional'];
                                                                                             }
                                                                                        }
                                                                                    @endphp
                                                                                @if($additional->type == "text")
                                                                                    <input type="text"
                                                                                           value="{{ $adt[$additional->name] ?? '' }}"
                                                                                           name="anamnesis[{{$anamnesis->id}}][additional][{{$additional->name}}]"
                                                                                           class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                                                           placeholder="{{ ucwords($additional->name)}}"/>
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
                                        <a href="{{ route('examinations.index')  }}"
                                           class="btn btn-sm btn-light-primary">
                                            <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.5"
                                                          d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                                          fill="currentColor"/>
                                                    <path
                                                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                                        fill="currentColor"/>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary" name="selesai" value="1" data-kt-examinations-modal-action="submit">
                                            <span class="indicator-label">Finish</span>
                                            <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>

                                        <button type="submit" class="btn btn-info" name="continue" value="1" data-kt-examinations-modal-action="submit">
                                            <span class="indicator-label">Continue</span>
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
            <div class="tab-pane" id="physical" role="tabpanel" aria-labelledby="all-tab"
                 data-kt-timeline-widget-4-blockui="true">
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <!--begin::Alert-->
                    <div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10 row">
                        <!--begin::Wrapper-->
                        <div class="row col-12 pe-0 pe-sm-10">
                            <!--begin::Title-->
                            <h5 class="mb-1">Jenis Pemeriksaan</h5>
                            <!--end::Title-->
                            <div class="col-12">{{ $examination->service_category->name }}
                                <ul class="row">
                                    @foreach(service_examination($examination->id) as $service)
                                        <li class="col-4">{{ $service->service->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                        <div class="row col-12 pe-0 pe-sm-10">
                            <h5 class="mb-1">Vital Sign & BMI</h5>
                            <div class="row col-12">
                                <div class="row col-4">
                                    <div class="col-12 row">
                                        <div class="col-4">Weight</div>
                                        <div class="col-8">: {{ $exam->vitality->weight ?? "-" }} Kg</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">Height</div>
                                        <div class="col-8">: {{ $exam->vitality->height ?? "-" }} cm</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">Body Mass Index</div>
                                        <div class="col-8">: {{ $exam->vitality->body_mass_index ?? "-" }}</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">Ideal Weight</div>
                                        <div class="col-8">: {{ $exam->vitality->ideal_weight ?? "-" }} Kg</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">Body Fat</div>
                                        <div class="col-8">: {{ $exam->vitality->body_fat ?? "-" }}</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">BMI Conclusion</div>
                                        <div class="col-8">: {{ $exam->vitality->bmi_conclusion ?? "-" }}</div>
                                    </div>
                                </div>
                                <div class="row col-4">
                                    <div class="col-12 row">
                                        <div class="col-4">Blood Pressure</div>
                                        <div class="col-8">: {{ $exam->vitality->blood_pressure ?? "-" }}</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">Heart Rate</div>
                                        <div class="col-8">: {{ $exam->vitality->heart_rate ?? "-" }}</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">Respiratory Rate</div>
                                        <div class="col-8">: {{ $exam->vitality->respiratory_rate ?? "-" }}</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">Temperature</div>
                                        <div class="col-8">: {{ $exam->vitality->temperature ?? "-" }}</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">Oxygen Saturation</div>
                                        <div class="col-8">: {{ $exam->vitality->oxygen_saturation ?? "-" }}</div>
                                    </div>
                                </div>
                                <div class="row col-4">
                                    <div class="col-12 row">
                                        <div class="col-4">Waist Circumference</div>
                                        <div class="col-8">: {{ $exam->vitality->waist_circumferennce ?? "-" }}</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">Neck Circumference</div>
                                        <div class="col-8">: {{ $exam->vitality->neck_circumference ?? "-" }}</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">Arm Circumference</div>
                                        <div class="col-8">: {{ $exam->vitality->arm_circumference ?? "-" }}</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">Chest Size</div>
                                        <div class="col-8">: {{ $exam->vitality->chest_size ?? "-" }}</div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-4">Abdominal Circumference</div>
                                        <div class="col-8">: {{ $exam->vitality->adbdominal_circumference ?? "-" }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Alert-->

                    @if(isset($physicalexamination->id))
                        <form id="kt_modal_add_examinations_form" method="POST" class="form"
                              action="{{ route('physicalexaminations.update',['physicalexamination' => $physicalexamination->id]) }}">
                            @method('PUT')
                            {{ csrf_field() }}
                            @else
                                <form id="kt_modal_add_examinations_form" method="POST" class="form"
                                      action="{{ route('physicalexaminations.store') }}">
                                    @method('POST')
                                    {{ csrf_field() }}
                                    @endif
                                    <input type="hidden" name="examination_id" value="{{ $examination->id }}">

                                        @foreach($physicalscategories as $physicalscategory)
                                        <h2 class="font-bold">{{$physicalscategory->name}}</h2>
                                                <ol style="margin-left:-10px">
                                                    @foreach(physicals($physicalscategory->id) as $physicals)
                                                        <li class="fw-normal text-base mb-6">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    {{$physicals->name}}
                                                                    <input type="hidden" name="physical[{{$physicals->id}}]">
                                                                </div>
                                                                <div class="col-8">
                                                                    @php
                                                                        $options = json_decode($physicals->options);
                                                                        $option = [];
                                                                        if(isset($physicalexamination->id)){
                                                                            $option = json_decode($physicalexamination->physical_value,true);
                                                                        }

                                                                    @endphp
                                                                    <div
                                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                                        @if(isset($options->radio))
                                                                            @foreach($options->radio as $radio)
                                                                                @php
                                                                                    $r=[];
                                                                                    if(isset($option[$physicals->id])){
                                                                                        if(isset($option[$physicals->id]['radio'])){
                                                                                            $r = $option[$physicals->id]['radio'];
                                                                                        }

                                                                                    }
                                                                                @endphp
                                                                                <div
                                                                                    class="form-check form-check-custom form-check-solid w-200px">
                                                                                    <input class="form-check-input"
                                                                                           type="checkbox"
                                                                                           {{ in_array($radio->id,$r) ? 'checked' : '' }}
                                                                                           name = "physical[{{$physicals->id}}][radio][{{$radio->id}}]"
                                                                                           value="{{$radio->id}}"
                                                                                           id="radio-{{$physicals->id}}"/>
                                                                                    <label class="form-check-label"
                                                                                           for="radio-{{$physicals->id}}">
                                                                                        {{$radio->value}}
                                                                                    </label>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                        @if(isset($options->additional))
                                                                            @foreach($options->additional as $additional)
                                                                                @php
                                                                                    $adt=[];
                                                                                    if(isset($option[$anamnesis->id])){
                                                                                        if(isset($option[$physicals->id]['additional'])){
                                                                                         $adt = $option[$physicals->id]['additional'];
                                                                                         }
                                                                                    }
                                                                                @endphp
                                                                                @if($additional->type == "text")
                                                                                    <input type="text"
                                                                                           value="{{ $adt[$additional->name] ?? '' }}"
                                                                                           name="physical[{{$physicals->id}}][additional][{{$additional->name}}]"
                                                                                           class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                                                           placeholder="{{ucwords($additional->name)}}"/>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    @if($physicals->id==65)
                                                                        <!--begin::Alert-->
                                                                        <div class="alert alert-dismissible bg-light-info border border-info d-flex flex-column flex-sm-row p-5 mb-10 mt-10">
                                                                            <!--begin::Wrapper-->
                                                                            <div class="d-flex flex-column pe-0 pe-sm-10 w-100">
                                                                                <!--begin::Title-->
                                                                                <h5 class="mb-1">Keterangan</h5>
                                                                                <!--end::Title-->
                                                                                <div class="col-10 row w-100">
                                                                                    <span class="col-2">C: Karang Gigi</span>
                                                                                    <span class="col-2">X: Gigi Tanggal</span>
                                                                                    <span class="col-2">D: Gigi Berlubang</span>
                                                                                    <span class="col-2">F: Tambalan Gigi</span>
                                                                                    <span class="col-2">MG: Gigi Miring</span>
                                                                                    <span class="col-2">B: Bridge</span>
                                                                                    <span class="col-2">PR: Prothesa</span>
                                                                                    <span class="col-2">GP: Gangren Pulpa</span>
                                                                                    <span class="col-2">CR: Crown</span>
                                                                                    <span class="col-2">FR: Fracture</span>
                                                                                    <span class="col-2">R: Radix</span>
                                                                                </div>
                                                                            </div>
                                                                            <!--end::Wrapper-->

                                                                        </div>
                                                                        <!--end::Alert-->
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ol>
                                        @endforeach


                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <a href="{{ route('examinations.index')  }}"
                                           class="btn btn-sm btn-light-primary">
                                            <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.5"
                                                          d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                                          fill="currentColor"/>
                                                    <path
                                                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                                        fill="currentColor"/>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary" name="selesai" value="1" data-kt-examinations-modal-action="submit">
                                            <span class="indicator-label">Finish</span>
                                            <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>

                                        <button type="submit" class="btn btn-info" name="continue" value="1" data-kt-examinations-modal-action="submit">
                                                            <span class="indicator-label">Continue</span>
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
            <div class="tab-pane" id="other" role="tabpanel" aria-labelledby="all-tab"
                 data-kt-timeline-widget-4-blockui="true">
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <!--begin::Alert-->
                    <div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10 row">
                        <!--begin::Wrapper-->
                        <div class="row col-12 pe-0 pe-sm-10">
                            <!--begin::Title-->
                            <h5 class="mb-1">Jenis Pemeriksaan</h5>
                            <!--end::Title-->
                            <div class="col-12">{{ $examination->service_category->name }}
                                <ul class="row">
                                    @foreach(service_examination($examination->id) as $service)
                                        <li class="col-4">{{ $service->service->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Alert-->

                    @if(isset($otherexamination->id))
                        <form id="kt_modal_add_examinations_form" method="POST" class="form" enctype="multipart/form-data"
                              action="{{ route('otherexaminations.update',['otherexamination' => $otherexamination->id]) }}">
                            @method('PUT')
                            {{ csrf_field() }}
                            @else
                                <form id="kt_modal_add_examinations_form" method="POST" class="form" enctype="multipart/form-data"
                                      action="{{ route('otherexaminations.store') }}">
                                    @method('POST')
                                    {{ csrf_field() }}
                                    @endif
                                    <input type="hidden" name="examination_id" value="{{ $examination->id }}">

                                    @foreach($otherscategories as $otherscategory)
                                        <h2 class="font-bold">{{$otherscategory->name}}</h2>
                                        <ol style="margin-left:-10px">
                                            @foreach(physicals($otherscategory->id) as $others)
                                                <li class="fw-normal text-base mb-6">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            {{$others->name}}
                                                            <input type="hidden" name="other[{{$others->id}}]">
                                                        </div>
                                                        <div class="col-8">
                                                            @php
                                                                $options = json_decode($others->options);
                                                                $option = [];
                                                                if(isset($otherexamination->id)){
                                                                    $option = json_decode($otherexamination->other_value,true);
                                                                }

                                                            @endphp
                                                            <div
                                                                class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                                @if(isset($options->radio))
                                                                    @foreach($options->radio as $radio)
                                                                        @php
                                                                            $r=[];
                                                                            if(isset($option[$others->id])){
                                                                                if(isset($option[$others->id]['radio'])){
                                                                                    $r = $option[$others->id]['radio'];
                                                                                }

                                                                            }
                                                                        @endphp
                                                                        <div
                                                                            class="form-check form-check-custom form-check-solid w-200px">
                                                                            <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   {{ in_array($radio->id,$r) ? 'checked' : '' }}
                                                                                   name = "other[{{$others->id}}][radio][{{$radio->id}}]"
                                                                                   value="{{$radio->id}}"
                                                                                   id="radio-{{$others->id}}"/>
                                                                            <label class="form-check-label"
                                                                                   for="radio-{{$others->id}}">
                                                                                {{$radio->value}}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                                @if(isset($options->additional))
                                                                    @foreach($options->additional as $additional)
                                                                        @php
                                                                            $adt=[];
                                                                            if(isset($option[$anamnesis->id])){
                                                                                if(isset($option[$others->id]['additional'])){
                                                                                 $adt = $option[$others->id]['additional'];
                                                                                 }
                                                                            }
                                                                        @endphp
                                                                        @if($additional->type == "text")
                                                                            <input type="text"
                                                                                   value="{{ $adt[$additional->name] ?? '' }}"
                                                                                   name="other[{{$others->id}}][additional][{{$additional->name}}]"
                                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                                                   placeholder="{{ucwords($additional->name)}}"/>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">&nbsp;</div>
                                                        <div class="col-8">
                                                            <input type="file" accept="application/pdf" name="file[{{$others->id}}]" id="" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0">
                                                            @if(isset($otherexamination->file))
                                                            @php $file = json_decode($otherexamination->file,true); @endphp
                                                            @if(isset($file[$others->id]))
                                                                <a href="{{ Storage::url('examinations/'.$examination->examination_code.'/'.$file[$others->id]) }}" target="_blank">Lihat File</a>
                                                                @endif
                                                                @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endforeach

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                                            <span>{{ __('Result') }}</span>

                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <select name="result" aria-label="{{ __('Select a Plan') }}" data-control="select2" data-placeholder="{{ __('Select a Plan...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                                <option value="">{{ __('Select a Plan...') }}</option>
                                                @if(isset($otherexamination->result))
                                                    <option value="fitwork" {{ $otherexamination->result=='fitwork' ? 'selected' :'' }}>Fit to Work</option>
                                                    <option value="fit"  {{ $otherexamination->result=='fit' ? 'selected' :'' }}>Fit with Note</option>
                                                    <option value="unfit" {{ $otherexamination->result=='unfit' ? 'selected' :'' }}>Unfit</option>
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

                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6">Description</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-8">
                                            <div class="input-group input-group-solid has-validation mb-3">
                                                <textarea name="description" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('description') is-invalid @enderror" placeholder="Description">{{ $otherexamination->description ?? "" }}</textarea>
                                            </div>
                                            @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Input-->
                                    </div>


                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <a href="{{ route('examinations.index')  }}"
                                           class="btn btn-sm btn-light-primary">
                                            <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.5"
                                                          d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                                          fill="currentColor"/>
                                                    <path
                                                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                                        fill="currentColor"/>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary" name="selesai" value="1" data-kt-examinations-modal-action="submit">
                                            <span class="indicator-label">Finish</span>
                                            <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>

                                        <button type="submit" class="btn btn-info" name="continue" value="1" data-kt-examinations-modal-action="submit">
                                            <span class="indicator-label">Continue</span>
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
                <div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column pe-0 pe-sm-10">
                        <!--begin::Title-->
                        <h5 class="mb-1">Jenis Pemeriksaan</h5>
                        <!--end::Title-->
                        <div class="col-10">{{ $examination->service_category->name }}
                            <ul class="row">
                                @foreach(service_examination($examination->id) as $service)
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
                                    <div class="col-8">: {{ $exam->vitality->weight ?? "-" }} Kg</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Height</div>
                                    <div class="col-8">: {{ $exam->vitality->height ?? "-" }} cm</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Body Mass Index</div>
                                    <div class="col-8">: {{ $exam->vitality->body_mass_index ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Ideal Weight</div>
                                    <div class="col-8">: {{ $exam->vitality->ideal_weight ?? "-" }} Kg</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Body Fat</div>
                                    <div class="col-8">: {{ $exam->vitality->body_fat ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">BMI Conclusion</div>
                                    <div class="col-8">: {{ $exam->vitality->bmi_conclusion ?? "-" }}</div>
                                </div>
                            </div>
                            <div class="row col-6">
                                <div class="col-12 row">
                                    <div class="col-4">Blood Pressure</div>
                                    <div class="col-8">: {{ $exam->vitality->blood_pressure ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Heart Rate</div>
                                    <div class="col-8">: {{ $exam->vitality->heart_rate ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Respiratory Rate</div>
                                    <div class="col-8">: {{ $exam->vitality->respiratory_rate ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Temperature</div>
                                    <div class="col-8">: {{ $exam->vitality->temperature ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Oxygen Saturation</div>
                                    <div class="col-8">: {{ $exam->vitality->oxygen_saturation ?? "-" }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Alert-->

                <form id="kt_modal_add_examinations_form" method="POST" class="form"
                      action="{{ route('examinations.update',['examination' => $examination->id]) }}">
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
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <select name="health_profesional_id" aria-label="{{ __('Health Profesional') }}"
                                        data-control="select2"
                                        data-placeholder="{{ __('Select a Health Profesional...') }}"
                                        class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Health Profesional...') }}</option>
                                    @foreach($healthprofesionals as $healthprofesional)
                                        <option
                                            value="{{ $healthprofesional->id }}" {{ $healthprofesional->id === old('health_profesional_id', $examination->health_profesional_id ?? '') ? 'selected' :'' }}>
                                            {{ ($healthprofesional->user->info->title_prefix !='' ? $healthprofesional->user->info->title_prefix.'. ' : '').$healthprofesional->user->name.($healthprofesional->user->info->title_suffix!='' ? ', '.$healthprofesional->user->info->title_suffix : '') }}
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
                                <select id="icdtens" aria-label="{{ __('Select a Diagnosa') }}" data-control="select2"
                                        data-placeholder="{{ __('Select a Diagnosa...') }}"
                                        class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Diagnosa...') }}</option>
                                    @foreach($icdtens as $icdten)
                                        <option
                                            value="{{ $icdten->id }}">{{  $icdten->code.' '.$icdten->name }}</option>
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
                                <select name="plan_id" aria-label="{{ __('Select a Plan') }}" data-control="select2"
                                        data-placeholder="{{ __('Select a Plan...') }}"
                                        class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Plan...') }}</option>
                                    @foreach($plans as $plan)
                                        <option
                                            value="{{ $plan->id }}" {{  $plan->id === old('plan_id', $examination->plan_id ?? '') ? 'selected' :'' }}>{{  $plan->name }}</option>
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
                        <a href="{{ route('examinations.index')  }}" class="btn btn-sm btn-light-primary">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.5"
                                  d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                  fill="currentColor"/>
                            <path
                                d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                fill="currentColor"/>
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
        $(function () {
            $assesment = $("#assessment").html();
            $("#icdtens").change(function () {
                $("#assessment").append($(this).find("option:selected").text() + '\n');
            });
        })
    </script>
@endpush
