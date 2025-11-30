<div class="card {{ $class }}" x-data="settingsForm()" x-init="init()">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder text-dark">{{ __('Profile Details') }}</span>
            <span class="text-muted mt-1 fw-bold fs-7">{{ __('Update your personal information') }}</span>
        </h3>
    </div>

    <div class="card-body">
        <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" @submit="handleSubmit">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <div class="row g-9 mb-8">
                <!-- Photo Upload -->
                <div class="col-12 col-md-4">
                    <div class="image-input image-input-outline {{ isset($info) && $info->photo ? '' : 'image-input-empty' }}" data-kt-image-input="true" style="background-image: url({{ asset(theme()->getMediaUrlPath() . 'photos/blank.png') }})">
                        <div class="image-input-wrapper w-150px h-150px" style="background-image: {{ isset($info) && $info->photo ? 'url('.asset('storage/'.$info->photo).')' : 'none' }};"></div>

                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                            <i class="bi bi-pencil-fill fs-7"></i>
                            <input type="file" name="photo" accept=".png, .jpg, .jpeg"/>
                            <input type="hidden" name="avatar_remove"/>
                        </label>

                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                            <i class="bi bi-x fs-2"></i>
                        </span>

                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                    </div>
                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                </div>

                <!-- Basic Info -->
                <div class="col-12 col-md-8">
                    <div class="row g-9">
                        <!-- Title Prefix/Suffix -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Title Prefix') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="{{ __('Prefix (e.g., Dr., Prof.)') }}" name="title_prefix" value="{{ old('title_prefix', $info->title_prefix ?? '') }}"/>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Title Suffix') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="{{ __('Suffix (e.g., Jr., Sr.)') }}" name="title_suffix" value="{{ old('title_suffix', $info->title_suffix ?? '') }}"/>
                        </div>

                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('First Name') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="First name" name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}"/>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Last Name') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Last name" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}"/>
                        </div>

                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Place of Birth') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="{{ __('Place of Birth') }}" name="place_of_birth" value="{{ old('place_of_birth', $info->place_of_birth ?? '') }}"/>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Date of Birth') }}</label>
                            <input type="date" class="form-control form-control-solid" placeholder="Date of Birth" name="date_of_birth" value="{{ old('date_of_birth', $info->date_of_birth ?? '') }}"/>
                        </div>

                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Phone') }}</label>
                            <input type="tel" class="form-control form-control-solid" placeholder="Phone number" name="phone" value="{{ old('phone', $user->phone ?? '') }}"/>
                        </div>

                        <!-- ID Card -->
                        @isset($cards)
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('ID Card Type') }}</label>
                            <select id="card_type_id" name="card_type_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select a Card...') }}">
                                @foreach($cards as $card)
                                    <option value="{{ $card->id }}" {{ $card->id === old('card_type_id', $info->card_type_id ?? '') ? 'selected' : '' }}>{{ $card->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('ID Card Number') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="{{ __('Card Number') }}" name="card_number" id="card_number" value="{{ old('card_number', $info->card_number ?? '') }}"/>
                            <input type="hidden" name="his_number" id="his_number" value="{{ old('his_number', $info->his_number ?? '') }}"/>
                            <div id="error-message" class="text-danger" style="display: none;">{{ __('Card Number is required.') }}</div>
                        </div>
                        @endisset
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="row g-9 mb-8">
                <!-- Left Column -->
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Personal Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="fs-6 fw-bold mb-2">{{ __('Gender') }}</label>
                                <select name="gender_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select Gender') }}">
                                    <option value="">{{ __('Select Gender') }}</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender->id }}" {{ $gender->id === old('gender_id', $info->gender_id ?? '') ? 'selected' : '' }}>{{ $gender->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-5">
                                <label class="fs-6 fw-bold mb-2">{{ __('Marital Status') }}</label>
                                <select name="marital_status_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select Marital Status') }}">
                                    <option value="">{{ __('Select Marital Status') }}</option>
                                    @foreach($maritals as $marital)
                                        <option value="{{ $marital->id }}" {{ $marital->id === old('marital_id', $info->marital_status_id ?? '') ? 'selected' : '' }}>{{ $marital->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-5">
                                <label class="fs-6 fw-bold mb-2">{{ __('Blood Type') }}</label>
                                <select name="blood_type_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select Blood Type') }}">
                                    <option value="">{{ __('Select Blood Type') }}</option>
                                    @foreach($bloods as $blood)
                                        <option value="{{ $blood->id }}" {{ $blood->id === old('blood_type_id', $info->blood_type_id ?? '') ? 'selected' : '' }}>{{ $blood->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Additional Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="fs-6 fw-bold mb-2">{{ __('Education') }}</label>
                                <select name="education_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select Education') }}">
                                    <option value="">{{ __('Select Education') }}</option>
                                    @foreach($educations as $education)
                                        <option value="{{ $education->id }}" {{ $education->id === old('education_id', $info->education_id ?? '') ? 'selected' : '' }}>{{ $education->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-5">
                                <label class="fs-6 fw-bold mb-2">{{ __('Work') }}</label>
                                <select name="work_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select Work') }}">
                                    <option value="">{{ __('Select Work') }}</option>
                                    @foreach($works as $work)
                                        <option value="{{ $work->id }}" {{ $work->id === old('work_id', $info->work_id ?? '') ? 'selected' : '' }}>{{ $work->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-5">
                                <label class="fs-6 fw-bold mb-2">{{ __('Religion') }}</label>
                                <select name="religion_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select Religion') }}">
                                    <option value="">{{ __('Select Religion') }}</option>
                                    @foreach($religions as $religion)
                                        <option value="{{ $religion->id }}" {{ $religion->id === old('religion_id', $info->religion_id ?? '') ? 'selected' : '' }}>{{ $religion->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="card shadow-sm mb-8">
                <div class="card-header">
                    <h3 class="card-title">Address Information</h3>
                </div>
                <div class="card-body">
                    <div class="row g-9">
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Country') }}</label>
                            <select id="country" name="country_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select Country') }}">
                                <option value="">{{ __('Select Country') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ $country->id === old('country_id', $info->country_id ?? '') ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Province') }}</label>
                            <select id="province" name="province_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select Province') }}">
                                <option value="">{{ __('Select Province') }}</option>
                                @if(isset($provinces))
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ $province->id === old('province_id', $info->province_id ?? '') ? 'selected' : '' }}>{{ $province->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('City') }}</label>
                            <select id="city" name="city_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select City') }}">
                                <option value="">{{ __('Select City') }}</option>
                                @if(isset($cities))
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ $city->id === old('city_id', $info->city_id ?? '') ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('District') }}</label>
                            <select id="district" name="district_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select District') }}">
                                <option value="">{{ __('Select District') }}</option>
                                @if(isset($districts))
                                    @foreach($districts as $district)
                                        <option value="{{ is_array($district) ? $district['id'] : $district->id }}" {{ (is_array($district) ? $district['id'] : $district->id) === old('district_id', $info->district_id ?? '') ? 'selected' : '' }}>{{ is_array($district) ? $district['name'] : $district->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Sub District') }}</label>
                            <select id="subdistrict" name="sub_district_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select Sub District') }}">
                                <option value="">{{ __('Select Sub District') }}</option>
                                @if(isset($subdistricts))
                                    @foreach($subdistricts as $village)
                                        <option value="{{ is_array($village) ? $village['id'] : $village->id }}" {{ (is_array($village) ? $village['id'] : $village->id) === old('sub_district_id', $info->sub_district_id ?? '') ? 'selected' : '' }}>{{ is_array($village) ? $village['name'] : $village->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Postal Code') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="{{ __('Postal Code') }}" name="postal_code" value="{{ old('postal_code', $info->postal_code ?? '') }}"/>
                        </div>
                        <div class="col-12 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Address') }}</label>
                            <textarea class="form-control form-control-solid" rows="3" name="address" placeholder="{{ __('Enter your address') }}">{{ old('address', $info->address ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employment Information (mengikuti gaya card yang sama) -->
            <div class="card shadow-sm mb-8">
                <div class="card-header">
                    <h3 class="card-title">Employment Information</h3>
                </div>
                <div class="card-body">
                    <div class="row g-9">
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Company Name') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="{{ __('Company Name') }}" name="company_name" value="{{ old('company_name', $info->company_name ?? '') }}"/>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Job Title') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="{{ __('Job Title') }}" name="job_title" value="{{ old('job_title', $info->job_title ?? '') }}"/>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Department') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="{{ __('Department') }}" name="department" value="{{ old('department', $info->department ?? '') }}"/>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Employee ID') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="{{ __('Employee ID') }}" name="employee_id" value="{{ old('employee_id', $info->employee_id ?? '') }}"/>
                        </div>

                        <!-- Hidden future fields -->
                        <div class="d-none">
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-bold mb-2">{{ __('Date of Hire') }}</label>
                                <input type="date" class="form-control form-control-solid" placeholder="{{ __('Date of Hire') }}" name="date_of_hire" value="{{ old('date_of_hire', $info->date_of_hire ?? '') }}"/>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-bold mb-2">{{ __('Division') }}</label>
                                <input type="text" class="form-control form-control-solid" placeholder="{{ __('Division') }}" name="division" value="{{ old('division', $info->division ?? '') }}"/>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-bold mb-2">{{ __('Section') }}</label>
                                <input type="text" class="form-control form-control-solid" placeholder="{{ __('Section') }}" name="section" value="{{ old('section', $info->section ?? '') }}"/>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-bold mb-2">{{ __('Kind of Job') }}</label>
                                <input type="text" class="form-control form-control-solid" placeholder="{{ __('Kind of Job') }}" name="kind_of_job" value="{{ old('kind_of_job', $info->kind_of_job ?? '') }}"/>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-bold mb-2">{{ __('Shift') }}</label>
                                <input type="text" class="form-control form-control-solid" placeholder="{{ __('Shift') }}" name="shift" value="{{ old('shift', $info->shift ?? '') }}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!--begin::Actions-->
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="reset" class="btn btn-light btn-active-light-primary me-2" @click="resetForm">{{ __('Discard') }}</button>
            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit" :disabled="isSubmitting">
                @include('partials.general._button-indicator', ['label' => __('Save Changes')])
            </button>
        </div>
        <!--end::Actions-->
        </form>
    </div>
</div>

@push('customscript')
    <script type="text/javascript">
        /**
         * settingsForm
         * Komponen Alpine.js untuk mengelola form profile settings.
         * Mencakup: inisialisasi chained dropdown lokasi, validasi NIK, dan logging state submit/reset.
         */
        function settingsForm() {
            return {
                isSubmitting: false,

                /** Inisialisasi komponen */
                init() {
                    console.log('[SettingsForm] init start');
                    this.initializeRemoteChained();
                    this.initializeNikValidation();
                    console.log('[SettingsForm] init done');
                },

                /** Tangani submit form */
                handleSubmit(event) {
                    console.log('[SettingsForm] submit start');
                    this.isSubmitting = true;
                    // Form submit normal, biarkan berjalan
                },

                /** Reset form ke nilai awal */
                resetForm() {
                    console.log('[SettingsForm] reset start');
                    this.isSubmitting = false;
                    document.getElementById('kt_account_profile_details_form').reset();
                    console.log('[SettingsForm] reset done');
                },

                /** Inisialisasi chained dropdown lokasi */
                initializeRemoteChained() {
                    console.log('[SettingsForm] remoteChained init');
                    // Pastikan ID sesuai partials: #country, #province, #city, #district, #subdistrict
                    $("#province").remoteChained({
                        parents : "#country",
                        url : "/masters/province-country"
                    });

                    $("#city").remoteChained({
                        parents : "#province",
                        url : "/masters/city-province"
                    });

                    $("#district").remoteChained({
                        parents : "#city",
                        url : "/masters/district-city"
                    });

                    $("#subdistrict").remoteChained({
                        parents : "#district",
                        url : "/masters/district-sub"
                    });
                    console.log('[SettingsForm] remoteChained ready');
                },

                /** Validasi NIK sederhana via AJAX (opsional, aktif saat field ada) */
                initializeNikValidation() {
                    console.log('[SettingsForm] nikValidation init');
                    const cardNumberInput = $('#card_number');
                    if (!cardNumberInput.length) {
                        console.log('[SettingsForm] nikValidation skipped (no #card_number)');
                        return;
                    }

                    $('#card_number').on('blur', function() {
                        var cardNumber = $(this).val();
                        var cardTypeId = $('#card_type_id').val();

                        if (cardNumber && cardTypeId) {
                            $.ajax({
                                url: '/patients/check-card-number',
                                method: 'POST',
                                data: {
                                    card_number: cardNumber,
                                    card_type_id: cardTypeId,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    console.log('[SettingsForm] nikValidation response', response);
                                    if (response.exists) {
                                        $('#error-message').text('Nomor kartu sudah terdaftar').show();
                                        $('#card_number').addClass('is-invalid');
                                    } else {
                                        $('#error-message').hide();
                                        $('#card_number').removeClass('is-invalid');
                                        if (response.his_number) {
                                            $('#his_number').val(response.his_number);
                                        }
                                    }
                                },
                                error: function() {
                                    console.error('[SettingsForm] nikValidation error');
                                }
                            });
                        }
                    });
                    console.log('[SettingsForm] nikValidation ready');
                }
            }
        }
    </script>
@endpush
