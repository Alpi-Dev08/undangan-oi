{{-- Contact Information Section --}}
<div class="separator separator-dashed my-6"></div>
<h4 class="fw-bolder text-dark mb-6">{{ __('Contact Information') }}</h4>

{{-- Email Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">
        <span>{{ __('Email') }}</span>
    </label>

    <div class="col-lg-8 fv-row">
        <input type="email" name="email" class="form-control form-control-lg form-control-solid border border-gray-300"
            placeholder="{{ __('Email address') }}" x-model="email" value="{{ isset($user) ? $user->email : '' }}" />
        <div class="form-text">{{ __('Optional: Email address for communication') }}</div>
    </div>
</div>

{{-- Contact Phone Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">
        <span class="required">{{ __('Contact Phone') }}</span>
    </label>

    <div class="col-lg-8 fv-row">
        <input type="tel" name="phone" required
            class="form-control form-control-lg form-control-solid border border-gray-300"
            placeholder="{{ __('Phone number (e.g., +62812345678)') }}" x-model="phone"
            value="{{ isset($user) ? $user->phone : '' }}" />
        <div class="invalid-feedback">{{ __('Phone number is required') }}</div>
        <div class="form-text">{{ __('Primary contact number for patient') }}</div>
    </div>
</div>

{{-- Patient Trustee Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Patient Trustee Name (Relationship)') }}</label>

    <div class="col-lg-8 fv-row">
        <input type="text" name="patient_trusetee_name"
            class="form-control form-control-lg form-control-solid border border-gray-300"
            placeholder="{{ __('e.g., John Doe (Father)') }}" x-model="patientTrusteeName"
            value="{{ isset($info) ? $info->patient_trusetee_name : '' }}" />
        <div class="form-text">{{ __('Guardian or responsible person for the patient') }}</div>
    </div>
</div>
