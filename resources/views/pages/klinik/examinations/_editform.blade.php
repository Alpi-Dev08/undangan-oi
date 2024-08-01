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

            @if($examination->is_lab)
                <li class="nav-item p-0 ms-0">
                    <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#lab">
                        <!--begin::Title-->
                        <span class="nav-text fw-semibold fs-4 mb-3">Hasil Lab</span>
                        <!--end::Title-->
                        <!--begin::Bullet-->
                        <span class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                        <!--end::Bullet-->
                    </a>
                </li>
                <!--end::Nav item-->
            @endif

            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#psikososial">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Pengkajian Awal</span>
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
                    <span class="nav-text fw-semibold fs-4 mb-3">Examination</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#suratketerangan">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Surat Keterangan</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->

            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#odontogram">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Odontogram</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#lab">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Pemeriksaan Penunjang</span>
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
                            <label class="col-lg-4 fw-bold text-muted">{{ __('IHS/SATUSEHAT Number') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $user->patient->his_number }}</span>
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
            <div class="tab-pane" id="odontogram" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
                <!--begin::details View-->
                <form id="kt_modal_add_examinations_form" method="POST" class="form" action="{{ route('examinations.update',['examination' => $examination->id]) }}">
                    @method('PUT')
                    {{ csrf_field() }}
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column flex-row-fluid">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Health Profesional') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <select name="health_profesional_id" aria-label="{{ __('Health Profesional') }}" data-control="select2" data-placeholder="{{ __('Select a Health Profesional...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Health Profesional...') }}</option>
                                    @foreach($healthprofesionals as $healthprofesional)
                                        <option value="{{ $healthprofesional->id }}" {{ $healthprofesional->id === old('health_profesional_id', $examination->health_profesional_id ?? '') ? 'selected' :'' }}>
                                            @if(isset($healthprofesional->user->info))
                                                {{ ($healthprofesional->user->info->title_prefix !='' ? $healthprofesional->user->info->title_prefix.'. ' : '').$healthprofesional->user->name.($healthprofesional->user->info->title_suffix!='' ? ', '.$healthprofesional->user->info->title_suffix : '') }}
                                            @else
                                                {{$healthprofesional->user->name}}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Subjective Anamnesa</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <textarea name="subjective" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('subjective anamnesa') is-invalid @enderror" placeholder="Subjective Anamnesa">{{ $examination->subjective }}</textarea>
                                </div>
                                @error('subjective')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>


                        <div class="row mb-6">
                            <div class="col-lg-12 text-center">
                                <img src="{{ asset('images/odontogram.png') }}" alt="Gambar Odontogram" class="img-fluid mb-3">
                            </div>
                        </div>

                        <!-- start Gambar -->
                        <div class="row mb-6" id="input-container">
                            <div class="col-lg-4">
                                <label class="col-form-label fw-bold fs-6">Gambar</label>
                                <input type="text" name="gambar[]" class="form-control form-control-solid mb-3" placeholder="Keterangan">
                            </div>
                            <div class="col-lg-2">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <select name="odontogram_symbol_id" aria-label="{{ __('Odontogram Code') }}" data-control="select2" data-placeholder="{{ __('Select an Odontogram Code...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                        <option value="">{{ __('Select an Odontogram Code...') }}</option>
                                        @foreach($odontogramsymbols as $odontogramsymbol)
                                            <option value="{{ $symbol->id }}" {{ $odontogramsymbol->id === old('odontogram_symbol_id', $odontogramsymbol->odontogram_symbol_id ?? '') ? 'selected' : '' }}>
                                                {{ $odontogramsymbol->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-lg-4">
                                <label class="col-form-label fw-bold fs-6">Keterangan</label>
                                <input type="text" name="keterangan[]" class="form-control form-control-solid mb-3" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row mb-6">
                            <div class="col-lg-12 text-center">
                                <button type="button" id="add-column" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>

                        <!-- end Gambar -->

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Assesment</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <textarea name="subjective" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('assesment') is-invalid @enderror" placeholder="Assesment">{{ $examination->subjective }}</textarea>
                                </div>
                                @error('subjective')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Plan</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <textarea name="subjective" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('plan') is-invalid @enderror" placeholder="Plan">{{ $examination->subjective }}</textarea>
                                </div>
                                @error('subjective')
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


            <div class="tab-pane" id="medicalrecord" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <div class="timeline-label">
                        @foreach($examinations as $exam)
                            <!--begin::Item-->
                            <div class="timeline-item">
                                <!--begin::Label-->
                                <div class="timeline-label fw-bold text-gray-800 fs-6">{{ $exam->created_at->format("d F Y") }}
                                    <br>{{ $exam->created_at->format("H:i:s") }}</div>
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
                                            <div class="col-10">: {{ $exam->health_profesional->user->name ?? "-" }}</div>
                                        </div>
                                        <div class="col-12 row">
                                            <div class="col-2 fw-bolder">Pemeriksaan Awal</div>
                                            @if($exam->pemeriksaan_awal)
                                                <div class="col-10">: {{ $exam->pemeriksaan_awal->interpretasi }} / {{ $exam->pemeriksaan_awal->tindakan }}
                                                </div>
                                            @else
                                                <div class="col-10">: -
                                                </div>
                                            @endif
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
                                                <div class="col-10">: {{$exam->assessment }}</div>
                                            </div>
                                            <div class="col-12 row">
                                                <div class="col-2 fw-bolder">Plan</div>
                                                <div class="col-10">: {{ $exam->plan ? $exam->plan->name : '' }}</div>
                                            </div>
                                            <div class="col-12 row">
                                                <div class="col-2 fw-bolder">Resep</div>
                                                <div class="col-10">:
                                                    @php
                                                        $resep = json_decode($exam->resep);
                                                        $obat = $resep->obat ?? "";
                                                        $qty = $resep->qty ?? "";
                                                    @endphp
                                                    @if($obat)
                                                        <ul style="margin-top:-20px"">
                                                        @foreach($obat as $key => $value)
                                                            @if(isset(getObat($value)->name))
                                                                <li>{{ getObat($value)->name }} x {{$qty[$key]}}</li>
                                                                @endif
                                                                @endforeach
                                                                </ul>
                                                            @endif
                                                </div>
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
            @if($examination->is_lab)
                @if($laboratoryexamination->hasil)
                    <div class="tab-pane" id="lab" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
                        <!--begin::details View-->
                        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                            <div class="row">
                                <div class="col-3 fw-bolder">Laboratory Name</div>
                                <div class="col-9">: {{ $laboratoryexamination->laboratory_name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-3 fw-bolder">Tanggal Pemeriksaan</div>
                                <div class="col-9">: {{ $laboratoryexamination->updated_at->format('d M Y H:i:s') }}</div>
                            </div>
                            <table class="table table-striped table-bordered border">
                                <thead>
                                <thead>
                                <tr class="table-primary border">
                                    <th class="text-center fw-bolder" width="50">No</th>
                                    <th class="fw-bolder">Jenis Pemeriksaan</th>
                                    <th class="text-center fw-bolder">Hasil</th>
                                    <th class="fw-bolder">Nilai Rujukan</th>
                                    <th class="fw-bolder">Satuan</th>
                                    <th class="fw-bolder">Keterangan</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $no=1; @endphp
                                @foreach(json_decode($laboratoryexamination->hasil) as $row)
                                    @if($row->ItemName!='Hematologi')
                                        <tr class="border">
                                            <td class="text-center">{{ $no }}</td>
                                            <td>{{ $row->ItemName }}</td>
                                            <td class="text-center">{{ $row->hasil }}</td>
                                            <td>{{ $row->nilai_rujukan }}</td>
                                            <td>{{ $row->satuan ?? '' }}</td>
                                            <td>{{ $row->keterangan ?? '' }}</td>
                                        </tr>
                                        @php $no++; @endphp
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif
            
            <div class="tab-pane active" id="examination" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">


                <!--begin::Alert-->
                <div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10 mx-0 row">
                    <!--begin::Close-->
                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/arrows/arr088.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor"/>
<rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor"/>
</svg></span>
                        <!--end::Svg Icon-->
                    </button>
                    <!--end::Close-->
                    <!--begin::Wrapper-->
                    <div class="row col-12 pe-0 pe-sm-10">
                        @if(isset($pemeriksaan_awal))
                            <h5>Pemeriksaan Awal</h5>
                            @if($pemeriksaan_awal->kriteria_satu=='ya' && $pemeriksaan_awal->kriteria_dua=='ya')
                                @php $text_class = 'text-danger'; @endphp
                            @elseif($pemeriksaan_awal->kriteria_satu=='ya' || $pemeriksaan_awal->kriteria_dua=='ya')
                                @php $text_class = 'text-warning'; @endphp
                            @else
                                @php $text_class = 'text-success'; @endphp
                            @endif
                            <!--begin::Content-->
                            <div class="col-12 {{ $text_class }} fw-bolder mb-5">
                                <span>{{ $pemeriksaan_awal->interpretasi  }} / {{ ucwords($pemeriksaan_awal->tindakan)  }}</span>
                            </div>
                            <!--end::Content-->
                        @endif
                        <!--begin::Title-->
                        <h5>Jenis Pemeriksaan</h5>
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
                            <div class="row col-6">
                                <div class="col-12 row">
                                    <div class="col-4">Weight</div>
                                    <div class="col-8">: {{ $examination->vitality->weight ?? "-" }} Kg</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Height</div>
                                    <div class="col-8">: {{ $examination->vitality->height ?? "-" }} cm</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Body Mass Index</div>
                                    <div class="col-8">: {{ $examination->vitality->body_mass_index ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Ideal Weight</div>
                                    <div class="col-8">: {{ $examination->vitality->ideal_weight ?? "-" }} Kg</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Body Fat</div>
                                    <div class="col-8">: {{ $examination->vitality->body_fat ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">BMI Conclusion</div>
                                    <div class="col-8">: {{ $examination->vitality->bmi_conclusion ?? "-" }}</div>
                                </div>
                                <div class="col-12">&nbsp;</div>
                                <div class="col-12 row">
                                    <div class="col-4">Arm Circumference</div>
                                    <div class="col-8">: {{ $examination->vitality->arm_circumference ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Abdominal Circumference</div>
                                    <div class="col-8">: {{ $examination->vitality->adbdominal_circumference ?? "-" }}</div>
                                </div>
                            </div>
                            <div class="row col-6">
                                <div class="col-12 row">
                                    <div class="col-4">Blood Pressure</div>
                                    <div class="col-8">: {{ $examination->vitality->blood_pressure ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Heart Rate</div>
                                    <div class="col-8">: {{ $examination->vitality->heart_rate ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Respiratory Rate</div>
                                    <div class="col-8">: {{ $examination->vitality->respiratory_rate ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Temperature</div>
                                    <div class="col-8">: {{ $examination->vitality->temperature ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Oxygen Saturation</div>
                                    <div class="col-8">: {{ $examination->vitality->oxygen_saturation ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Waist Circumference</div>
                                    <div class="col-8">: {{ $examination->vitality->waist_circumferennce ?? "-" }}</div>
                                </div>
                                <div class="col-12">&nbsp;</div>
                                <div class="col-12 row">
                                    <div class="col-4">Neck Circumference</div>
                                    <div class="col-8">: {{ $examination->vitality->neck_circumference ?? "-" }}</div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-4">Chest Size</div>
                                    <div class="col-8">: {{ $examination->vitality->chest_size ?? "-" }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end::Alert-->

                @if(isset($examination->vitality->skrining))
                    <!--begin::Alert-->
                    <div class="alert alert-dismissible bg-light-success d-flex flex-column flex-sm-row p-5 mb-10">
                        <!--begin::Icon-->
                        <i class="ki-duotone ki-notification-bing fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        <!--end::Icon-->

                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column pe-0 pe-sm-10">
                            <!--begin::Title-->
                            <h4 class="fw-bold">Skrining Awal</h4>
                            <!--end::Title-->

                            <!--begin::Content-->
                            <div class="row">
                                @php $skrining = json_decode($examination->vitality->skrining); @endphp
                                @foreach($skrining as $key => $value)
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4 fw-bolder">{{ ucwords(str_replace('_',' ',$key)) }}</div>
                                            <div class="col-8">: {{ $value }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Close-->
                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor"/>
                            <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor"/>
                            </svg></span>
                            <!--end::Svg Icon-->
                        </button>
                        <!--end::Close-->

                    </div>
                    <!--end::Alert-->
                @endif

                <form id="kt_modal_add_examinations_form" method="POST" class="form" action="{{ route('examinations.update',['examination' => $examination->id]) }}">
                    @method('PUT')
                    {{ csrf_field() }}
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column flex-row-fluid">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Health Profesional') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <select name="health_profesional_id" aria-label="{{ __('Health Profesional') }}" data-control="select2" data-placeholder="{{ __('Select a Health Profesional...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Health Profesional...') }}</option>
                                    @foreach($healthprofesionals as $healthprofesional)
                                        <option value="{{ $healthprofesional->id }}" {{ $healthprofesional->id === old('health_profesional_id', $examination->health_profesional_id ?? '') ? 'selected' :'' }}>
                                            @if(isset($healthprofesional->user->info))
                                                {{ ($healthprofesional->user->info->title_prefix !='' ? $healthprofesional->user->info->title_prefix.'. ' : '').$healthprofesional->user->name.($healthprofesional->user->info->title_suffix!='' ? ', '.$healthprofesional->user->info->title_suffix : '') }}
                                            @else
                                                {{$healthprofesional->user->name}}
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
                                    <textarea name="subjective" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('subjective') is-invalid @enderror" placeholder="Subjective">{{ $examination->subjective }}</textarea>
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
                                    <textarea name="objective" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('objective') is-invalid @enderror" placeholder="Objective">{{ $examination->objective }}</textarea>
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
                                <select id="icdtens" aria-label="{{ __('Select a Diagnosa') }}" data-control="select2" data-placeholder="{{ __('Select a Diagnosa...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Diagnosa...') }}</option>
                                    @foreach($icdtens as $icdten)
                                        <option value="{{ $icdten->id }}">{{  $icdten->code.' - '.$icdten->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group input-group-solid has-validation mb-3 mt-3">
                                    <textarea name="assessment" id="assessment" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('assessment') is-invalid @enderror" placeholder="Assessment">{{ $examination->assessment }}</textarea>
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
                                <select name="plan_id" aria-label="{{ __('Select a Plan') }}" data-control="select2" data-placeholder="{{ __('Select a Plan...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Plan...') }}</option>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" {{  $plan->id === old('plan_id', $examination->plan_id ?? '') ? 'selected' :'' }}>{{  $plan->name }}</option>
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
                                <div class="d-flex flex-row" id="inputFromRow">
                                    <select name="resep[obat][]" aria-label="{{ __('Pilih Obat') }}" data-placeholder="{{ __('Pilih Obat...') }}" class="mb-2 form-select form-select-solid form-select-lg fw-bold me-5">
                                        <option value="">{{ __('Pilih Obat...') }}</option>
                                        @foreach($drugs as $drug)
                                            <option value="{{ $drug->id }}">{{  $drug->name }}</option>
                                        @endforeach
                                    </select>
                                    <input placeholder="Keterangan" name="resep[keterangan][]" class="w-200px me-5 form-control form-control-solid" type="text">
                                    <input placeholder="Qty" name="resep[qty][]" class="w-100px me-5 form-control form-control-solid" type="number" min="1">
                                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="remove-item">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                        <span class="svg-icon svg-icon-3">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"/>
																							<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"/>
																							<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"/>
																						</svg>
																					</span>
                                        <!--end::Svg Icon-->
                                    </button>
                                </div>

                                <div class="d-flex flex-column" id="newRow"></div>
                                <i class="btn btn-primary" id="tambah_obat">Tambah</i>
                                @error('resep')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Saran</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid has-validation mb-3">
                                    <textarea name="saran" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('saran') is-invalid @enderror" placeholder="Saran">{{ $examination->saran }}</textarea>
                                </div>
                                @error('saran')
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
            <div class="tab-pane" id="suratketerangan" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
                <div class="d-flex flex-column flex-md-row rounded border p-10">
                    <ul class="nav nav-tabs nav-pills flex-row border-0 flex-md-column me-5 mb-3 mb-md-0 fs-6 min-w-lg-200px">
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link active w-100 active btn btn-flex btn-active-light-success" data-bs-toggle="tab"
                               href="#suratsehat">
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-7 fw-bold">Surat Keterangan Sehat</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab"
                               href="#suratsakit">
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-7 fw-bold">Surat Keterangan Sakit</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab"
                               href="#hakkewajiban">
                                <span class="d-flex flex-column align-items-start" style="text-align:left">
                                    <span class="fs-7 fw-bold">Bukti Penyampaian Hak dan Kewajiban</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab"
                               href="#persetujuan">
                                <span class="d-flex flex-column align-items-start" style="text-align:left">
                                    <span class="fs-7 fw-bold">Persetujuan Tindakan Medis</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab"
                               href="#penandaanoperasi">
                                <span class="d-flex flex-column align-items-start" style="text-align:left">
                                    <span class="fs-7 fw-bold">Penandaan Lokasi Operasi</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab"
                               href="#surgicalsafetychecklist">
                                <span class="d-flex flex-column align-items-start" style="text-align:left">
                                    <span class="fs-7 fw-bold">Surgical Safety Checklist</span>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content w-100 container" id="myTabContent">
                        <div class="tab-pane fade" id="penandaanoperasi" role="tabpanel">
                            @if($info->gender->name == 'Pria')
                                <img id="penandaan_operasi" src="{{ asset('assets/media/penandaan_operasi_pria.png') }}">
                            @else
                                <img id="penandaan_operasi" src="{{ asset('assets/media/penandaan_operasi_wanita.png') }}">
                            @endif
                            <div id="point"></div>
                            <form method="post" action="{{ route('suket.operasi',$examination->id) }}">
                                @csrf
                                <input type="hidden" name="coordinate_x" id="coordinate_x">
                                <input type="hidden" name="coordinate_y" id="coordinate_y">

                                <table class="table" style="width:100%">
                                    <tbody>
                                    <tr>
                                        <td>Ruangan</td>
                                        <td class="d-flex">:&nbsp;<input type="text" name="ruangan" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Ruangan">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Operasi</td>
                                        <td class="d-flex">:&nbsp;<input type="text" name="operasi" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Jenis Operasi">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td class="d-flex">:&nbsp;<input type="date" name="tanggal" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Tanggal">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Waktu</td>
                                        <td class="d-flex">:&nbsp;<input type="time" name="jam" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Waktu">
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-bg-dark text-white">Download PDF</button>
                            </form>
                        </div>
                        <div class="tab-pane fade active show" id="suratsehat" role="tabpanel">
                            <h3 class="fs-3 fw-bold">Informasi Kesehatan</h3>
                            <div class="table-responsive">
                                <form method="post" action="{{ route('suket.sehat',$examination->id) }}">
                                    <table class="table" style="width:100%">
                                        <tbody>
                                        <tr>
                                            <td>Tinggi Badan</td>
                                            <td>: {{ $examination->vitality->height ?? "-" }} cm</td>
                                        </tr>
                                        <tr>
                                            <td>Berat Badan</td>
                                            <td>: {{ $examination->vitality->weight ?? "-" }} kg</td>
                                        </tr>
                                        <tr>
                                            <td>Tekanan Darah</td>
                                            <td>: {{ $examination->vitality->blood_pressure ?? "-" }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nadi</td>
                                            <td>: {{ $examination->vitality->heart_rate ?? "-" }}</td>
                                        </tr>
                                        <tr>
                                            <td>Suhu Tubuh</td>
                                            <td>: {{ $examination->vitality->temperature ?? "-" }}</td>
                                        </tr>
                                        <tr>
                                            <td><label for="gigi">Gigi</label></td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <select class="form-select form-select-solid form-select-lg fw-bold" name="gigi" id="gigi">
                                                        <option value="Normal">Normal</option>
                                                        <option value="Tidak Normal">Tidak Normal</option>
                                                    </select>
                                                    <input type="text" name="keterangan_gigi" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Keterangan">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="keadaan_umum">Keadaan Umum</label></td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <select class="form-select form-select-solid form-select-lg fw-bold" name="keadaan_umum" id="keadaan_umum">
                                                        <option value="Normal">Normal</option>
                                                        <option value="Tidak Normal">Tidak Normal</option>
                                                    </select>
                                                    <input type="text" name="keterangan_keadaan_umum" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Keterangan">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="mata">Mata</label></td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <select class="form-select form-select-solid form-select-lg fw-bold" name="mata" id="mata">
                                                        <option value="Normal">Normal</option>
                                                        <option value="Tidak Normal">Tidak Normal</option>
                                                    </select>
                                                    <input type="text" name="keterangan_mata" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Keterangan">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="tht">THT</label></td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <select class="form-select form-select-solid form-select-lg fw-bold" name="tht" id="tht">
                                                        <option value="Normal">Normal</option>
                                                        <option value="Tidak Normal">Tidak Normal</option>
                                                    </select>
                                                    <input type="text" name="keterangan_tht" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Keterangan">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="mulut">Mulut</label></td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <select class="form-select form-select-solid form-select-lg fw-bold" name="mulut" id="mulut">
                                                        <option value="Normal">Normal</option>
                                                        <option value="Tidak Normal">Tidak Normal</option>
                                                    </select>
                                                    <input type="text" name="keterangan_mulut" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Keterangan">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="dada">Dada (Paru & Jantung)</label></td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <select class="form-select form-select-solid form-select-lg fw-bold" name="dada" id="dada">
                                                        <option value="Normal">Normal</option>
                                                        <option value="Tidak Normal">Tidak Normal</option>
                                                    </select>
                                                    <input type="text" name="keterangan_dada" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Keterangan">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="perut">Perut</label></td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <select class="form-select form-select-solid form-select-lg fw-bold" name="perut" id="perut">
                                                        <option value="Normal">Normal</option>
                                                        <option value="Tidak Normal">Tidak Normal</option>
                                                    </select>
                                                    <input type="text" name="keterangan_perut" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Keterangan">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="extremitas">Extremitas</label></td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <select class="form-select form-select-solid form-select-lg fw-bold" name="extremitas" id="extremitas">
                                                        <option value="Normal">Normal</option>
                                                        <option value="Tidak Normal">Tidak Normal</option>
                                                    </select>
                                                    <input type="text" name="keterangan_extremitas" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Keterangan">
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                            </div>

                            @csrf
                            <div class="row">
                                <div class="mb-10">
                                    <label for="exampleFormControlInput1" class="form-label">Keterangan</label>
                                    <textarea rows="3" class="form-control form-control-solid" placeholder="Keterangan" name="description"></textarea>
                                </div>
                                <button type="submit" class="btn btn-bg-dark text-white">Download PDF</button>
                            </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="suratsakit" role="tabpanel">
                            <form action="{{ route('suket.sakit',$examination->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="mb-10">
                                        <label for="exampleFormControlInput1" class="required form-label">Pekerjaan</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Pekerjaan" name="pekerjaan" value="{{ $info->job_title ?? "" }}"/>
                                    </div>
                                    <div class="mb-10">
                                        <label for="exampleFormControlInput1" class="required form-label">Perusahaan</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Perusahaan" name="perusahaan" value="{{ $info->company_name ?? "" }}"/>
                                    </div>
                                    <hr>
                                    <p class="col-lg-4 col-form-label fw-bold fs-6">Keterangan Informasi</p>
                                    <!--begin::Switch-->
                                    <div class="mb-10">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" name="keterangan" value="1"/>
                                            <span class="form-check-label fw-semibold text-muted">
                                                Dapat Kembali Bekerja
                                            </span>
                                        </label>
                                    </div>

                                    <div class="mb-10">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" name="keterangan" value="2"/>
                                            <span class="form-check-label fw-semibold text-muted d-flex flex-row" style="align-items: center;align-content: space-between;">
                                                Disarankan untuk beristirahat selama : <input name="hari" type="number" class="form-control form-control-solid w-50px"> hari, dari tanggal : <input class="form-control form-control-solid w-300px" name="start_date" type="date"> s.d <input name="end_date" class="form-control form-control-solid w-300px" type="date">
                                            </span>
                                        </label>
                                    </div>

                                    <div class="mb-10">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" name="keterangan" value="3"/>
                                            <span class="form-check-label fw-semibold text-muted d-flex flex-row" style="align-items: center;align-content: space-between;">
                                                Perlu datang kembali ke klinik pada : <input name="back_date" class="form-control form-control-solid w-300px" type="date">
                                            </span>
                                        </label>
                                    </div>

                                    <div class="mb-10">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" name="keterangan" value="4"/>
                                            <span class="form-check-label fw-semibold text-muted">
                                                Perlu dirujuk ke Rumah Sakit untuk mendapatkan pemeriksaan lebih lanjut
                                            </span>
                                        </label>
                                    </div>
                                    <div class="mb-10">
                                        <label for="exampleFormControlInput1" class="form-label">Keterangan</label>
                                        <textarea rows="3" class="form-control form-control-solid" placeholder="Keterangan" name="description"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-bg-dark text-white">Download PDF</button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="hakkewajiban" role="tabpanel">
                            <h3 class="fs-3 fw-bold">Bukti Penyampaian Hak dan Kewajiban</h3>
                            <form method="post" action="{{ route('suket.hakkewajiban', $examination->id) }}">
                                @csrf
                                <div class="row">
                                    <button id="button_bukti_penyampaian" type="submit" class="btn btn-bg-dark text-white" style="display:none">Download PDF</button>
                                    <div id="signature_bukti_penyampaian" class="row text-center" style="display: none">
                                        {!! $qr !!}
                                        <em class="text-center">Scan untuk melakukan Tanda Tangan</em><br>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="tab-pane fade" id="persetujuan" role="tabpanel">
                            <h3 class="fs-3 fw-bold">Persetujuan Tindakan Medis</h3>
                            <div class="table-responsive">
                                <form method="post" action="{{ route('suket.persetujuan',$examination->id) }}">
                                    <table class="table" style="width:100%">
                                        <tbody>
                                        <tr>
                                            <td>Dkter Pelaksana Tindakan</td>
                                            <td>: {{ (!in_array($examination->health_profesional->user->info->title_prefix,['','-']) ? $examination->health_profesional->user->info->title_prefix.'. ' : '').$examination->health_profesional->user->name.(!in_array($examination->health_profesional->user->info->title_suffix,['','-']) ? ', '.$examination->health_profesional->user->info->title_suffix : '') }}</b>
                                                <br>
                                                <b>{{ $examination->health_profesional->sip_number ? 'SIP.'.$examination->health_profesional->sip_number : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pemberi Informasi</td>
                                            <td class="d-flex">:&nbsp;<input type="text" name="pemberi_informasi" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Pemberi Informasi">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Penerima Informasi/pemberi persetujuan</td>
                                            <td>: {{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Diagnosis (WD & DD)</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" name="diagnosis" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Isi Informasi">
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="diagnosis_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dasar Diagnosis</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" name="dasar_diagnosis" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Isi Informasi">
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="dasar_diagnosis_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Tindakan Kedokteran</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" name="tindakan" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Isi Informasi">
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="tindakan_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Indikasi Tindakan</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" name="indikasi" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Isi Informasi">
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="indikasi_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Tata Cara</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" name="tatacara" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Isi Informasi">
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="tatacara_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Tujuan</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" name="tujuan" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Isi Informasi">
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="tujuan_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Resiko</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" name="resiko" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Isi Informasi">
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="resiko_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Komplikasi</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" name="komplikasi" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Isi Informasi">
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="komplikasi_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Prognosis</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" name="prognosis" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Isi Informasi">
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="prognosis_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Alternatif dan Resiko</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" name="alternatif" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Isi Informasi">
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="alternatif_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Lain-lain</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" name="lain" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Isi Informasi">
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="lain_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Yang Bertandatangan</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" value="{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}" name="nama" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Nama">
                                                    <input type="text" name="umur" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Umur">
                                                    <input type="text" name="jenis_kelamin" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Jenis Kelamin">
                                                    <input type="text" name="alamat" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Alamat">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tindakan Terhadap</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" value="Saya" name="terhadap" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Saya">
                                                    <input type="text" name="jenis_tindakan" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Jenis Tindakan">
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Pemberi Persetujuan</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" value="{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}" name="nama_tindak" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Nama">
                                                    <input type="text" name="umur_tindak" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Umur">
                                                    <input type="text" name="jenis_kelamin_tindak" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Jenis Kelamin">
                                                    <input type="text" name="alamat_tindak" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Alamat">
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                            </div>

                            @csrf
                            <div class="row">
                            <div class="form-check form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="radio" id="setuju" name="persetujuan" value="setuju" onchange="toggleAlasan()" />
                                <label class="form-check-label fw-semibold text-black" for="setuju">
                                    Setuju dengan Tindakan yang telah dijelaskan
                                </label>
                            </div>
                            <div class="form-check form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="radio" id="tidakSetuju" name="persetujuan" value="tidakSetuju" onchange="toggleAlasan()" />
                                <label class="form-check-label fw-semibold text-black" for="tidakSetuju">
                                    Tidak Setuju dengan Tindakan yang telah dijelaskan
                                </label>
                            </div>
                            <div id="alasanContainer" style="display: none;" class="mb-10">
                                <label for="exampleFormControlInput1" class="form-label">Alasan :</label>
                                <textarea rows="3" class="form-control form-control-solid" placeholder="Alasan" name="description"></textarea>
                            </div>
                            <div id="signature_persetujuan_tindakan_medis" class="row text-center">
                                {!! $qr2 !!}
                                <em class="text-center">Scan untuk melakukan Tanda Tangan</em><br>
                            </div>
                            <script>
                            function toggleAlasan() {
                                const tidakSetujuCheckbox = document.getElementById('tidakSetuju');
                                const alasanContainer = document.getElementById('alasanContainer');

                                if (tidakSetujuCheckbox.checked) {
                                    alasanContainer.style.display = 'block'; 
                                } else {
                                    alasanContainer.style.display = 'none'; 
                                }
                            }
                            </script>
                                <button type="submit" class="btn btn-bg-dark text-white">Download PDF</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="psikososial" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
                <div class="d-flex flex-column flex-md-row rounded border p-10">
                    <form method="POST" class="form" action="{{ route('examination.psikososial') }}">
                        @method('POST')
                        {{ csrf_field() }}
                        <!--begin::Scroll-->
                        <div class="row">
                            <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            @if(isset($examination->psikososial))
                                @php $psikososial = json_decode($examination->psikososial); @endphp
                            @endif
                            <!--begin::Input group-->
                            <div class="col-12 mb-6">
                                <h4>Kebutuhan Khusus</h4>
                                <div class="d-flex flex-row">
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Alat bantu Dengar" class="form-check-input h-20px w-30px me-5" type="radio" name="khusus" id="khusus_satu" {{ isset($psikososial->khusus) && $psikososial->khusus == "Alat bantu Dengar" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="khusus_satu">
                                                Alat bantu Dengar
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Kacamata" class="form-check-input h-20px w-30px me-5" type="radio" name="khusus" id="khusus_dua" {{ isset($psikososial->khusus) && $psikososial->khusus == "Kacamata" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="khusus_dua">
                                                Kacamata
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tongkat" class="form-check-input h-20px w-30px me-5" type="radio" name="khusus" id="khusus_tiga" {{ isset($psikososial->khusus) && $psikososial->khusus == "Tongkat" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="khusus_tiga">
                                                Tongkat
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Kursi Roda" class="form-check-input h-20px w-30px me-5" type="radio" name="khusus" id="khusus_empat" {{ isset($psikososial->khusus) && $psikososial->khusus == "Kursi Roda" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="khusus_empat">
                                                Kursi Roda
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Disabilitas" class="form-check-input h-20px w-30px me-5" type="radio" name="khusus" id="khusus_lima" {{ isset($psikososial->khusus) && $psikososial->khusus == "Disabilitas" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="khusus_lima">
                                                Disabilitas
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex flex-row mt-2">
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak Ada" class="form-check-input h-20px w-30px me-5" type="radio" name="khusus" id="khusus_enam" {{ isset($psikososial->khusus) && $psikososial->khusus == "Tidak Ada" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="khusus_enam">
                                                Tidak Ada
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-400px">
                                            <input value="Lainnya" class="form-check-input h-20px w-30px me-5" type="radio" name="khusus" id="khusus_tujuh" {{ isset($psikososial->khusus) && $psikososial->khusus == "Lainnya" ? 'checked' : '' }}/>
                                            <label class="form-check-label me-5 w-150px" for="khusus_tujuh">
                                                Lainnya
                                            </label>
                                            <input class="form-control form-control-sm me-5" name="lainnya" value="{{ isset($psikososial->khusus) && $psikososial->khusus == 'Lainnya' ? $psikososial->lainnya : '' }}"/>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="col-12 mb-6">
                                <h4>Data Psikologi Dan Sosial</h4>
                                <div class="d-flex flex-row">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">Bicara</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Jelas" class="form-check-input h-20px w-30px me-5" type="radio" name="bicara" id="bicara_satu" {{ isset($psikososial->bicara) && $psikososial->bicara == "Jelas" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="bicara_satu">
                                                Jelas
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak Dimengerti" class="form-check-input h-20px w-30px me-5" type="radio" name="bicara" id="bicara_dua" {{ isset($psikososial->bicara) && $psikososial->bicara == "Tidak Dimengerti" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="bicara_dua">
                                                TIdak Dimen
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
                                        <label for="pulse" class="form-label">Komunikasi</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Verbal" class="form-check-input h-20px w-30px me-5" type="radio" name="komunikasi" id="komunikasi_satu" {{ isset($psikososial->komunikasi) && $psikososial->komunikasi == "Verbal" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="komunikasi_satu">
                                                Verbal
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Non Verbal" class="form-check-input h-20px w-30px me-5" type="radio" name="komunikasi" id="komunikasi_dua" {{ isset($psikososial->komunikasi) && $psikososial->komunikasi == "Non Verbal" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="komunikasi_dua">
                                                Non Verbal
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
                                        <label for="pulse" class="form-label">Status Emosional</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Stabil/Tenang" class="form-check-input h-20px w-30px me-5" type="radio" name="emosional" id="emosional_satu" {{ isset($psikososial->emosional) && $psikososial->emosional == "Stabil/Tenang" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="emosional_satu">
                                                Stabil/Tenang
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Marah" class="form-check-input h-20px w-30px me-5" type="radio" name="emosional" id="emosional_dua" {{ isset($psikososial->emosional) && $psikososial->emosional == "Marah" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="emosional_dua">
                                                Marah
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Cemas" class="form-check-input h-20px w-30px me-5" type="radio" name="emosional" id="emosional_tiga" {{ isset($psikososial->emosional) && $psikososial->emosional == "Cemas" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="emosional_tiga">
                                                Cemas
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Takut" class="form-check-input h-20px w-30px me-5" type="radio" name="emosional" id="emosional_empat" {{ isset($psikososial->emosional) && $psikososial->emosional == "Takut" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="emosional_empat">
                                                Takut
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Sedih" class="form-check-input h-20px w-30px me-5" type="radio" name="emosional" id="emosional_lima" {{ isset($psikososial->emosional) && $psikososial->emosional == "Sedih" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="emosional_lima">
                                                Sedih
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
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak ada" class="form-check-input h-20px w-30px me-5" type="radio" name="nyeri" id="nyeri_satu" {{ isset($psikososial->nyeri) && $psikososial->nyeri == "Tidak ada" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="nyeri_satu">
                                                Tidak ada
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Ada (Tingkat Sedang)" class="form-check-input h-20px w-30px me-5" type="radio" name="nyeri" id="nyeri_dua" {{ isset($psikososial->nyeri) && $psikososial->nyeri == "Ada (Tingkat Sedang)" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="nyeri_dua">
                                                Ada (Tingkat Sedang)
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Nyeri dada kiri tembus punggung" class="form-check-input h-20px w-30px me-5" type="radio" name="nyeri" id="nyeri_dua" {{ isset($psikososial->nyeri) && $psikososial->nyeri == "Nyeri dada kiri tembus punggung" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="kriteria_dua">
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
                                        <label for="pulse" class="form-label">Sosiologi</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Komunikatif" class="form-check-input h-20px w-30px me-5" type="radio" name="sosiologi" id="sosiologi_satu" {{ isset($psikososial->sosiologi) && $psikososial->sosiologi == "Komunikatif" ? 'checked' : '' }}/>

                                            <label class="form-check-label" for="sosiologi_satu">
                                                Komunikatif
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Komunikatif Tidak Efek" class="form-check-input h-20px w-30px me-5" type="radio" name="sosiologi" id="sosiologi_dua" {{ isset($psikososial->sosiologi) && $psikososial->sosiologi == "Komunikatif Tidak Efek" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="sosiologi_dua">
                                                Komunikatif Tidak Efek
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Menarik Diri" class="form-check-input h-20px w-30px me-5" type="radio" name="sosiologi" id="sosiologi_tiga" {{ isset($psikososial->sosiologi) && $psikososial->sosiologi == "Menarik Diri" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="sosiologi_tiga">
                                                Menarik Diri
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="col-12 mb-6">
                                <h4>Riwayat Pekerjaan</h4>
                                <div class="d-flex flex-row mt-2">
                                    <div class="d-flex flex-column flex-row-auto">
                                        <label for="pulse" class="form-label">Apakah pekerjaan pasien berhubungan dengan zat berbahaya (misal : kimia , gas, dll)</label>
                                    </div>
                                </div>
                                <div class="d-flex flex-row mt-2">
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_pekerjaan[zat_bahaya]" id="riwayat_pekerjaan_satu" {{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->zat_bahaya == "Tidak" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_pekerjaan_satu">
                                                Tidak
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-400px">
                                            <input value="Ya" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_pekerjaan[zat_bahaya]" id="riwayat_pekerjaan_dua" {{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->zat_bahaya == "Ya" ? 'checked' : '' }}/>
                                            <label class="form-check-label me-5 w-150px" for="riwayat_pekerjaan_dua">
                                                Ya, sebutkan
                                            </label>
                                            <input class="form-control form-control-sm me-5" name="riwayat_pekerjaan_bahaya" value="{{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->zat_bahaya == 'Ya' ? $psikososial->riwayat_pekerjaan_bahaya : '' }}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row mt-5">
                                    <div class="d-flex flex-column flex-row-auto">
                                        <label for="pulse" class="form-label">Riwayat bepergian dalam satu bulan terakhir</label>
                                    </div>
                                </div>
                                <div class="d-flex flex-row mt-2">
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_pekerjaan[berpergian]" id="riwayat_pekerjaan_tiga" {{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->berpergian == "Tidak" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_pekerjaan_tiga">
                                                Tidak
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-400px">
                                            <input value="Ya" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_pekerjaan[berpergian]" id="riwayat_pekerjaan_empat" {{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->berpergian == "Ya" ? 'checked' : '' }}/>
                                            <label class="form-check-label me-5 w-150px" for="riwayat_pekerjaan_empat">
                                                Ya, sebutkan
                                            </label>
                                            <input class="form-control form-control-sm me-5" name="riwayat_pekerjaan_berpergian" value="{{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->berpergian == 'Ya' ? $psikososial->riwayat_pekerjaan_berpergian : '' }}"/>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="col-12 mb-6">
                                <h4>Riwayat Kesehatan</h4>
                                <div class="d-flex flex-row">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">Riwayat Alergi Obat :</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak Ada" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[alergi_obat]" id="riwayat_kesehatan_satu" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_obat == "Tidak Ada" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_satu">
                                                Tidak Ada
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-400px">
                                            <input value="Ada" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[alergi_obat]" id="riwayat_kesehatan_dua" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_obat == "Ada" ? 'checked' : '' }}/>
                                            <label class="form-check-label me-5 w-150px" for="riwayat_kesehatan_dua">
                                                Ada, Sebutkan
                                            </label>
                                            <input class="form-control form-control-sm me-5" name="riwayat_alergi_obat" value="{{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_obat == 'Ada' ? $psikososial->riwayat_alergi_obat : '' }}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row mt-5">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">Riwayat Alergi makanan :</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak Ada" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[alergi_makanan]" id="riwayat_kesehatan_tiga" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_makanan == "Tidak Ada" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_tiga">
                                                Tidak Ada
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-400px">
                                            <input value="Ada" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[alergi_makanan]" id="riwayat_kesehatan_empat" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_makanan == "Ada" ? 'checked' : '' }}/>
                                            <label class="form-check-label me-5 w-150px" for="riwayat_kesehatan_empat">
                                                Ada, Sebutkan
                                            </label>
                                            <input class="form-control form-control-sm me-5" name="riwayat_alergi_makanan" value="{{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_makanan == 'Ada' ? $psikososial->riwayat_alergi_makanan : '' }}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row mt-5">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">Riwayat Penyakit Dahulu :</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Hipertensi" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_dahulu]" id="riwayat_kesehatan_5" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_dahulu == "Hipertensi" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_5">
                                                Hipertensi
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="DM" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_dahulu]" id="riwayat_kesehatan_6" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_dahulu == "DM" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_6">
                                                DM
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="PJK" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_dahulu]" id="riwayat_kesehatan_7" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_dahulu == "PJK" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_7">
                                                PJK
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Asm" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_dahulu]" id="riwayat_kesehatan_8" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_dahulu == "Asm" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_8">
                                                Asm
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row mt-5">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">&nbsp;</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Stroke" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_dahulu]" id="riwayat_kesehatan_9" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_dahulu == "Stroke" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_9">
                                                Stroke
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Liver" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_dahulu]" id="riwayat_kesehatan_10" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_dahulu == "Liver" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_10">
                                                Liver
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Ginjal" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_dahulu]" id="riwayat_kesehatan_11" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_dahulu == "Ginjal" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_11">
                                                Ginjal
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="TB Paru" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_dahulu]" id="riwayat_kesehatan_12" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_dahulu == "TB Paru" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_12">
                                                TB Paru
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row mt-5">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">&nbsp;</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Hepatitis" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_dahulu]" id="riwayat_kesehatan_13" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_dahulu == "Hepatitis" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_13">
                                                Hepatitis
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak Ada" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_dahulu]" id="riwayat_kesehatan_14" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_dahulu == "Tidak Ada" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_14">
                                                Tidak Ada
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-400px">
                                            <input value="Lain-lain" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_dahulu]" id="riwayat_kesehatan_15" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_dahulu == "Lain-lain" ? 'checked' : '' }}/>
                                            <label class="form-check-label w-150px" for="riwayat_kesehatan_15">
                                                Lain-lain
                                            </label>
                                            <input class="form-control form-control-sm me-5" name="riwayat_penyakit_dahulu" value="{{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_dahulu == 'Lain-lain' ? $psikososial->riwayat_penyakit_dahulu : '' }}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row mt-5">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">Riwayat Penyakit Dalam Keluarga :</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Hipertensi" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_keluarga]" id="riwayat_kesehatan_16" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == "Hipertensi" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_16">
                                                Hipertensi
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="DM" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_keluarga]" id="riwayat_kesehatan_17" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == "DM" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_17">
                                                DM
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="PJK" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_keluarga]" id="riwayat_kesehatan_18" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == "PJK" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_18">
                                                PJK
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Asm" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_keluarga]" id="riwayat_kesehatan_19" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == "Asm" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_19">
                                                Asm
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row mt-5">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">&nbsp;</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Stroke" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_keluarga]" id="riwayat_kesehatan_20" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == "Stroke" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_20">
                                                Stroke
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Liver" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_keluarga]" id="riwayat_kesehatan_21" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == "Liver" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_21">
                                                Liver
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Liver" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_keluarga]" id="riwayat_kesehatan_21" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == "Liver" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_22">
                                                Ginjal
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Ginjal" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_keluarga]" id="riwayat_kesehatan_22" {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == "Ginjal" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_23">
                                                TB Paru
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row mt-5">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">&nbsp;</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Hepatitis" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_keluarga]" id="riwayat_kesehatan_24" {{ isset($examination->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == "Hepatitis" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_24">
                                                Hepatitis
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Hemofilia" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_keluarga]" id="riwayat_kesehatan_25" {{ isset($examination->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == "Hemofilia" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_25">
                                                Hemofilia
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak Ada" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_keluarga]" id="riwayat_kesehatan_26" {{ isset($examination->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == "Tidak Ada" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="riwayat_kesehatan_26">
                                                Tidak Ada
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-400px">
                                            <input value="Lain-lain" class="form-check-input h-20px w-30px me-5" type="radio" name="riwayat_kesehatan[penyakit_keluarga]" id="riwayat_kesehatan_27" {{ isset($examination->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == "Lain-lain" ? 'checked' : '' }}/>
                                            <label class="form-check-label w-150px" for="riwayat_kesehatan_27">
                                                Lain-lain
                                            </label>
                                            <input class="form-control form-control-sm me-5" name="riwayat_penyakit_keluarga" value="{{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->penyakit_keluarga == 'Lain-lain' ? $psikososial->riwayat_penyakit_keluarga : '' }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--begin::Input group-->
                            <div class="col-12 mb-6">
                                <h4>Pola Kebiasaan</h4>
                                <div class="d-flex flex-row">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">Nutrisi</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Cukup makan sayur/buah" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[nutrisi]" id="nutrisi_satu" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->nutrisi == "Cukup makan sayur/buah" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="nutrisi_satu">
                                                Cukup makan sayur/buah
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Kurang makan sayur/buah" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[nutrisi]" id="nutrisi_dua" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->nutrisi == "Kurang makan sayur/buah" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="nutrisi_dua">
                                                Kurang makan sayur/buah
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak makan sayur/buah" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[nutrisi]" id="nutrisi_tiga" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->nutrisi == "Tidak makan sayur/buah" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="nutrisi_tiga">
                                                Tidak makan sayur/buah
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">Istirahat Cukup</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak ada kelainan" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[istirahat]" id="istirahat_satu" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->istirahat == "Tidak ada kelainan" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="istirahat_satu">
                                                Tidak ada kelainan
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Insomnia" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[istirahat]" id="istirahat_dua" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->istirahat == "Insomnia" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="istirahat_dua">
                                                Insomnia
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">Aktivitas</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="30 menit/hari" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[aktivitas]" id="aktivitas_satu" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->aktivitas == "30 menit/hari" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="aktivitas_satu">
                                                30 menit/hari
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="<30 menit/hari" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[aktivitas]" id="aktivitas_dua" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->aktivitas == "<30 menit/hari" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="aktivitas_dua">
                                                <30 menit/hari
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">Faktor risiko asap rokok</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Ya" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[rokok]" id="rokok_satu" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->rokok == "Ya" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="rokok_satu">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[rokok]" id="rokok_dua" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->rokok == "Tidak" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="rokok_dua">
                                                Tidak
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="perokok aktif" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[rokok]" id="rokok_tiga" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->rokok == "perokok aktif" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="rokok_tiga">
                                                perokok aktif
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="perokok pasif" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[rokok]" id="rokok_empat" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->rokok == "perokok pasif" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="rokok_empat">
                                                perokok pasif
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="d-flex flex-column flex-row-auto w-200px">
                                        <label for="pulse" class="form-label">Minum alkohol</label>
                                    </div>
                                    <div class="d-flex flex-row flex-row-fluid">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Ya" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[alkohol]" id="alkohol_satu" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->alkohol == "Ya" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="alkohol_satu">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="form-check form-switch form-check-custom form-check-solid me-10 w-200px">
                                            <input value="Tidak" class="form-check-input h-20px w-30px me-5" type="radio" name="pola_kebiasaan[alkohol]" id="alkohol_dua" {{ isset($psikososial->pola_kebiasaan) && $psikososial->pola_kebiasaan->alkohol == "Tidak" ? 'checked' : '' }}/>
                                            <label class="form-check-label" for="alkohol_dua">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

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
</div>
<div id="resep" style="display: none">
    <div class="d-flex flex-row" id="inputFromRow">
        <select name="resep[obat][]" aria-label="{{ __('Pilih Obat') }}" data-placeholder="{{ __('Pilih Obat...') }}" class="mb-2 form-select form-select-solid form-select-lg fw-bold me-5">
            <option value="">{{ __('Pilih Obat...') }}</option>
            @foreach($drugs as $drug)
                <option value="{{ $drug->id }}">{{  $drug->name }}</option>
            @endforeach
        </select>
        <input placeholder="Keterangan" name="resep[keterangan][]" class="w-200px me-5 form-control form-control-solid" type="text">
        <input placeholder="Qty" name="resep[qty][]" class="w-100px me-5 form-control form-control-solid" type="number" min="1">
        <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="remove-item">
            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
            <span class="svg-icon svg-icon-3">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"/>
																							<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"/>
																							<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"/>
																						</svg>
																					</span>
            <!--end::Svg Icon-->
        </button>
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

        #penandaanoperasi {
            position: relative;
        }

        #penandaan_operasi {
            position: relative; /* Needed for absolute positioning of the point */
        }

        #point {
            position: absolute;
            width: 15px;
            height: 15px;
            background-color: red;
            border-radius: 50%;
        }
    </style>
@endsection

@push('customscript')
    <script>
        $(function () {
            @if($examination->bukti_penyampaian_informasi)
            $('#button_bukti_penyampaian').show();
            $('#signature_bukti_penyampaian').hide();
            @else
            $('#button_bukti_penyampaian').hide();
            $('#signature_bukti_penyampaian').show();
            @endif
                $assesment = $("#assessment").html();
            $("#icdtens").change(function () {
                $("#assessment").append($(this).find("option:selected").text() + ' | ');
            });

            $("#tambah_obat").click(function () {
                $('#newRow').append($('#resep').html());
            });

            $(document).on('click', '#remove-item', function () {
                $(this).closest('#inputFromRow').remove();
            });

            /* setInterval(function () {
                 $.ajax({
                     url: '{{ route('bukti_penyampaian', $examination->id) }}',
                    type: 'GET',
                    success: function (data) {
                        if (data.status == 'success') {
                            $('#button_bukti_penyampaian').show();
                            $('#signature_bukti_penyampaian').hide();
                        } else {
                            $('#button_bukti_penyampaian').hide();
                            $('#signature_bukti_penyampaian').show();
                        }
                    }
                });
            }, 5000);*/

            $("#penandaan_operasi").click(function (e) {
                e.preventDefault();
                var containerOffset = $(".container").offset();
                var imageOffset = $("#image").offset();

                // Calculate click position relative to container, not image
                var x = e.clientX - containerOffset.left;
                var y = e.clientY - containerOffset.top;

                // Subtract container padding to position point accurately
                var pointLeft = x - $(".container").css("padding-left").replace("px", "");
                var pointTop = y - $(".container").css("padding-top").replace("px", "");
                $("#coordinate_x").val(pointLeft);
                $("#coordinate_y").val(pointTop);
                $("#point").css({
                    left: pointLeft + "px",
                    top: pointTop + "px"
                });
            });
        })
    </script>

    <script>
        document.getElementById('add-column').addEventListener('click', function () {
            var container = document.getElementById('input-container');

            var row = document.createElement('div');
            row.className = 'row mb-6';

            var col1 = document.createElement('div');
            col1.className = 'col-lg-4';

            var label1 = document.createElement('label');
            label1.className = 'col-form-label fw-bold fs-6';
            label1.textContent = 'Gambar';

            var input1 = document.createElement('input');
            input1.type = 'text';
            input1.name = 'gambar[]';
            input1.className = 'form-control form-control-solid mb-3';
            input1.placeholder = 'Gambar';

            col1.appendChild(label1);
            col1.appendChild(input1);

            var col2 = document.createElement('div');
            col2.className = 'col-lg-4';

            var label2 = document.createElement('label');
            label2.className = 'col-form-label fw-bold fs-6';
            label2.textContent = 'Keterangan';

            var input2 = document.createElement('input');
            input2.type = 'text';
            input2.name = 'keterangan[]';
            input2.className = 'form-control form-control-solid mb-3';
            input2.placeholder = 'Keterangan';

            col2.appendChild(label2);
            col2.appendChild(input2);

            row.appendChild(col1);
            row.appendChild(col2);

            container.appendChild(row);
        });
    </script>

    <style>
        .small-img {
            max-width: 30%; 
            height: 50%; 
        }
    </style>
@endpush
