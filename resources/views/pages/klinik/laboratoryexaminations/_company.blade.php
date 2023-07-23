<form id="kt_modal_add_permission_form" method="POST" class="form" action="{{ route('transactions.company') }}">
    {{ csrf_field() }}
    <!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid">

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Company</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="hidden" name="id" value="{{ $transaction->id }}">
                <select id="company" name="company_id" aria-label="{{ __('Select a Company') }}" data-control="select2" data-placeholder="{{ __('Select a Company...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                    <option value="">{{ __('Select a Company...') }}</option>
                    @foreach($companies as $key => $value)
                        <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                    @endforeach
                </select>
            </div>
            @error('company_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Department</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="department" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('department') is-invalid @enderror" placeholder="Department Name" value=""/>
            </div>
            @error('department')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Job Title</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="job_title" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('job_title') is-invalid @enderror" placeholder="Job Title" value=""/>
            </div>
            @error('job_title')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Company Phone Number</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="phone" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('phone') is-invalid @enderror" placeholder="Company Phone Number" value=""/>
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
            <label class="required fw-bold fs-6 mb-2">Company Address</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="address" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('address') is-invalid @enderror" placeholder="Company Address" value=""/>
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
            <label class="required fw-bold fs-6 mb-2">HRD</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="hrd" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('hrd') is-invalid @enderror" placeholder="HRD" value=""/>
            </div>
            @error('hrd')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Scroll-->
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-diseases-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-diseases-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
    <!--end::Actions-->
</form>

