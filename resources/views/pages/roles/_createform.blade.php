<form id="kt_modal_add_role_form" method="POST" class="form" action="{{ route('roles.store') }}">
{{ csrf_field() }}
    <!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid" id="kt_modal_add_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header" data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Role Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('name') is-invalid @enderror" placeholder="Role name" value="" />
            </div>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <!--end::Input-->
        </div>
        <!--end::Input group-->
        <div class="fv-row">
            <!--begin::Label-->
            <label class="fs-5 fw-bolder form-label mb-2">Role Permissions</label>
            <!--end::Label-->
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <!--begin::Table body-->
                    <tbody class="text-gray-600 fw-bold">
                    <!--begin::Table row-->
                    <tr>
                        <td class="text-gray-800">Administrator/Superuser Access
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Allows a full access to the system"></i></td>
                        <td>
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                <input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all" />
                                <span class="form-check-label" for="kt_roles_select_all">Select all</span>
                            </label>
                            <!--end::Checkbox-->
                        </td>
                    </tr>
                    <!--end::Table row-->
                    @foreach($permissiongroups as $group)
                    <!--begin::Table row-->
                    <tr>
                        <!--begin::Label-->
                        <td class="text-gray-800">{{ $group->name }}</td>
                        <!--end::Label-->
                        <!--begin::Input group-->
                        <td>
                            <!--begin::Wrapper-->
                            <div class="d-flex">
                                @foreach($group->getpermissionsByGroupId($group->id) as $permission)
                                <!--begin::Checkbox-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                    <input class="form-check-input" type="checkbox" value="{{ $permission->id }}" name="permissions[]" />
                                    @php
                                        $permission_name = explode('.',$permission->name);
                                    @endphp
                                    <span class="form-check-label text-capitalize">{{ $permission_name[1] }}</span>
                                </label>
                                <!--end::Checkbox-->
                                @endforeach
                            </div>
                            <!--end::Wrapper-->
                        </td>
                        <!--end::Input group-->
                    </tr>
                    <!--end::Table row-->
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Permissions-->
    </div>
    <!--end::Scroll-->
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
																		<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Actions-->
</form>

@push('customscript')
<script>
    "use strict";

    // Class definition
    var Roles = function () {
        // Shared variables
        const form = document.getElementById('kt_modal_add_role_form');

        // Select all handler
        const handleSelectAll = () => {
            // Define variables
            const selectAll = form.querySelector('#kt_roles_select_all');
            const allCheckboxes = form.querySelectorAll('[type="checkbox"]');

            // Handle check state
            selectAll.addEventListener('change', e => {

                // Apply check state to all checkboxes
                allCheckboxes.forEach(c => {
                    c.checked = e.target.checked;
                });
            });
        }

        return {
            // Public functions
            init: function () {
                handleSelectAll();
            }
        };
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function () {
        Roles.init();
    });
</script>
@endpush
