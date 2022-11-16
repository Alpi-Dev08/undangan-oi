 <!--begin::Content-->
    <div id="kt_account_profile_details" class="collapse show">
        <!--begin::Form-->
        <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('patients.update',['user' => $user->id, 'patient' => $user->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!--begin::Card body-->
            <div class="card-body border-top p-9">

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('ID Card') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-4 fv-row">
                                <select name="card_type_id" aria-label="{{ __('Select a Card Type') }}" data-control="select2" data-placeholder="{{ __('Select a Card...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Card Type...') }}</option>
                                    @foreach($cards as $card)
                                        <option value="{{ $card->id }}" {{  $card->id === old('card_type_id', $info->card_type_id ?? '') ? 'selected' :'' }}>{{  $card->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="card_number" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Card Number" value="{{ old('card_number', $info->card_number ?? '') }}"/>
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
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Title') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="text" name="title_prefix" class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Prefix" value="{{ old('title_prefix', $info->title_prefix ?? '') }}"/>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="text" name="title_suffix" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Suffix" value="{{ old('title_suffix', $info->title_suffix ?? '') }}"/>
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
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Full Name') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="text" name="first_name" class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="First name" value="{{ old('first_name', $user->first_name ?? '') }}"/>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="text" name="last_name" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Last name" value="{{ old('last_name', $user->last_name ?? '') }}"/>
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
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span>{{ __('Email') }}</span>
                    </label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="email" name="email" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Email" value="{{ old('email', $user->email ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span>{{ __('Contact Phone') }}</span>
                    </label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="tel" name="phone" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Phone number" value="{{ old('phone', $user->phone ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Place and Date of Birth') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="text" name="place_of_birth" class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Place of Birth" value="{{ old('place_of_birth', $info->place_of_birth ?? '') }}"/>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="date" name="date_of_birth" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Date of Birth" value="{{ old('date_of_birth', $info->date_of_birth ?? '') }}"/>
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
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Religion') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <select name="religion_id" aria-label="{{ __('Religion') }}" data-control="select2" data-placeholder="{{ __('Select a Religion...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Religion...') }}</option>
                            @foreach($religions as $religion)
                                <option value="{{ $religion->id }}" {{  $religion->id === old('religion_id', $info->religion_id ?? '') ? 'selected' :'' }}>{{  $religion->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Gender') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-2">
                        <select name="gender_id" aria-label="{{ __('Gender') }}" data-control="select2" data-placeholder="{{ __('Select a Gender...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Gender...') }}</option>
                            @foreach($genders as $gender)
                                <option value="{{ $gender->id }}" {{  $gender->id === old('gender_id', $info->gender_id ?? '') ? 'selected' :'' }}>{{  $gender->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!--begin::Label-->
                    <label class="col-lg-1 col-form-label fw-bold fs-6">{{ __('Marital Status') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-2">
                        <select name="marital_status_id" aria-label="{{ __('Marital Status') }}" data-control="select2" data-placeholder="{{ __('Select a Marital Status...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Marital Status...') }}</option>
                            @foreach($maritals as $marital)
                                <option value="{{ $marital->id }}" {{  $marital->id === old('marital_id', $info->marital_status_id ?? '') ? 'selected' :'' }}>{{  $marital->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!--begin::Label-->
                    <label class="col-lg-1 col-form-label fw-bold fs-6">{{ __('Blood Type') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-2">
                        <select name="blood_type_id" aria-label="{{ __('Blood Type') }}" data-control="select2" data-placeholder="{{ __('Select a Blood Type...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Blood Type...') }}</option>
                            @foreach($bloods as $blood)
                                <option value="{{ $blood->id }}" {{  $blood->id === old('blood_type_id', $info->blood_type_id ?? '') ? 'selected' :'' }}>{{  $blood->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Education') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-3">
                        <select name="education_id" aria-label="{{ __('Education') }}" data-control="select2" data-placeholder="{{ __('Select a Education...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Education...') }}</option>
                            @foreach($educations as $education)
                                <option value="{{ $education->id }}" {{  $education->id === old('education_id', $info->education_id ?? '') ? 'selected' :'' }}>{{  $education->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!--begin::Label-->
                    <label class="col-lg-1 col-form-label fw-bold fs-6">{{ __('Work') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <select name="work_id" aria-label="{{ __('Work') }}" data-control="select2" data-placeholder="{{ __('Select a Work...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Work...') }}</option>
                            @foreach($works as $work)
                                <option value="{{ $work->id }}" {{  $work->id === old('work_id', $info->work_id ?? '') ? 'selected' :'' }}>{{  $work->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span>{{ __('Country') }}</span>

                    </label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select name="country_id" aria-label="{{ __('Select a Country') }}" data-control="select2" data-placeholder="{{ __('Select a country...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Country...') }}</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{  $country->id === old('country', $info->country_id ?? '') ? 'selected' :'' }}>{{  $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span>{{ __('Province') }}</span>
                    </label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select id="province" name="province_id" aria-label="{{ __('Select a Province') }}" data-control="select2" data-placeholder="{{ __('Select a province...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Province...') }}</option>
                            @if(isset($provinces))
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ $province->id === old('province_id', $info->province_id ?? '') ? 'selected' :'' }}>{{ $province->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span>{{ __('City') }}</span>
                    </label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select id="city" name="city_id" aria-label="{{ __('Select a City') }}" data-control="select2" data-placeholder="{{ __('Select a city...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a City...') }}</option>
                            @if(isset($cities))
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ $city->id === old('city_id', $info->city_id ?? '') ? 'selected' :'' }}>{{ $city->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span>{{ __('District') }}</span>
                    </label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select id="district" name="district_id" aria-label="{{ __('Select a District') }}" data-control="select2" data-placeholder="{{ __('Select a district...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a District...') }}</option>
                            @if(isset($districts))
                                @foreach($districts as $key => $value)
                                    <option value="{{ $value['id'] }}" {{ $value['id'] === old('district_id', $info->district_id ?? '') ? 'selected' :'' }}>{{ $value['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span>{{ __('Sub District') }}</span>
                    </label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select id="subdistrict" name="sub_district_id" aria-label="{{ __('Select a Sub District') }}" data-control="select2" data-placeholder="{{ __('Select a Sub District...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Sub District...') }}</option>
                            @if(isset($subdistricts))
                                @foreach($subdistricts as $key => $value)
                                    <option value="{{ $value['id'] }}" {{ $value['id'] === old('sub_district_id', $info->sub_district_id ?? '') ? 'selected' :'' }}>{{ $value['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->


                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Address') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="address" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Address" value="{{ old('address', $info->address ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Postal Code') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="number" name="postal_code" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Postal Code" value="{{ old('postal_code', $info->postal_code ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Nama Wali  Pasien (Hubungan dengan Pasien)') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="patient_trusetee_name" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Nama Wali  Pasien (Hubungan dengan Pasien)" value="{{ old('patient_trustee_name', $info->patient_trustee_name ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Company Name') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="company_name" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Company Name" value="{{ old('company_name', $info->company_name ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6 d-none">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Date of Hire') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="date" name="date_of_hire" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Date of Hire" value="{{ old('date_of_hire', $info->date_of_hire ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Job Title') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="job_title" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Job Title" value="{{ old('job_title', $info->job_title ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6 d-none">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Division') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="division" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Division" value="{{ old('division', $info->division ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Department') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="department" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Department" value="{{ old('department', $info->department ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6 d-none">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Section') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="section" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Section" value="{{ old('section', $info->section ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Employee ID') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="employee_id" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Employee ID" value="{{ old('employee_id', $info->employee_id ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6 d-none">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Kind of Job') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="kind_of_job" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Kind of Job" value="{{ old('kind_of_job', $info->kind_of_job ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6 d-none">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Shift') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="shift" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Shift" value="{{ old('shift', $info->shift ?? '') }}"/>
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

@push('customscript')
    <script type="text/javascript">
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

    </script>
@endpush
