<form id="kt_modal_add_districts_form" method="POST" class="form" action="{{ route('districts.update',['district' => $district->id]) }}">
@method('PUT')
{{ csrf_field() }}
<!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid">
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Select a Country</label>
            <!--end::Label-->
            <div class="input-group input-group-solid has-validation mb-3">
                <select name="country_id" aria-label="{{ __('Select a Country') }}" data-control="select2" data-placeholder="{{ __('Select a country...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                    <option value="">{{ __('Select a Country...') }}</option>
                    @foreach($country as $key => $value)
                        <option value="{{ $value['id'] }}" {{ $value['id'] === old('country', $district->country_id ?? '') ? 'selected' :'' }}>{{ $value['name'] }}</option>
                    @endforeach
                </select>
            </div>
            @error('country_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Select a Province</label>
            <!--end::Label-->
            <div class="input-group input-group-solid has-validation mb-3">
                <select id="province" name="province_id" aria-label="{{ __('Select a Province') }}" data-control="select2" data-placeholder="{{ __('Select a province...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                    <option value="">{{ __('Select a Province...') }}</option>
                    @if(isset($province))
                        @foreach($province as $key => $value)
                            <option value="{{ $value['id'] }}" {{ $value['id'] === old('province', $district->province_id ?? '') ? 'selected' :'' }}>{{ $value['name'] }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            @error('province_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <!--end::Input group-->


        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Select a City</label>
            <!--end::Label-->
            <div class="input-group input-group-solid has-validation mb-3">
                <select id="city" name="city_id" aria-label="{{ __('Select a City') }}" data-control="select2" data-placeholder="{{ __('Select a city...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                    <option value="">{{ __('Select a City...') }}</option>
                    @if(isset($city))
                        @foreach($city as $key => $value)
                            <option value="{{ $value['id'] }}" {{ $value['id'] === old('city', $district->city_id ?? '') ? 'selected' :'' }}>{{ $value['name'] }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            @error('city_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Area Code</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="area_code" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('area_code') is-invalid @enderror" placeholder="District Name" value="{{ $district->area_code ?? '' }}"/>
            </div>
            @error('area_code')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">District Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('name') is-invalid @enderror" placeholder="District name" value="{{ $district->name ?? '' }}"/>
            </div>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <!--end::Input-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Scroll-->
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-districts-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-districts-modal-action="submit">
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

    </script>
@endpush
