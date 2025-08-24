<form id="kt_modal_add_personal_disease_history_form" method="POST" class="form" action="{{ route('personal-disease-histories.store') }}">
    {{ csrf_field() }}
    <!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid">
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Kode</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="code" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('code') is-invalid @enderror" placeholder="Kode penyakit" value="{{ old('code') }}"/>
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
            <label class="required fw-bold fs-6 mb-2">Nama Penyakit</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('name') is-invalid @enderror" placeholder="Nama penyakit" value="{{ old('name') }}"/>
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
            <label class="required fw-bold fs-6 mb-2">Sistem Kode</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="code_system" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('code_system') is-invalid @enderror" placeholder="Sistem kode" value="{{ old('code_system') }}"/>
            </div>
            @error('code_system')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">Set Nilai</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <textarea name="value_set" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('value_set') is-invalid @enderror" placeholder="Set nilai">{{ old('value_set') }}</textarea>
            </div>
            @error('value_set')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Scroll-->
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-personal-disease-history-modal-action="cancel">Batal</button>
        <button type="submit" class="btn btn-primary" data-kt-personal-disease-history-modal-action="submit">
            <span class="indicator-label">Simpan</span>
            <span class="indicator-progress">Mohon tunggu...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
    <!--end::Actions-->
</form>

