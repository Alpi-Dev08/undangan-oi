<div class="card {{ $class }}">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder text-dark">{{ __('Profile Details') }}</span>
            <span class="text-muted mt-1 fw-bold fs-7">{{ __('Update your personal information') }}</span>
        </h3>
    </div>

    <div class="card-body">
        <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" value="{{$user->id}}">

            <div class="row g-9 mb-8">
                <!-- Photo Upload -->
                <div class="col-12 col-md-4">
                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url({{ asset(theme()->getMediaUrlPath() . 'photos/blank.png') }})">
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
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('First Name') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="First name" name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}"/>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Last Name') }}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Last name" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}"/>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Phone') }}</label>
                            <input type="tel" class="form-control form-control-solid" placeholder="Phone number" name="phone" value="{{ old('phone', $user->phone ?? '') }}"/>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Date of Birth') }}</label>
                            <input type="date" class="form-control form-control-solid" placeholder="Date of Birth" name="date_of_birth" value="{{ old('date_of_birth', $info->date_of_birth ?? '') }}"/>
                        </div>
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
                            <select name="country_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select Country') }}">
                                <option value="">{{ __('Select Country') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ $country->id === old('country', $info->country_id ?? '') ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Province') }}</label>
                            <select id="province" name="province_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select Province') }}">
                                <option value="">{{                                __('Select Province') }}</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ $province->id === old('province_id', $info->province_id ?? '') ? 'selected' : '' }}>{{ $province->name }}</option>
                                @endforeach
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
                                        <option value="{{ $district->id }}" {{ $district->id === old('district_id', $info->district_id ?? '') ? 'selected' : '' }}>{{ $district->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Village') }}</label>
                            <select id="village" name="sub_district_id" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('Select Village') }}">
                                <option value="">{{ __('Select Village') }}</option>
                                @if(isset($subdistricts))
                                    @foreach($subdistricts as $village)
                                        <option value="{{ $village->id }}" {{ $village->id === old('sub_district_id', $info->sub_district_id ?? '') ? 'selected' : '' }}>{{ $village->name }}</option>
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

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2">{{ __('Discard') }}</button>
                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                    @include('partials.general._button-indicator', ['label' => __('Save Changes')])
                </button>
            </div>
            <!--end::Actions-->
        </form>
    </div>
</div>

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

        $("#village").remoteChained({
            parents : "#district",
            url : "/masters/district-sub"
        });

    </script>
@endpush
