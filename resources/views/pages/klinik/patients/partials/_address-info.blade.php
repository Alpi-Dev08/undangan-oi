{{-- Address Information Section --}}
<div class="separator separator-dashed my-6"></div>
<h4 class="fw-bolder text-dark mb-6">{{ __('Address Information') }}</h4>

{{-- Country Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">
        <span>{{ __('Country') }}</span>
    </label>

    <div class="col-lg-8 fv-row">
        <select name="country_id"
                id="country"
                aria-label="{{ __('Select a Country') }}"
                data-control="select2"
                data-placeholder="{{ __('Select a country...') }}"
                class="form-select form-select-solid form-select-lg fw-bold"
                x-model="countryId">
            <option value="">{{ __('Select a Country...') }}</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" {{ isset($info) && $info->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- Province Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">
        <span>{{ __('Province') }}</span>
    </label>

    <div class="col-lg-8 fv-row">
        <select id="province"
                name="province_id"
                aria-label="{{ __('Select a Province') }}"
                data-control="select2"
                data-placeholder="{{ __('Select a province...') }}"
                class="form-select form-select-solid form-select-lg fw-bold"
                x-model="provinceId">
            <option value="">{{ __('Select a Province...') }}</option>
            @if(isset($provinces))
                @foreach($provinces as $province)
                    <option value="{{ $province->id }}" {{ isset($info) && $info->province_id == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

{{-- City Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">
        <span>{{ __('City') }}</span>
    </label>

    <div class="col-lg-8 fv-row">
        <select id="city"
                name="city_id"
                aria-label="{{ __('Select a City') }}"
                data-control="select2"
                data-placeholder="{{ __('Select a city...') }}"
                class="form-select form-select-solid form-select-lg fw-bold"
                x-model="cityId">
            <option value="">{{ __('Select a City...') }}</option>
            @if(isset($cities))
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ isset($info) && $info->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

{{-- District Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">
        <span>{{ __('District') }}</span>
    </label>

    <div class="col-lg-8 fv-row">
        <select id="district"
                name="district_id"
                aria-label="{{ __('Select a District') }}"
                data-control="select2"
                data-placeholder="{{ __('Select a district...') }}"
                class="form-select form-select-solid form-select-lg fw-bold"
                x-model="districtId">
            <option value="">{{ __('Select a District...') }}</option>
            @if(isset($districts))
                @foreach($districts as $key => $value)
                    <option value="{{ $value['id'] }}" {{ isset($info) && $info->district_id == $value['id'] ? 'selected' : '' }}>{{ $value['name'] }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

{{-- Sub District Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">
        <span>{{ __('Sub District') }}</span>
    </label>

    <div class="col-lg-8 fv-row">
        <select id="subdistrict"
                name="sub_district_id"
                aria-label="{{ __('Select a Sub District') }}"
                data-control="select2"
                data-placeholder="{{ __('Select a Sub District...') }}"
                class="form-select form-select-solid form-select-lg fw-bold"
                x-model="subDistrictId">
            <option value="">{{ __('Select a Sub District...') }}</option>
            @if(isset($subdistricts))
                @foreach($subdistricts as $key => $value)
                    <option value="{{ $value['id'] }}" {{ isset($info) && $info->sub_district_id == $value['id'] ? 'selected' : '' }}>{{ $value['name'] }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

{{-- Address Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Address') }}</label>

    <div class="col-lg-8 fv-row">
        <textarea name="address"
                  class="form-control form-control-lg form-control-solid border border-gray-300"
                  placeholder="{{ __('Complete address (street, number, etc.)') }}"
                  rows="3"
                  x-model="address">{{ isset($info) ? $info->address : '' }}</textarea>
        <div class="form-text">{{ __('Complete address including street name and number') }}</div>
    </div>
</div>

{{-- Postal Code Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Postal Code') }}</label>

    <div class="col-lg-8 fv-row">
        <input type="number"
               name="postal_code"
               class="form-control form-control-lg form-control-solid border border-gray-300"
               placeholder="{{ __('Postal Code (e.g., 12345)') }}"
               x-model="postalCode"
               value="{{ isset($info) ? $info->postal_code : '' }}"/>
    </div>
</div>
