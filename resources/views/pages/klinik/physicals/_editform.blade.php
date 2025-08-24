<form id="kt_modal_add_physicals_form" method="POST" class="form" action="{{ route('physicals.update',['physical' => $physical->id]) }}">
@method('PUT')
{{ csrf_field() }}
<!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid">
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Select a Physical Category</label>
            <!--end::Label-->
            <div class="input-group input-group-solid has-validation mb-3">
                <select name="physical_category_id" aria-label="{{ __('Select a Physical Category') }}" data-control="select2" data-placeholder="{{ __('Select a physical category...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                    <option value="">{{ __('Select a Physical Category...') }}</option>
                    @foreach($categoriescategory as $key => $value)
                        <option value="{{ $value['id'] }}" {{ $value['id'] === old('categories', $physical->physical_category_id ?? '') ? 'selected' :'' }}>{{ $value['name'] }}</option>
                    @endforeach
                </select>
            </div>
            @error('physical_category_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Physical Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('name') is-invalid @enderror" placeholder="Physical name" value="{{ $physical->name ?? '' }}"/>
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
                <textarea row="3" name="options" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('options') is-invalid @enderror" placeholder="Physical Options">{{ $physical->options ?? '' }}</textarea>
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
        <button type="reset" class="btn btn-light me-3" data-kt-physicals-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-physicals-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
    <!--end::Actions-->
</form>
