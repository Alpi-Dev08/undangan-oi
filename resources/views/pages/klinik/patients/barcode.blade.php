<x-base-layout>
    <!--begin::Card-->
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <!--begin::Card body-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                Print barcode
            </h3>

            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title=""
                 data-bs-original-title="Click to cancel">
                <a href="{{ route('patients.index')  }}" class="btn btn-sm btn-light-primary">
                    <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-2hx">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor"/>
                            <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    Cancel
                </a>
            </div>
        </div>
        <div class="card-body pt-6">
            <form id="kt_modal_add_permission_form" method="POST" class="form" action="{{ route('patients.barcode') }}">
            {{ csrf_field() }}
            <!--begin::Scroll-->
                <div class="d-flex flex-column flex-row-fluid">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-bold fs-6 mb-2">Jumlah</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group input-group-solid has-validation mb-3">
                            <input type="hidden" name="barcode" value="{{ $patient->patient_code }}">
                            <input type="number" name="jumlah" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 placeholder="Jumlah Barcode" value=""/>
                        </div>
                    <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Scroll-->
                <!--begin::Actions-->
                <div class="text-center pt-15">
                    <button type="reset" class="btn btn-light me-3" data-kt-diseases-modal-action="cancel">Discard</button>
                    <button type="submit" class="btn btn-primary" data-kt-diseases-modal-action="submit">
                        <span class="indicator-label">Print</span>
                        <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</x-base-layout>
