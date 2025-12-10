<!--begin::Card body + form-->
<form method="POST" action="{{ route('skriningexaminations.store') }}" class="card-body pt-6" id="kt_modal_add_permission_form">
    {{ csrf_field() }}

    <div class="row mb-6">
        <label class="col-lg-4 required col-form-label fw-bold fs-6">{{ __('ID Card') }}</label>
        <div class="col-lg-8">
            <div class="row"> 
                {{-- Card Type --}}
                <div class="col-lg-4 fv-row">
                    <select id="card_type"
                            name="card_type"
                            aria-label="{{ __('Select a Card Type') }}"
                            data-control="select2"
                            data-placeholder="{{ __('Select a Card...') }}"
                            class="form-select form-select-solid form-select-lg fw-bold"
                            x-model="cardType"
                            required>
                        <option value="" disabled {{ old('card_type', isset($info) ? $info->card_type : '') == '' ? 'selected' : '' }}>
                            {{ __('Select a Card...') }}
                        </option>
                        <option value="ktp" {{ old('card_type', isset($info) ? $info->card_type : '') == 'ktp' ? 'selected' : '' }}>KTP</option>
                        <option value="bpjs" {{ old('card_type', isset($info) ? $info->card_type : '') == 'bpjs' ? 'selected' : '' }}>BPJS</option>
                    </select>
                </div>

                {{-- Card Number --}}
                <div class="col-lg-8 fv-row">
                    <input type="text"
                        name="nik_bpjs"
                        id="nik_bpjs"
                        class="form-control form-control-lg form-control-solid border border-gray-300"
                        placeholder="{{ __('Card Number') }}"
                        x-model="cardNumber"
                        value="{{ old('nik_bpjs', isset($info) ? $info->nik_bpjs : '') }}" />
                    <div id="error-message" class="text-danger" style="display: none;">
                        {{ __('Card Number is required.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="separator separator-dashed my-6"></div>

    <h4 class="fw-bolder text-dark mb-6">{{ __('Personal Information') }}</h4>

    {{-- Full Name Section --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Full Name') }}</label>

        <div class="col-lg-8">
            <div class="row">
                {{-- First Name --}}
                <div class="col-lg-6 fv-row">
                    <input type="text" name="first_name" required
                        class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('first_name') is-invalid @enderror"
                        placeholder="{{ __('First name') }}" x-model="firstName"
                        value="{{ old('first_name', isset($user) ? $user->first_name : '') }}" />
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Last Name --}}
                <div class="col-lg-6 fv-row">
                    <input type="text" name="last_name"
                        class="form-control form-control-lg form-control-solid border border-gray-300 @error('last_name') is-invalid @enderror"
                        placeholder="{{ __('Last name') }}" x-model="lastName"
                        value="{{ old('last_name', isset($user) ? $user->last_name : '') }}" />
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Place and Date of Birth Section --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6 required">{{ __('Date of Birth') }}</label>

        <div class="col-lg-8">
            <div class="row">
                <!-- {{-- Place of Birth --}}
                <div class="col-lg-6 fv-row">
                    <input type="text" required name="place_of_birth"
                        class="form-control form-control-lg form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('place_of_birth') is-invalid @enderror"
                        placeholder="{{ __('Place of Birth') }}" x-model="placeOfBirth"
                        value="{{ old('place_of_birth', isset($info) ? $info->place_of_birth : '') }}" />
                    @error('place_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> -->

                {{-- Date of Birth --}}
                <div class="col-lg-12 fv-row">
                    <input type="date" required name="date_of_birth"
                        class="form-control form-control-lg form-control-solid border border-gray-300 @error('date_of_birth') is-invalid @enderror"
                        placeholder="{{ __('Date of Birth') }}" x-model="dateOfBirth"
                        value="{{ old('date_of_birth', isset($info) ? $info->date_of_birth : '') }}" />
                    @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
 
    {{-- Gender Selection --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6 required">{{ __('Gender') }}</label>

        <div class="col-lg-8 fv-row">
            <select name="gender_id" required
                class="form-select form-select-lg form-select-solid border border-gray-300 @error('gender_id') is-invalid @enderror">
                <option value="">{{ __('Select Gender') }}</option>
                @foreach ($genders as $gender)
                    <option value="{{ $gender->id }}"
                        {{ old('gender_id', isset($info) ? $info->gender_id : '') == $gender->id ? 'selected' : '' }}>
                        {{ $gender->name }}
                    </option>
                @endforeach
            </select>

            @error('gender_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Contact Phone Section --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">
            <span class="required">{{ __('Contact Phone') }}</span>
        </label>

        <div class="col-lg-8 fv-row">
            <input type="tel" name="phone" required
                class="form-control form-control-lg form-control-solid border border-gray-300 @error('phone') is-invalid @enderror"
                placeholder="{{ __('Phone number (e.g., +62812345678)') }}" x-model="phone"
                value="{{ old('phone', isset($user) ? $user->phone : '') }}" />
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">{{ __('Primary contact number for patient') }}</div>
        </div>
    </div>

    {{-- Address Section --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Address') }}</label>

        <div class="col-lg-8 fv-row">
            <textarea name="address"
                    class="form-control form-control-lg form-control-solid border border-gray-300 @error('address') is-invalid @enderror"
                    placeholder="{{ __('Complete address (street, number, etc.)') }}"
                    rows="3"
                    x-model="address">{{ old('address', isset($info) ? $info->address : '') }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">{{ __('Complete address including street name and number') }}</div>
        </div>
    </div>

    {{-- Pemeriksaan Skrining --}}
    <div class="separator separator-dashed my-6"></div>
    <h4 class="fw-bolder text-dark mb-6">{{ __('Skrining Examination Location') }}</h4>

    {{-- Tanggal Pemeriksaan --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6 required">{{ __('Examination Date') }}</label>

        <div class="col-lg-8">
            <div class="row"> 
                <div class="col-lg-12 fv-row">
                    <input type="date" required name="examination_date"
                        class="form-control form-control-lg form-control-solid border border-gray-300 @error('examination_date') is-invalid @enderror"
                        placeholder="{{ __('Tanggal Pemeriksaan') }}" x-model="examinationDate"
                        value="{{ old('examination_date', isset($info) ? $info->examination_date : '') }}" />
                    @error('examination_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
<!-- 
    {{-- Lokasi Pemeriksaan Section --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6 required">{{ __('Examination Location') }}</label>

        <div class="col-lg-8 fv-row">
            <textarea name="examination_address"
                    class="form-control form-control-lg form-control-solid border border-gray-300 @error('examination_address') is-invalid @enderror"
                    placeholder="{{ __('Complete address (street, number, etc.)') }}"
                    rows="3"
                    x-model="examinationAddress"
                    required>{{ old('examination_address', isset($info) ? $info->examination_address : '') }}</textarea>
            @error('examination_address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">{{ __('Complete address including street name and number') }}</div>
        </div>
    </div> -->
    
    {{-- Lokasi Pemeriksaan Section --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6 required">{{ __('Examination Location') }}</label>

        <div class="col-lg-8 fv-row">
            <select name="location_id" required
                class="form-select form-select-lg form-select-solid border border-gray-300 @error('location_id') is-invalid @enderror">
                <option value="">{{ __('Select Examination Location') }}</option>
                @foreach ($locations as $location)
                    <option value="{{ $location->id }}"
                        {{ old('location_id', isset($info) ? $info->location_id : '') == $location->id ? 'selected' : '' }}>
                        {{ $location->name }}
                    </option>
                @endforeach
            </select>

            @error('location_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-religions-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-religions-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
</form>
<!--end::Card body + form-->