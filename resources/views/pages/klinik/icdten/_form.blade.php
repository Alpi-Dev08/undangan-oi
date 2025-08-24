@if(isset($icdten))
    <form id="kt_modal_add_icdten_form" method="POST" class="form" action="{{ route('icdten.update',['icdten' => $icdten->id]) }}">
        @method('PUT')
        @else
            <form id="kt_modal_add_icdtren_form" method="POST" class="form" action="{{ route('icdten.store') }}">
                @endif
                {{ csrf_field() }}
                <!--begin::Scroll-->
                <div class="d-flex flex-column flex-row-fluid">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-bold fs-6 mb-2">Code</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group input-group-solid has-validation mb-3">
                            <input type="text" name="code" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('code') is-invalid @enderror" placeholder="code" value=" {{ $icdten->code ?? "" }}"/>
                        </div>
                        @error('code')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-bold fs-6 mb-2">Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group input-group-solid has-validation mb-3">
                            <input type="text" name="name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('name') is-invalid @enderror" placeholder="name" value=" {{ $icdten->name ?? "" }}"/>
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
                    <button type="reset" class="btn btn-light me-3" data-kt-bloodtypes-modal-action="cancel">Discard</button>
                    <button type="submit" class="btn btn-primary" data-kt-bloodtypes-modal-action="submit">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>

