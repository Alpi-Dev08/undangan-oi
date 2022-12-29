<form id="kt_modal_add_permission_form" method="POST" class="form" action="{{ route('locations.store') }}">
    {{ csrf_field() }}
    <!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid">
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">
                <span>{{ __('Organization') }}</span>
            </label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="input-group input-group-solid has-validation mb-3">
                <select name="organization_id" aria-label="{{ __('Select a Organization') }}" data-control="select2" data-placeholder="{{ __('Select a Organization...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                    <option value="">{{ __('Select a Organization...') }}</option>
                    @foreach($organizations as $organization)
                        <option value="{{ $organization->id }}" {{  $organization->id === old('organization_id', $location->organization_id ?? '') ? 'selected' :'' }}>{{  $organization->name }}</option>
                    @endforeach
                </select>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Location Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('name') is-invalid @enderror" placeholder="Location name" value=""/>
            </div>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Code Location</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="code" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('code') is-invalid @enderror" placeholder="Location code" value=""/>
            </div>
            @error('code')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Email</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="email" name="email" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('email') is-invalid @enderror" placeholder="Email" value=""/>
            </div>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Phone</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="phone" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('phone') is-invalid @enderror" placeholder="Phone" value=""/>
            </div>
            @error('phone')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">Fax</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="fax" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('fax') is-invalid @enderror" placeholder="Phone" value=""/>
            </div>
            @error('fax')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">
                <span>{{ __('Country') }}</span>

            </label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="input-group input-group-solid has-validation mb-3">
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
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">
                <span>{{ __('Province') }}</span>
            </label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="input-group input-group-solid has-validation mb-3">
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
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">
                <span>{{ __('City') }}</span>
            </label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="input-group input-group-solid has-validation mb-3">
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
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">
                <span>{{ __('District') }}</span>
            </label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="input-group input-group-solid has-validation mb-3">
                <select id="district" name="district_id" aria-label="{{ __('Select a District') }}" data-control="select2" data-placeholder="{{ __('Select a district...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                    <option value="">{{ __('Select a District...') }}</option>
                    @if(isset($districts))
                        @foreach($districts as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">
                <span>{{ __('Sub District') }}</span>
            </label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="input-group input-group-solid has-validation mb-3">
                <select id="subdistrict" name="sub_district_id" aria-label="{{ __('Select a Sub District') }}" data-control="select2" data-placeholder="{{ __('Select a Sub District...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                    <option value="">{{ __('Select a Sub District...') }}</option>
                    @if(isset($subdistricts))
                        @foreach($subdistricts as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->


        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">Address</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="address" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('address') is-invalid @enderror" placeholder="Address" value=""/>
            </div>
            @error('address')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Popstal Code</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="postal_code" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('postal_code') is-invalid @enderror" placeholder="Popstal Code" value=""/>
            </div>
            @error('postal_code')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Description</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <textarea name="description" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('description') is-invalid @enderror" placeholder="Description"></textarea>
            </div>
            @error('description')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Switch-->
            <label class="form-check form-switch form-check-custom form-check-solid">
                <input class="form-check-input" name="status" type="checkbox" value="1" checked="checked"/>
                <span class="form-check-label fw-semibold text-muted">
                   Aktif
                </span>
            </label>
            <!--end::Switch-->

            @error('postal_code')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Scroll-->
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-locations-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-locations-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
    <!--end::Actions-->
</form>

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


