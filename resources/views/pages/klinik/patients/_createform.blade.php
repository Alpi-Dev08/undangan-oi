<!--begin::Content-->
<div id="kt_account_profile_details" class="collapse show">
    <!--begin::Form-->
    <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('patients.store') }}" enctype="multipart/form-data">
    @csrf
    <!--begin::Card body-->
        <div class="card-body border-top p-9">
            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Photo') }}</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8">
                    <!--begin::Image input-->
                    <div class="image-input image-input-outline {{ isset($info) && $info->photo ? '' : 'image-input-empty' }}" data-kt-image-input="true" style="background-image: url({{ asset(theme()->getMediaUrlPath() . 'photos/blank.png') }})">
                        <!--begin::Preview existing avatar-->
                        <div class="image-input-wrapper w-125px h-125px" style="background-image: {{ isset($info) && $info->photo ? 'url('.asset('storage/'.$info->photo).')' : 'none' }};"></div>
                        <!--end::Preview existing avatar-->

                        <!--begin::Label-->
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                            <i class="bi bi-pencil-fill fs-7"></i>

                            <!--begin::Inputs-->
                            <input type="file" name="photo" accept=".png, .jpg, .jpeg"/>
                            <input type="hidden" name="avatar_remove"/>
                            <!--end::Inputs-->
                        </label>
                        <!--end::Label-->

                        <!--begin::Cancel-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                        <!--end::Cancel-->

                        <!--begin::Remove-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                        <!--end::Remove-->
                    </div>
                    <!--end::Image input-->

                    <!--begin::Hint-->
                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                    <!--end::Hint-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 required col-form-label fw-bold fs-6">{{ __('ID Card') }}</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8">
                    <!--begin::Row-->
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-lg-4 fv-row">
                            <select id="card_type_id" name="card_type_id" aria-label="{{ __('Select a Card Type') }}" data-control="select2" data-placeholder="{{ __('Select a Card...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                @foreach($cards as $card)
                                    <option value="{{ $card->id }}">{{  $card->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" required name="card_number" id="card_number" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Card Number" value=""/>
                            <input type="hidden" name="his_number" id="his_number" value=""/>
                            <div id="error-message" class="text-danger" style="display: none;">Card Number is required.</div>
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
                            <input type="text" name="first_name" required class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="First name" value=""/>
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
                    <span>{{ __('Email') }}</span>
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
                    <input type="tel" name="phone" required class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Phone number" value=""/>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label fw-bold fs-6 required">{{ __('Place and Date of Birth') }}</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8">
                    <!--begin::Row-->
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-lg-6 fv-row">
                            <input type="text" required name="place_of_birth" class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Place of Birth" value=""/>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-lg-6 fv-row">
                            <input type="date" required name="date_of_birth" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Date of Birth" value=""/>
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
                            <option value="{{ $religion->id }}">{{  $religion->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 required col-form-label fw-bold fs-6">{{ __('Gender') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-2">
                    <select name="gender_id" required aria-label="{{ __('Gender') }}" data-control="select2" data-placeholder="{{ __('Select a Gender...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                        <option value="">{{ __('Select a Gender...') }}</option>
                        @foreach($genders as $gender)
                            <option value="{{ $gender->id }}">{{  $gender->name }}</option>
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
                            <option value="{{ $marital->id }}">{{  $marital->name }}</option>
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
                            <option value="{{ $blood->id }}">{{  $blood->name }}</option>
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
                            <option value="{{ $education->id }}">{{  $education->name }}</option>
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

            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Nama Wali  Pasien (Hubungan dengan Pasien)') }}</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <input type="text" name="patient_trusetee_name" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Nama Wali  Pasien (Hubungan dengan Pasien)" value=""/>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Company Name)') }}</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <input type="text" name="company_name" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Company Name" value=""/>
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
                    <input type="date" name="date_of_hire" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Date of Hire" value=""/>
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
                    <input type="text" name="job_title" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Job Title" value=""/>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row mb-6 d-none">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Division)') }}</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <input type="text" name="division" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Division" value=""/>
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
                    <input type="text" name="department" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Department" value=""/>
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
                    <input type="text" name="section" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Section" value=""/>
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
                    <input type="text" name="employee_id" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Employee ID" value=""/>
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
                    <input type="text" name="kind_of_job" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Kind of Job" value=""/>
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
                    <input type="text" name="shift" class="form-control form-control-lg form-control-solid border border-gray-300" placeholder="Shift" value=""/>
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

        $(() => {
            $("#card_number").on("input", function(){
                var card_number = $(this).val();
                var card_type = $("#card_type_id").val();
                if(card_type == 1){
                    if(card_number.length == 16){
                        $.ajax({
                            url: "/klinik/patients/check-nik",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                card_number: card_number
                            },
                            success: function(response){
                                if(response.status == "success"){
                                    $("#card_number").removeClass("is-invalid");
                                    $("#card_number").addClass("is-valid");
                                    $("#his_number").val(response.data);
                                }else{
                                    swal.fire({
                                        title: "IHS Number Tidak Ditemukan",
                                        text: "IHS Number tidak ditemukan, Apakah Akan Tetap Melanjutkan Registrasi?",
                                        icon: "warning",
                                        showCancelButton: true,
                                    }).then((result) => {
                                        if(result.isConfirmed){
                                            console.log("Continue");
                                            $("#card_number").removeClass("is-invalid");
                                            $("#card_number").addClass("is-valid");
                                        }else{
                                            window.location.href = "{{ route('patients.index') }}";
                                        }
                                    })
                                }
                            }
                        });
                    }
                }
            });
        })

    </script>
@endpush


