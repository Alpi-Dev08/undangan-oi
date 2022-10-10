<form id="kt_modal_add_anamnesiscategories_form" method="POST" class="form" action="{{ route('anamnesiscategories.update',['anamnesiscategory' => $anamnesiscategory->id]) }}">
@method('PUT')
{{ csrf_field() }}
<!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid">
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Anamnesis Category Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('name') is-invalid @enderror" placeholder="Anamnesis Category name" value="{{ $anamnesiscategory->name ?? '' }}"/>
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
        <button type="reset" class="btn btn-light me-3" data-kt-anamnesiscategories-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-anamnesiscategories-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
    <!--end::Actions-->
</form>
