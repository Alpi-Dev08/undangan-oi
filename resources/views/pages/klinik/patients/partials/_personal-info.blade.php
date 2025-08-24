{{-- Personal Information Section --}}
<div class="separator separator-dashed my-6"></div>
<h4 class="fw-bolder text-dark mb-6">{{ __('Personal Information') }}</h4>

{{-- Title Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Title') }}</label>

    <div class="col-lg-8">
        <div class="row">
            {{-- Prefix --}}
            <div class="col-lg-6 fv-row">
                <input type="text" name="title_prefix"
                    class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0"
                    placeholder="{{ __('Prefix (e.g., Dr., Prof.)') }}"
                    value="{{ isset($info) ? $info->title_prefix : '' }}" />
            </div>

            {{-- Suffix --}}
            <div class="col-lg-6 fv-row">
                <input type="text" name="title_suffix"
                    class="form-control form-control-lg form-control-solid border border-gray-300"
                    placeholder="{{ __('Suffix (e.g., Jr., Sr.)') }}"
                    value="{{ isset($info) ? $info->title_suffix : '' }}" />
            </div>
        </div>
    </div>
</div>

{{-- Full Name Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Full Name') }}</label>

    <div class="col-lg-8">
        <div class="row">
            {{-- First Name --}}
            <div class="col-lg-6 fv-row">
                <input type="text" name="first_name" required
                    class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0"
                    placeholder="{{ __('First name') }}" x-model="firstName"
                    value="{{ isset($user) ? $user->first_name : '' }}" />
                <div class="invalid-feedback">{{ __('First name is required') }}</div>
            </div>

            {{-- Last Name --}}
            <div class="col-lg-6 fv-row">
                <input type="text" name="last_name"
                    class="form-control form-control-lg form-control-solid border border-gray-300"
                    placeholder="{{ __('Last name') }}" x-model="lastName"
                    value="{{ isset($user) ? $user->last_name : '' }}" />
            </div>
        </div>
    </div>
</div>

{{-- Place and Date of Birth Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6 required">{{ __('Place and Date of Birth') }}</label>

    <div class="col-lg-8">
        <div class="row">
            {{-- Place of Birth --}}
            <div class="col-lg-6 fv-row">
                <input type="text" required name="place_of_birth"
                    class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0"
                    placeholder="{{ __('Place of Birth') }}" x-model="placeOfBirth"
                    value="{{ isset($info) ? $info->place_of_birth : '' }}" />
                <div class="invalid-feedback">{{ __('Place of birth is required') }}</div>
            </div>

            {{-- Date of Birth --}}
            <div class="col-lg-6 fv-row">
                <input type="date" required name="date_of_birth"
                    class="form-control form-control-lg form-control-solid border border-gray-300"
                    placeholder="{{ __('Date of Birth') }}" x-model="dateOfBirth"
                    value="{{ isset($info) ? $info->date_of_birth : '' }}" />
                <div class="invalid-feedback">{{ __('Date of birth is required') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Religion Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Religion') }}</label>

    <div class="col-lg-8">
        <select name="religion_id" aria-label="{{ __('Religion') }}" data-control="select2"
            data-placeholder="{{ __('Select a Religion...') }}"
            class="form-select form-select-solid form-select-lg fw-bold" x-model="religionId">
            <option value="">{{ __('Select a Religion...') }}</option>
            @foreach ($religions as $religion)
                <option value="{{ $religion->id }}"
                    {{ isset($info) && $info->religion_id == $religion->id ? 'selected' : '' }}>{{ $religion->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

{{-- Gender, Marital Status, and Blood Type Section --}}
<div class="row mb-6">
    {{-- Gender --}}
    <label class="col-lg-4 required col-form-label fw-bold fs-6">{{ __('Gender') }}</label>
    <div class="col-lg-2">
        <select name="gender_id" required aria-label="{{ __('Gender') }}" data-control="select2"
            data-placeholder="{{ __('Select a Gender...') }}"
            class="form-select form-select-solid form-select-lg fw-bold" x-model="genderId">
            <option value="">{{ __('Select a Gender...') }}</option>
            @foreach ($genders as $gender)
                <option value="{{ $gender->id }}"
                    {{ isset($info) && $info->gender_id == $gender->id ? 'selected' : '' }}>{{ $gender->name }}
                </option>
            @endforeach
        </select>
        <div class="invalid-feedback">{{ __('Gender is required') }}</div>
    </div>

    {{-- Marital Status --}}
    <label class="col-lg-1 col-form-label fw-bold fs-6">{{ __('Marital Status') }}</label>
    <div class="col-lg-2">
        <select name="marital_status_id" aria-label="{{ __('Marital Status') }}" data-control="select2"
            data-placeholder="{{ __('Select a Marital Status...') }}"
            class="form-select form-select-solid form-select-lg fw-bold" x-model="maritalStatusId">
            <option value="">{{ __('Select a Marital Status...') }}</option>
            @foreach ($maritals as $marital)
                <option value="{{ $marital->id }}"
                    {{ isset($info) && $info->marital_status_id == $marital->id ? 'selected' : '' }}>
                    {{ $marital->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Blood Type --}}
    <label class="col-lg-1 col-form-label fw-bold fs-6">{{ __('Blood Type') }}</label>
    <div class="col-lg-2">
        <select name="blood_type_id" aria-label="{{ __('Blood Type') }}" data-control="select2"
            data-placeholder="{{ __('Select a Blood Type...') }}"
            class="form-select form-select-solid form-select-lg fw-bold" x-model="bloodTypeId">
            <option value="">{{ __('Select a Blood Type...') }}</option>
            @foreach ($bloods as $blood)
                <option value="{{ $blood->id }}"
                    {{ isset($info) && $info->blood_type_id == $blood->id ? 'selected' : '' }}>{{ $blood->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

{{-- Education and Work Section --}}
<div class="row mb-6">
    {{-- Education --}}
    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Education') }}</label>
    <div class="col-lg-3">
        <select name="education_id" aria-label="{{ __('Education') }}" data-control="select2"
            data-placeholder="{{ __('Select a Education...') }}"
            class="form-select form-select-solid form-select-lg fw-bold" x-model="educationId">
            <option value="">{{ __('Select a Education...') }}</option>
            @foreach ($educations as $education)
                <option value="{{ $education->id }}"
                    {{ isset($info) && $info->education_id == $education->id ? 'selected' : '' }}>
                    {{ $education->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Work --}}
    <label class="col-lg-2 col-form-label fw-bold fs-6">{{ __('Work') }}</label>
    <div class="col-lg-3">
        <select name="work_id" aria-label="{{ __('Work') }}" data-control="select2"
            data-placeholder="{{ __('Select a Work...') }}"
            class="form-select form-select-solid form-select-lg fw-bold" x-model="workId">
            <option value="">{{ __('Select a Work...') }}</option>
            @foreach ($works as $work)
                <option value="{{ $work->id }}"
                    {{ isset($info) && $info->work_id == $work->id ? 'selected' : '' }}>{{ $work->name }}</option>
            @endforeach
        </select>
    </div>
</div>
