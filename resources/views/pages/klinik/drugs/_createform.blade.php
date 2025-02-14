<form id="kt_modal_add_permission_form" method="POST" class="form" action="{{ route('drugs.store') }}">
{{ csrf_field() }}
<!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid">
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Select a Unit</label>
            <!--end::Label-->
            <div class="input-group input-group-solid has-validation mb-3">
                <select name="unit_id" aria-label="{{ __('Select a Unit') }}" data-control="select2" data-placeholder="{{ __('Select a unit...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                    <option value="">{{ __('Select a Unit...') }}</option>
                    @foreach($unit as $key => $value)
                        <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                    @endforeach
                </select>
            </div>
            @error('unit_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Drug Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('name') is-invalid @enderror" placeholder="Drug name" value=""/>
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
            <label class="required fw-bold fs-6 mb-2">Drug Stock</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="number" name="stock" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('stock') is-invalid @enderror" placeholder="Drug stock" value=""/>
            </div>
            @error('stock')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <!--end::Input-->
        </div>
        <!--end::Input group-->        
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Drug Price</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="number" name="price" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('price') is-invalid @enderror" placeholder="Drug price" value=""/>
            </div>
            @error('price')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <!--end::Input-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Scroll-->
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-drugs-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-drugs-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
    <!--end::Actions-->
</form>

