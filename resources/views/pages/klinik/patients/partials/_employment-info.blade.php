{{-- Employment Information Section --}}
<div class="separator separator-dashed my-6"></div>
<h4 class="fw-bolder text-dark mb-6">{{ __('Employment Information') }}</h4>

{{-- Company Name Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Company Name') }}</label>

    <div class="col-lg-8 fv-row">
        <input type="text"
               name="company_name"
               class="form-control form-control-lg form-control-solid border border-gray-300"
               placeholder="{{ __('Company Name') }}"
               x-model="companyName"
               value="{{ isset($info) ? $info->company_name : '' }}"/>
    </div>
</div>

{{-- Job Title Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Job Title') }}</label>

    <div class="col-lg-8 fv-row">
        <input type="text"
               name="job_title"
               class="form-control form-control-lg form-control-solid border border-gray-300"
               placeholder="{{ __('Job Title') }}"
               x-model="jobTitle"
               value="{{ isset($info) ? $info->job_title : '' }}"/>
    </div>
</div>

{{-- Department Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Department') }}</label>

    <div class="col-lg-8 fv-row">
        <input type="text"
               name="department"
               class="form-control form-control-lg form-control-solid border border-gray-300"
               placeholder="{{ __('Department') }}"
               x-model="department"
               value="{{ isset($info) ? $info->department : '' }}"/>
    </div>
</div>

{{-- Employee ID Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Employee ID') }}</label>

    <div class="col-lg-8 fv-row">
        <input type="text"
               name="employee_id"
               class="form-control form-control-lg form-control-solid border border-gray-300"
               placeholder="{{ __('Employee ID') }}"
               x-model="employeeId"
               value="{{ isset($info) ? $info->employee_id : '' }}"/>
    </div>
</div>

{{-- Hidden Fields (for future use) --}}
<div class="d-none">
    {{-- Date of Hire --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Date of Hire') }}</label>
        <div class="col-lg-8 fv-row">
            <input type="date"
                   name="date_of_hire"
                   class="form-control form-control-lg form-control-solid border border-gray-300"
                   placeholder="{{ __('Date of Hire') }}"
                   value="{{ isset($info) ? $info->date_of_hire : '' }}"/>
        </div>
    </div>

    {{-- Division --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Division') }}</label>
        <div class="col-lg-8 fv-row">
            <input type="text"
                   name="division"
                   class="form-control form-control-lg form-control-solid border border-gray-300"
                   placeholder="{{ __('Division') }}"
                   value="{{ isset($info) ? $info->division : '' }}"/>
        </div>
    </div>

    {{-- Section --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Section') }}</label>
        <div class="col-lg-8 fv-row">
            <input type="text"
                   name="section"
                   class="form-control form-control-lg form-control-solid border border-gray-300"
                   placeholder="{{ __('Section') }}"
                   value="{{ isset($info) ? $info->section : '' }}"/>
        </div>
    </div>

    {{-- Kind of Job --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Kind of Job') }}</label>
        <div class="col-lg-8 fv-row">
            <input type="text"
                   name="kind_of_job"
                   class="form-control form-control-lg form-control-solid border border-gray-300"
                   placeholder="{{ __('Kind of Job') }}"
                   value="{{ isset($info) ? $info->kind_of_job : '' }}"/>
        </div>
    </div>

    {{-- Shift --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Shift') }}</label>
        <div class="col-lg-8 fv-row">
            <input type="text"
                   name="shift"
                   class="form-control form-control-lg form-control-solid border border-gray-300"
                   placeholder="{{ __('Shift') }}"
                   value="{{ isset($info) ? $info->shift : '' }}"/>
        </div>
    </div>
</div>
