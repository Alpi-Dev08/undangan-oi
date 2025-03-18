<div class="tab-pane" id="user" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="card-body p-9">
            <!-- Profile Picture -->
            <div class="d-flex justify-content-center mb-7">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="{{ $user->avatar_url ?: asset(theme()->getMediaUrlPath().'photos/blank.png') }}" alt="Profile Picture"/>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="mb-10">
                <h3 class="fw-bolder mb-5">{{ __('Personal Information') }}</h3>
                @php
                    $personalInfo = [
                        'Patient ID' => $user->patient->patient_code,
                        'IHS/SATUSEHAT Number' => $user->patient->his_number,
                        'Medical Record' => $user->mr->medical_record_code,
                        'Full Name' => ($info->title_prefix ? $info->title_prefix.'. ' : '').$user->name.($info->title_suffix ? ', '.$info->title_suffix : ''),
                        'Email' => $user->email,
                        'Phone' => $user->phone,
                        'Place and Date of Birth' => $info->place_of_birth.', '.$info->date_of_birth,
                        'Gender' => $info->gender->name ?? '',
                        'Religion' => $info->religion->name ?? '',
                        'Marital Status' => $info->marital->name ?? '',
                        'Education' => $info->education->name ?? '',
                        'Work' => $info->work->name ?? '',
                    ];
                @endphp

                @foreach($personalInfo as $label => $value)
                    <div class="row mb-3">
                        <label class="col-lg-4 fw-bold text-muted">{{ __($label) }}</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-dark">{{ $value }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Health Information -->
            <div class="mb-10">
                <h3 class="fw-bolder mb-5">{{ __('Health Information') }}</h3>
                @php
                    $healthInfo = [
                        'Blood Type' => $info->blood->name ?? '',
                        'Weight' => $info->weight ? $info->weight.' Kg' : '',
                        'Height' => $info->height ? $info->height.' cm' : '',
                    ];
                @endphp

                @foreach($healthInfo as $label => $value)
                    <div class="row mb-3">
                        <label class="col-lg-4 fw-bold text-muted">{{ __($label) }}</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-dark">{{ $value }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Address -->
            <div class="mb-10">
                <h3 class="fw-bolder mb-5">{{ __('Address') }}</h3>
                <div class="row mb-3">
                    <label class="col-lg-4 fw-bold text-muted">{{ __('Full Address') }}</label>
                    <div class="col-lg-8">
                        <span class="fw-bolder fs-6 text-dark">
                            {{ $info->address }}
                            {{ isset($info->subdistrict) ? ', '.$info->subdistrict->name : '' }}
                            {{ isset($info->district) ? ', '.$info->district->name : '' }}
                            {{ isset($info->city) ? ', '.$info->city->name : '' }}
                            {{ isset($info->province) ? ', '.$info->province->name : '' }}
                            {{ isset($info->country) ? ', '.$info->country->name : '' }}
                            {{ $info->postal_code ?: (isset($info->subdistrict) ? ' - '.$info->subdistrict->postal_code : '') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Employment Information -->
            <div class="mb-10">
                <h3 class="fw-bolder mb-5">{{ __('Employment Information') }}</h3>
                @php
                    $employmentInfo = [
                        'Company Name' => $info->company_name ?? '',
                        'Date of Hire' => $info->date_of_hire ?? '',
                        'Job Title' => $info->job_title ?? '',
                        'Division' => $info->division ?? '',
                        'Department' => $info->department ?? '',
                        'Section' => $info->section ?? '',
                        'Employee ID' => $info->employee_id ?? '',
                        'Kind of Job' => $info->kind_of_job ?? '',
                        'Shift' => $info->shift ?? '',
                    ];
                @endphp

                @foreach($employmentInfo as $label => $value)
                    <div class="row mb-3">
                        <label class="col-lg-4 fw-bold text-muted">{{ __($label) }}</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-dark">{{ $value ?: '-' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Other Information -->
            <div>
                <h3 class="fw-bolder mb-5">{{ __('Other Information') }}</h3>
                <div class="row mb-3">
                    <label class="col-lg-4 fw-bold text-muted">{{ __('Patient Trustee Name') }}</label>
                    <div class="col-lg-8">
                        <span class="fw-bolder fs-6 text-dark">{{ $info->patient_trustee_name ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
