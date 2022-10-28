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
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#user">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Patient Profile</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#medicalrecord">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Medical Record</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3 active" data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#examination">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Services</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
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
            <div class="tab-pane" id="user" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
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
                                    <img src="{!!  $user->avatar_url !='' ? $user->avatar_url : asset(theme()->getMediaUrlPath().'photos/blank.png') !!}" alt="image"/>
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
                                <span class="fw-bold fs-6">{{ isset($info->card_type_id) ? $info->card->name : '' }}</span>
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
                                <span class="fw-bold fs-6">{{ isset($info->card_type_id) ? $info->card->name : '' }}</span>
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
                                <span class="fw-bold fs-6">{{ ($info->title_prefix !='' ? $info->title_prefix.'. ' : '').$user->name.($info->title_suffix!='' ? ', '.$info->title_suffix : '') }}</span>
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
                                <span class="fw-bold fs-6">{{ isset($info->religion) ? $info->religion->name : '' }}</span>
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
                                <span class="fw-bold fs-6">{{ isset($info->marital_status_id) ? $info->marital->name : '' }}</span>
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
                                <span class="fw-bold fs-6">{{ isset($info->education_id) ? $info->education->name : '' }}</span>
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
                                <span class="fw-bold fs-6">{{ isset($info->blood_type_id) ? $info->blood->name : '' }}</span>
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

            <div class="tab-pane active" id="examination" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
                <form id="kt_modal_add_permission_form" method="POST" class="form" action="{{ route('examinations.storeservices') }}">
                    {{ csrf_field() }}
                    <ul style="margin-left:-40px;" class="row">
                        @foreach($services as $service)
                            <li class="col-lg-4" style="list-style: none;">
                                <div class="form-check form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input" {{ in_array($service->id,$transactionDetail) ? 'checked' : '' }} type="checkbox" value="{{ $service->id }}" name="service_id[]" id="service_{{ $service->id }}">
                                    <label class="form-check-label" for="category_{{ $service->id }}">
                                        {{ $service->name }}
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <ul style="margin-left:-40px;border-top:1px solid gray;padding-top:10px" class="row">
                        @foreach($servicecategories as $category)
                            <li class="col-lg-4 mb-6" style="list-style: none;">
                                <div class="form-check fw-bold form-check-custom form-check-solid mb-3">
                                    {{ $category->name }}
                                </div>
                                <ul>
                                    @foreach(services($category->id) as $service)
                                        <li style="list-style: none;">
                                            <div class="form-check form-check-custom form-check-solid mb-3">
                                                <input class="form-check-input" {{ in_array($service->id,$transactionDetail) ? 'checked' : '' }} type="checkbox" value="{{ $service->id }}" name="service_id[]" id="service_{{ $service->id }}">
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
                        <button type="submit" class="btn btn-primary" name="payment" value="1" data-kt-examinations-modal-action="submit">
                            <span class="indicator-label">Create Payment</span>
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
    $(function(){
        $assesment = $("#assessment").html();
        $("#icdtens").change(function(){
            $("#assessment").append($(this).find("option:selected").text()+'\n');
        });
    })
</script>
@endpush
