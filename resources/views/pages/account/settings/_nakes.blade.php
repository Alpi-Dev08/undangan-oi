<!--begin::Basic info-->
<div class="card {{ $class }}">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('Health Profesional Details') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->

    <!--begin::Content-->
    <div id="kt_account_profile_details" class="collapse show">
        <!--begin::Form-->
        <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('settings.nakes') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!--begin::Card body-->
            <div class="card-body border-top p-9">

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Health Profesional Type') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <select name="health_profesional_type_id" aria-label="{{ __('Health Profesional Type') }}" data-control="select2" data-placeholder="{{ __('Select a Health Profesional Type...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Health Profesional Type...') }}</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{  $type->id === old('type_id', $nakes->health_profesional_type_id ?? '') ? 'selected' :'' }}>{{  $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Speciality') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <select name="speciality_id" aria-label="{{ __('Speciality') }}" data-control="select2" data-placeholder="{{ __('Select a Speciality...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Speciality...') }}</option>
                            @foreach($specialities as $speciality)
                                <option value="{{ $speciality->id }}" {{  $speciality->id === old('speciality_id', $nakes->speciality_id ?? '') ? 'selected' :'' }}>{{  $speciality->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('STR') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="text" name="str_number" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="STR Number" value="{{ old('str_number', $nakes->str_number ?? '') }}"/>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="date" name="str_expire_date" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="STR Expire Date" value="{{ old('str_expire_date', $nakes->str_expire_date ?? '') }}"/>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('SIP') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="text" name="sip_number" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="STR Number" value="{{ old('sip_number', $nakes->sip_number ?? '') }}"/>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="date" name="sip_expire_date" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="STR Expire Date" value="{{ old('sip_expire_date', $nakes->sip_expire_date ?? '') }}"/>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Status') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="health_profesional_status" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Status" value="{{ old('health_profesional_status', $nakes->health_profesional_status ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-white btn-active-light-primary me-2">{{ __('Discard') }}</button>

                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                    @include('partials.general._button-indicator', ['label' => __('Save Changes')])
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->
