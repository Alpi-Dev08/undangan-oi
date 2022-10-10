<form id="kt_modal_add_anamnesis_form" method="POST" class="form" action="{{ route('anamnesis.update',['anamnesi' => $anamnesis->id]) }}">
@method('PUT')
{{ csrf_field() }}
<!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid">
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Select a Anamnesis Category</label>
            <!--end::Label-->
            <div class="input-group input-group-solid has-validation mb-3">
                <select name="anamnesis_category_id" aria-label="{{ __('Select a Anamnesis Category') }}" data-control="select2" data-placeholder="{{ __('Select a anamnesis category...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                    <option value="">{{ __('Select a Anamnesis Category...') }}</option>
                    @foreach($categories as $key => $value)
                        <option value="{{ $value['id'] }}" {{ $value['id'] === old('categories', $anamnesis->anamnesis_category_id ?? '') ? 'selected' :'' }}>{{ $value['name'] }}</option>
                    @endforeach
                </select>
            </div>
            @error('anamnesis_category_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Anamnesis Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('name') is-invalid @enderror" placeholder="Anamnesis name" value="{{ $anamnesis->name ?? '' }}"/>
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
            <label class="fw-bold fs-6 mb-2">Options</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <textarea row="3" name="options" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('options') is-invalid @enderror" placeholder="Anamnesis Option">{{ $anamnesis->options ?? '' }}</textarea>
            </div>
            @error('options')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <!--end::Input-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Scroll-->
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-anamnesis-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-anamnesis-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
    <!--end::Actions-->
</form>
