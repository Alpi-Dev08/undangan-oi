<!--begin::Content-->
<div id="kt_account_profile_details" class="collapse show">
    <!--begin::Form-->
    <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('healthprofesionals.store') }}" enctype="multipart/form-data">
    @csrf
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
                                    <option value="{{ $card->id }}">{{  $card->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="card_number" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Card Number" value=""/>
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
                            <input type="text" name="title_prefix" class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Prefix" value=""/>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-lg-6 fv-row">
                            <input type="text" name="title_suffix" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Suffix" value=""/>
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
                            <input type="text" name="first_name" class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="First name" value=""/>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-lg-6 fv-row">
                            <input type="text" name="last_name" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Last name" value=""/>
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
                    <span class="required">{{ __('Email') }}</span>
                </label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <input type="email" name="email" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Email" value=""/>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label fw-bold fs-6">
                    <span class="required">{{ __('Contact Phone') }}</span>
                </label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <input type="tel" name="phone" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Phone number" value=""/>
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
                            <input type="text" name="place_of_birth" class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Place of Birth" value=""/>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-lg-6 fv-row">
                            <input type="date" name="date_of_birth" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Date of Birth" value=""/>
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
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Religion') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8">
                    <select name="religion_id" aria-label="{{ __('Religion') }}" data-control="select2" data-placeholder="{{ __('Select a Religion...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                        <option value="">{{ __('Select a Religion...') }}</option>
                        @foreach($religions as $religion)
                            <option value="{{ $religion->id }}">{{  $religion->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Gender') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-3">
                    <select name="gender_id" aria-label="{{ __('Gender') }}" data-control="select2" data-placeholder="{{ __('Select a Gender...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                        <option value="">{{ __('Select a Gender...') }}</option>
                        @foreach($genders as $gender)
                            <option value="{{ $gender->id }}">{{  $gender->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!--begin::Label-->
                <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ __('Marital Status') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-3">
                    <select name="marital_status_id" aria-label="{{ __('Marital Status') }}" data-control="select2" data-placeholder="{{ __('Select a Marital Status...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                        <option value="">{{ __('Select a Marital Status...') }}</option>
                        @foreach($maritals as $marital)
                            <option value="{{ $marital->id }}">{{  $marital->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Blood Type') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-2">
                    <select name="blood_type_id" aria-label="{{ __('Blood Type') }}" data-control="select2" data-placeholder="{{ __('Select a Blood Type...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                        <option value="">{{ __('Select a Blood Type...') }}</option>
                        @foreach($bloods as $blood)
                            <option value="{{ $blood->id }}">{{  $blood->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!--begin::Label-->
                <label class="col-lg-1 col-form-label required fw-bold fs-6">{{ __('Weight') }}</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-2">
                    <!--begin::Row-->
                    <input type="text" name="weight" class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Weight" value="{{ old('weight', $info->weight ?? '') }}"/>
                    <!--end::Row-->
                </div>
                <!--end::Col-->
                <!--begin::Label-->
                <label class="col-lg-1 col-form-label required fw-bold fs-6">{{ __('Height') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-2">
                    <input type="text" name="height" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Height" value="{{ old('height', $info->height ?? '') }}"/>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Education') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-3">
                    <select name="education_id" aria-label="{{ __('Education') }}" data-control="select2" data-placeholder="{{ __('Select a Education...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                        <option value="">{{ __('Select a Education...') }}</option>
                        @foreach($educations as $education)
                            <option value="{{ $education->id }}">{{  $education->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!--begin::Label-->
                <label class="col-lg-1 col-form-label required fw-bold fs-6">{{ __('Work') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-4">
                    <select name="work_id" aria-label="{{ __('Work') }}" data-control="select2" data-placeholder="{{ __('Select a Work...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                        <option value="">{{ __('Select a Work...') }}</option>
                        @foreach($works as $work)
                            <option value="{{ $work->id }}">{{  $work->name }}</option>
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
                            <option value="{{ $country->id }}">{{  $country->name }}</option>
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
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
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
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
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
                                <option value="{{ $value['id'] }}" >{{ $value['name'] }}</option>
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
                                <option value="{{ $value['id'] }}" >{{ $value['name'] }}</option>
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
                    <input type="text" name="address" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Address" value=""/>
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
                    <input type="number" name="postal_code" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Postal Code" value=""/>
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


