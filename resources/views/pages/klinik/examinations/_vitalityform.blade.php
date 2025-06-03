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
                                       data-bs-toggle="tab" href="#examination">
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
                                                        <img src="{!! $user->avatar_url != '' ? $user->avatar_url : asset(theme()->getMediaUrlPath() . 'photos/blank.png') !!}" alt="image"/>
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
                                    class="fw-bold fs-6">{{ ($info->title_prefix != '' ? $info->title_prefix . '. ' : '') . $user->name . ($info->title_suffix != '' ? ', ' . $info->title_suffix : '') }}</span>
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
                                    class="fw-bolder fs-6 text-dark">{{ ($info->title_prefix != '' ? $info->title_prefix . '. ' : '') . $user->name . ($info->title_suffix != '' ? ', ' . $info->title_suffix : '') }}</span>
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
                                <span
                                    class="fw-bold fs-6">{{ $info->place_of_birth . ', ' . $info->date_of_birth }}</span>
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
                                                    <span class="fw-bold fs-6">{{ $info->height }} cm</span>
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
                                                       class="fw-bold fs-6 text-dark text-hover-primary">{{ $info->address }}{{ isset($info->subdistrict) ? ', ' . $info->subdistrict->name : '' }}{{ isset($info->district) ? ', ' . $info->district->name : '' }}{{ isset($info->city) ? ', ' . $info->city->name : '' }}{{ isset($info->province) ? ', ' . $info->province->name : '' }}{{ isset($info->country) ? ', ' . $info->country->name : '' }}{{ $info->postal_code != '' ? $info->postal_code : (isset($info->subdistrict) ? ' - ' . $info->subdistrict->postal_code : '') }}</a>
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
                                                    <span class="fw-bold fs-6">{{ $info->patient_trustee_name ?? '' }}</span>
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
                                                    <span class="fw-bold fs-6">{{ $info->company_name ?? '' }}</span>
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
                                                    <span class="fw-bold fs-6">{{ $info->date_of_hire ?? '' }}</span>
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
                                                    <span class="fw-bold fs-6">{{ $info->job_title ?? '' }}</span>
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
                                                    <span class="fw-bold fs-6">{{ $info->division ?? '' }}</span>
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
                                                    <span class="fw-bold fs-6">{{ $info->department ?? '' }}</span>
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
                                                    <span class="fw-bold fs-6">{{ $info->section ?? '' }}</span>
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
                                                    <span class="fw-bold fs-6">{{ $info->employee_id ?? '' }}</span>
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
                                                    <span class="fw-bold fs-6">{{ $info->kind_of_job ?? '' }}</span>
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
                                                    <span class="fw-bold fs-6">{{ $info->shift ?? '' }}</span>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::details View-->
                                </div>

                                <div class="tab-pane" id="examination" role="tabpanel" aria-labelledby="all-tab"
                                     data-kt-timeline-widget-4-blockui="true">
                                    @if (isset($vitalityexamination->id))
                                        <form id="kt_modal_add_examinations_form" method="POST" class="form"
                                              action="{{ route('vitalityexaminations.update', ['vitalityexamination' => $vitalityexamination->id]) }}">
                                            @method('PUT')
                                            @else
                                                <form id="kt_modal_add_examinations_form" method="POST" class="form"
                                                      action="{{ route('vitalityexaminations.store') }}">
                                                    @method('POST')
                                                    @endif
                                                    {{ csrf_field() }}
                                                    <!--begin::Scroll-->
                                                    <div class="row">
                                                        <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                                                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="blood_pressure" class="form-label">Blood Pressure (Tekanan Darah)</label>
                                                            <input id="blood_pressure" name="blood_pressure" type="text"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('blood_pressure') is-invalid @enderror"
                                                                   placeholder="Blood Pressure" value="{{ $vitalityexamination->blood_pressure ?? '' }}"/>
                                                            @error('blood_pressure')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="pulse" class="form-label">Heart Rate (Detak Jantung)</label>
                                                            <input id="heart_rate" name="heart_rate" type="text"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('heart_rate') is-invalid @enderror"
                                                                   placeholder="Heart Rate" value="{{ $vitalityexamination->heart_rate ?? '' }}"/>
                                                            @error('heart_rate')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="respiratory_rate" class="form-label">Respiratory Rate (Laju Pernapasan)</label>
                                                            <input id="respiratory_rate" name="respiratory_rate" type="text"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('respiratory_rate') is-invalid @enderror"
                                                                   placeholder="Respiratory Rate"
                                                                   value="{{ $vitalityexamination->respiratory_rate ?? '' }}"/>
                                                            @error('respiratory_rate')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="temperature" class="form-label">Temperature (Suhu)</label>
                                                            <input id="temperature" name="temperature" type="text"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('temperature') is-invalid @enderror"
                                                                   placeholder="Temperature" value="{{ $vitalityexamination->temperature ?? '' }}"/>
                                                            @error('temperature')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="oxygen_saturation" class="form-label">Oxygen Saturation (Saturasi Oksigen)</label>
                                                            <input id="oxygen_saturation" name="oxygen_saturation" type="text"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('oxygen_saturation') is-invalid @enderror"
                                                                   placeholder="Oxygen Saturation"
                                                                   value="{{ $vitalityexamination->oxygen_saturation ?? '' }}"/>
                                                            @error('oxygen_saturation')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="waist_circumferennce" class="form-label">Waist Circumference (Lingkar
                                                                Pinggang)</label>
                                                            <input id="waist_circumferennce" name="waist_circumferennce" type="number" step=".01"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('waist_circumferennce') is-invalid @enderror"
                                                                   placeholder="Waist Circumference"
                                                                   value="{{ $vitalityexamination->waist_circumferennce ?? '' }}"/>
                                                            @error('waist_circumferennce')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="neck_circumference" class="form-label">Neck Circumference (Lingkar Leher)</label>
                                                            <input id="neck_circumference" name="neck_circumference" type="text"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('neck_circumference') is-invalid @enderror"
                                                                   placeholder="Neck Circumference"
                                                                   value="{{ $vitalityexamination->neck_circumference ?? '' }}"/>
                                                            @error('neck_circumference')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="arm_circumference" class="form-label">Arm Circumference (Lingkar Lengan)</label>
                                                            <input id="arm_circumference" name="arm_circumference" type="number" step=".01"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('arm_circumference') is-invalid @enderror"
                                                                   placeholder="Arm Circumference"
                                                                   value="{{ $vitalityexamination->arm_circumference ?? '' }}"/>
                                                            @error('arm_circumference')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="chest_size" class="form-label">Chest Size (Ukuran Dada)</label>
                                                            <input id="chest_size" name="chest_size" type="number" step=".01"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('chest_size') is-invalid @enderror"
                                                                   placeholder="Chest Size" value="{{ $vitalityexamination->chest_size ?? '' }}"/>
                                                            @error('chest_size')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="adbdominal_circumference" class="form-label">Abdominal Circumference (Lingkar
                                                                Perut)</label>
                                                            <input id="adbdominal_circumference" name="adbdominal_circumference" type="number"
                                                                   step=".01"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('adbdominal_circumference') is-invalid @enderror"
                                                                   placeholder="Abdominal Circumference"
                                                                   value="{{ $vitalityexamination->adbdominal_circumference ?? '' }}"/>
                                                            @error('adbdominal_circumference')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="weight" class="form-label">Weight (Berat Badan) (kg)</label>
                                                            <input id="weight" name="weight" type="number" step=".01"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('weight') is-invalid @enderror"
                                                                   placeholder="Weight" value="{{ $vitalityexamination->weight ?? '' }}"/>
                                                            @error('weight')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="height" class="form-label">Height (Tinggi Badan) (cm)</label>
                                                            <input id="height" name="height" type="number" step=".01"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('height') is-invalid @enderror"
                                                                   placeholder="Height" value="{{ $vitalityexamination->height ?? '' }}"/>
                                                            @error('height')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="body_mass_index" class="form-label">Body Mass Index (Indeks Massa Tubuh)</label>
                                                            <input id="body_mass_index" name="body_mass_index" type="number" step=".01"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('body_mass_index') is-invalid @enderror"
                                                                   placeholder="Body Mass Index"
                                                                   value="{{ $vitalityexamination->body_mass_index ?? '' }}"/>
                                                            @error('body_mass_index')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="ideal_weight" class="form-label">Ideal Weight (Berat Badan Ideal) (kg)</label>
                                                            <input id="ideal_weight" name="ideal_weight" type="number" step=".01"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('ideal_weight') is-invalid @enderror"
                                                                   placeholder="Ideal Weight" value="{{ $vitalityexamination->ideal_weight ?? '' }}"/>
                                                            @error('ideal_weight')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="body_fat" class="form-label">Body Fat (Lemak Tubuh)</label>
                                                            <input id="body_fat" name="body_fat" type="number" step=".01"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('body_fat') is-invalid @enderror"
                                                                   placeholder="Body Fat" value="{{ $vitalityexamination->body_fat ?? '' }}"/>
                                                            @error('body_fat')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="col-6 mb-6">
                                                            <label for="bmi_conclusion" class="form-label">BMI Conclusion (Kesimpulan BMI)</label>
                                                            <input id="bmi_conclusion" name="bmi_conclusion" type="text"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('bmi_conclusion') is-invalid @enderror"
                                                                   placeholder="BMI Conclusion" value="{{ $vitalityexamination->bmi_conclusion ?? '' }}"/>
                                                            @error('bmi_conclusion')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="col-12 mb-6">
                                                            <label for="others" class="form-label">Others (Lainnya)</label>
                                                            <input id="others" name="others" type="text"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('others') is-invalid @enderror"
                                                                   placeholder="Others" value="{{ $vitalityexamination->others ?? '' }}"/>
                                                            @error('others')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!--end::Input group-->
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

                                <div class="tab-pane active" id="skrining" role="tabpanel" aria-labelledby="all-tab"
                                     data-kt-timeline-widget-4-blockui="true">

                                    @php
                                        // Decode data skrining yang sudah tersimpan
                                        $skriningData = [];
                                        if (isset($vitalityexamination) && $vitalityexamination && $vitalityexamination->skrining) {
                                            $skriningData = json_decode($vitalityexamination->skrining, true) ?? [];
                                        }
                                    @endphp

                                    <form method="POST" class="form" action="{{ route('vitalityexaminations.skrining') }}">
                                        @method('POST')
                                        {{ csrf_field() }}
                                        <!--begin::Scroll-->
                                        <div class="row">
                                            <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                                            <!--begin::Input group-->
                                            <div class="col-12 mb-6">
                                                <div class="d-flex flex-row">
                                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                                        <label for="pulse" class="form-label">Kesadaran</label>
                                                    </div>
                                                    <div class="d-flex flex-row flex-row-fluid">
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Sadar Penuh" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="kesadaran" id="kesadaran_satu"
                                                                {{ (isset($skriningData['kesadaran']) && $skriningData['kesadaran'] == 'Sadar Penuh') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="kesadaran_satu">
                                                                Sadar Penuh
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Tampak mengantuk / gelisah bicara tidak jelas"
                                                                   class="form-check-input h-20px w-30px me-5" type="radio"
                                                                   name="kesadaran" id="kesadaran_dua"
                                                                {{ (isset($skriningData['kesadaran']) && $skriningData['kesadaran'] == 'Tampak mengantuk / gelisah bicara tidak jelas') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="kesadaran_dua">
                                                                Tampak mengantuk / gelisah bicara tidak jelas
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Tidak Sadar" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="kesadaran" id="kesadaran_tiga"
                                                                {{ (isset($skriningData['kesadaran']) && $skriningData['kesadaran'] == 'Tidak Sadar') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="kesadaran_tiga">
                                                                Tidak Sadar
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="col-12 mb-6">
                                                <div class="d-flex flex-row">
                                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                                        <label for="pulse" class="form-label">Pernafasan</label>
                                                    </div>
                                                    <div class="d-flex flex-row flex-row-fluid">
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Nafas normal" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="pernafasan" id="pernafasan_satu"
                                                                {{ (isset($skriningData['pernafasan']) && $skriningData['pernafasan'] == 'Nafas normal') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="pernafasan_satu">
                                                                Nafas normal
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Tampak sesak" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="pernafasan" id="pernafasan_dua"
                                                                {{ (isset($skriningData['pernafasan']) && $skriningData['pernafasan'] == 'Tampak sesak') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="pernafasan_dua">
                                                                Tampak sesak
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Tidak bernapas" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="pernafasan" id="pernafasan_tiga"
                                                                {{ (isset($skriningData['pernafasan']) && $skriningData['pernafasan'] == 'Tidak bernapas') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="pernafasan_tiga">
                                                                Tidak bernapas
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="col-12 mb-6">
                                                <div class="d-flex flex-row">
                                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                                        <label for="pulse" class="form-label">Resiko Jatuh</label>
                                                    </div>
                                                    <div class="d-flex flex-row flex-row-fluid">
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Resiko rendah" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="jatuh" id="jatuh_satu"
                                                                {{ (isset($skriningData['jatuh']) && $skriningData['jatuh'] == 'Resiko rendah') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="jatuh_satu">
                                                                Resiko rendah
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Resiko sedang" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="jatuh" id="jatuh_dua"
                                                                {{ (isset($skriningData['jatuh']) && $skriningData['jatuh'] == 'Resiko sedang') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="jatuh_dua">
                                                                Resiko sedang
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Resiko Tinggi" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="jatuh" id="jatuh_tiga"
                                                                {{ (isset($skriningData['jatuh']) && $skriningData['jatuh'] == 'Resiko Tinggi') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="jatuh_tiga">
                                                                Resiko Tinggi
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="col-12 mb-6">
                                                <div class="d-flex flex-row">
                                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                                        <label for="pulse" class="form-label">Nyeri Dada</label>
                                                    </div>
                                                    <div class="d-flex flex-row flex-row-fluid">
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Tidak ada" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="nyeri" id="nyeri_satu"
                                                                {{ (isset($skriningData['nyeri']) && $skriningData['nyeri'] == 'Tidak ada') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="nyeri_satu">
                                                                Tidak ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Ada (Tingkat Sedang)"
                                                                   class="form-check-input h-20px w-30px me-5" type="radio" name="nyeri"
                                                                   id="nyeri_dua"
                                                                {{ (isset($skriningData['nyeri']) && $skriningData['nyeri'] == 'Ada (Tingkat Sedang)') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="nyeri_dua">
                                                                Ada (Tingkat Sedang)
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Nyeri dada kiri tembus punggung"
                                                                   class="form-check-input h-20px w-30px me-5" type="radio" name="nyeri"
                                                                   id="nyeri_tiga"
                                                                {{ (isset($skriningData['nyeri']) && $skriningData['nyeri'] == 'Nyeri dada kiri tembus punggung') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="nyeri_tiga">
                                                                Nyeri dada kiri tembus punggung
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="col-12 mb-6">
                                                <div class="d-flex flex-row">
                                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                                        <label for="pulse" class="form-label">Skala Nyeri</label>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <div class="d-flex flex-column flex-row-auto mb-5">
                                                            <img class="w-500px"
                                                                 src="http://127.0.0.1:8000/assets/media/misc/painscale.png"
                                                                 alt="">
                                                        </div>
                                                        <div class="d-flex flex-row flex-row-auto mb-5">
                                                            <label class="d-flex w-200px form-label">Lokasi : </label>
                                                            <input type="text" name="lokasi_nyeri" value="{{ $skriningData['lokasi_nyeri'] ?? '' }}"
                                                                   class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0">
                                                        </div>
                                                        <div class="d-flex flex-row flex-row-fluid mb-5">
                                                            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                                <input value="1-3" class="form-check-input h-20px w-30px me-5"
                                                                       type="radio" name="skala" id="skala_satu"
                                                                    {{ (isset($skriningData['skala']) && $skriningData['skala'] == '1-3') ? 'checked' : '' }} />
                                                                <label class="form-check-label" for="skala_satu">
                                                                    1-3
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                                <input value="4-6" class="form-check-input h-20px w-30px me-5"
                                                                       type="radio" name="skala" id="skala_dua"
                                                                    {{ (isset($skriningData['skala']) && $skriningData['skala'] == '4-6') ? 'checked' : '' }} />
                                                                <label class="form-check-label" for="skala_dua">
                                                                    4-6
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                                <input value="6-10" class="form-check-input h-20px w-30px me-5"
                                                                       type="radio" name="skala" id="skala_tiga"
                                                                    {{ (isset($skriningData['skala']) && $skriningData['skala'] == '6-10') ? 'checked' : '' }} />
                                                                <label class="form-check-label" for="skala_tiga">
                                                                    6-10
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="col-12 mb-6">
                                                <div class="d-flex flex-row">
                                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                                        <label for="pulse" class="form-label">Batuk</label>
                                                    </div>
                                                    <div class="d-flex flex-row flex-row-fluid">
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Tidak ada" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="batuk" id="batuk_satu"
                                                                {{ (isset($skriningData['batuk']) && $skriningData['batuk'] == 'Tidak ada') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="batuk_satu">
                                                                Tidak ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Batuk > 2 Minggu" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="batuk" id="batuk_dua"
                                                                {{ (isset($skriningData['batuk']) && $skriningData['batuk'] == 'Batuk > 2 Minggu') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="batuk_dua">
                                                                Batuk > 2 Minggu
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="col-12 mb-6">
                                                <div class="d-flex flex-row">
                                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                                        <label for="pulse" class="form-label">Keputusan</label>
                                                    </div>
                                                    <div class="d-flex flex-row flex-row-fluid">
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Diterima" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="keputusan" id="keputusan_satu"
                                                                {{ (isset($skriningData['keputusan']) && $skriningData['keputusan'] == 'Diterima') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="keputusan_satu">
                                                                Diterima
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Di Dahulukan" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="keputusan" id="keputusan_dua"
                                                                {{ (isset($skriningData['keputusan']) && $skriningData['keputusan'] == 'Di Dahulukan') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="keputusan_dua">
                                                                Di Dahulukan
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                            <input value="Dirujuk" class="form-check-input h-20px w-30px me-5"
                                                                   type="radio" name="keputusan" id="keputusan_tiga"
                                                                {{ (isset($skriningData['keputusan']) && $skriningData['keputusan'] == 'Dirujuk') ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="keputusan_tiga">
                                                                Dirujuk
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Input group-->


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

                    @push('customscript')
                        <script>
                            $(function () {
                                var bmi, weight, height = 0;
                                $('#weight').change(function () {
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

                                $('#height').change(function () {
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
                                $("#icdtens").change(function () {
                                    $("#assessment").append($(this).find("option:selected").text() + '\n');
                                });
                            })
                        </script>
        @endpush
