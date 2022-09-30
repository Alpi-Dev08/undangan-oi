<!--begin::Basic info-->
<div class="card {{ $class }}">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('Register Examination') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->

    <!--begin::Content-->
    <div id="kt_account_profile_details" class="collapse show">
        <!--begin::Form-->
        <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('settings.create.examination') }}" enctype="multipart/form-data">
        @csrf
        <!--begin::Card body-->
            <div class="card-body border-top p-9">

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Health Profesional Type') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <select name="health_profesional_id" aria-label="{{ __('Health Profesional') }}" data-control="select2" data-placeholder="{{ __('Select a Health Profesional...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Health Profesional...') }}</option>
                            @foreach($healthprofesionals as $healthprofesional)
                                <option value="{{ $healthprofesional->id }}" >
                                    {{ ($healthprofesional->user->info->title_prefix !='' ? $healthprofesional->user->info->title_prefix.'. ' : '').$healthprofesional->user->name.($healthprofesional->user->info->title_suffix!='' ? ', '.$healthprofesional->user->info->title_suffix : '') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-white btn-active-light-primary me-2">{{ __('Discard') }}</button>

                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                    @include('partials.general._button-indicator', ['label' => __('Register')])
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->
