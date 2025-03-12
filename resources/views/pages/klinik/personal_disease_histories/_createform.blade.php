<form id="kt_modal_add_personal_disease_history_form" method="POST" class="form" action="{{ route('personal-disease-histories.store') }}">
    {{ csrf_field() }}
    <!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid">
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Nama Penyakit</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="disease_name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('disease_name') is-invalid @enderror" placeholder="Nama penyakit" value="{{ old('disease_name') }}"/>
            </div>
            @error('disease_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Tanggal Diagnosis</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="date" name="diagnosis_date" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('diagnosis_date') is-invalid @enderror" value="{{ old('diagnosis_date') }}"/>
            </div>
            @error('diagnosis_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">Detail Pengobatan</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <textarea name="treatment_details" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('treatment_details') is-invalid @enderror" placeholder="Detail pengobatan">{{ old('treatment_details') }}</textarea>
            </div>
            @error('treatment_details')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">Catatan Tambahan</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <textarea name="additional_notes" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('additional_notes') is-invalid @enderror" placeholder="Catatan tambahan">{{ old('additional_notes') }}</textarea>
            </div>
            @error('additional_notes')
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

