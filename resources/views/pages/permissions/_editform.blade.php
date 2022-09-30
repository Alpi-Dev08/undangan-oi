<form id="kt_modal_add_permissions_form" method="POST" class="form" action="{{ route('permissions.update',['permission' => $permission->id]) }}">
@method('PUT')
{{ csrf_field() }}
<!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid" id="kt_modal_add_permissions_scroll" data-kt-scroll="true"
         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
         data-kt-scroll-dependencies="#kt_modal_add_permissions_header" data-kt-scroll-wrappers="#kt_modal_add_permissions_scroll"
         data-kt-scroll-offset="300px">
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Permission Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="name"
                       class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('name') is-invalid @enderror"
                       placeholder="Permission name" value="{{ $permission->name ?? '' }}"/>
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
        <button type="reset" class="btn btn-light me-3" data-kt-permissions-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-permissions-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
																		<span
                                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Actions-->
</form>
