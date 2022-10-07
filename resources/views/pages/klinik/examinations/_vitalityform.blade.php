<!--begin::Card-->
<div class="card card-xxl-stretch mb-5 mb-xl-8">
    <!--begin::Card body-->
    <!--begin::Card header-->
    <div class="card-header position-relative py-0 border-bottom-1">
        <!--begin::Card title-->
        <h3 class="card-title text-gray-800 fw-bold">
            Examination {{  $examination->examination_code }}
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
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#disease">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Disease</span>
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
                    <span class="nav-text fw-semibold fs-4 mb-3">Vitality Examination</span>
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

            <div class="tab-pane active" id="examination" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
                @if(isset($vitalityexamination->id))
                    <form id="kt_modal_add_examinations_form" method="POST" class="form" action="{{ route('vitalityexaminations.update',['vitalityexamination' => $vitalityexamination->id]) }}">
                    @method('PUT')
                    @else
                            <form id="kt_modal_add_examinations_form" method="POST" class="form" action="{{ route('vitalityexaminations.store') }}">

                            @method('POST')
                    @endif
                {{ csrf_field() }}
                <!--begin::Scroll-->
                    <div class="d-flex flex-column flex-row-fluid">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Weight</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                                    <input type="text" name="weight" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('weight') is-invalid @enderror" placeholder="Weight" value="{{ $vitalityexamination->weight ?? "" }}">
                                </div>
                                @error('weight')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Height</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <input type="text" name="height" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('height') is-invalid @enderror" placeholder="Height" value="{{ $vitalityexamination->height ?? "" }}">
                                </div>
                                @error('height')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Blood Pressure</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <input type="text" name="blood_pressure" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('blood_pressure') is-invalid @enderror" placeholder="Blood Pressure" value="{{ $vitalityexamination->blood_pressure ?? "" }}">
                                </div>
                                @error('blood_pressure')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Heart Rate</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <input type="text" name="heart_rate" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('heart_rate') is-invalid @enderror" placeholder="Heart Rate" value="{{ $vitalityexamination->heart_rate ?? "" }}">
                                </div>
                                @error('heart_rate')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Respiratory Rate</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <input type="text" name="respiratory_rate" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('respiratory_rate') is-invalid @enderror" placeholder="Respiratory Rate" value="{{ $vitalityexamination->respiratory_rate ?? "" }}">
                                </div>
                                @error('respiratory_rate')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Temperature</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <input type="text" name="temperature" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('temperature') is-invalid @enderror" placeholder="Temperature" value="{{ $vitalityexamination->temperature ?? "" }}">
                                </div>
                                @error('temperature')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Oxygen Saturation</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <input type="text" name="oxygen_saturation" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('oxygen_saturation') is-invalid @enderror" placeholder="Oxygen Saturation" value="{{ $vitalityexamination->oxygen_saturation ?? "" }}">
                                </div>
                                @error('oxygen_saturation')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Body Mass Index</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <input type="text" name="body_mass_index" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('body_mass_index') is-invalid @enderror" placeholder="Body Mass Index" value="{{ $vitalityexamination->body_mass_index ?? "" }}">
                                </div>
                                @error('body_mass_index')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Ideal Weight</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <input type="text" name="ideal_weight" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('ideal_weight') is-invalid @enderror" placeholder="Ideal Weight" value="{{ $vitalityexamination->ideal_weight ?? "" }}">
                                </div>
                                @error('ideal_weight')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Body Fat</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <input type="text" name="body_fat" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('body_fat') is-invalid @enderror" placeholder="Body Fat" value="{{ $vitalityexamination->body_fat ?? "" }}">
                                </div>
                                @error('body_fat')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">BMI Conclusion</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <input type="text" name="bmi_conclusion" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('bmi_conclusion') is-invalid @enderror" placeholder="BMI Conclusion" value="{{ $vitalityexamination->bmi_conclusion ?? "" }}">
                                </div>
                                @error('bmi_conclusion')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <a href="{{ route('examinations.index')  }}" class="btn btn-sm btn-light-primary">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor"/>
                            <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor"/>
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
    $(function(){
        $assesment = $("#assessment").html();
        $("#icdtens").change(function(){
            $("#assessment").append($(this).find("option:selected").text()+'\n');
        });
    })
</script>
@endpush
