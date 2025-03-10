<form id="kt_modal_edit_jenis_pasien_form" method="POST" class="form" action="{{ route('jenis-pasien.update', ['jenis_pasien' => $jenis_pasien->id]) }}">
    @method('PUT')
    {{ csrf_field() }}
    <!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid">
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Jenis Pasien</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="nama" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('nama') is-invalid @enderror" placeholder="Jenis pasien" value="{{ old('nama', $jenis_pasien->nama) }}"/>
            </div>
            @error('nama')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">Keterangan</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <textarea name="keterangan" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('keterangan') is-invalid @enderror" placeholder="Keterangan jenis pasien">{{ old('keterangan', $jenis_pasien->keterangan) }}</textarea>
            </div>
            @error('keterangan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Scroll-->
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-jenis-pasien-modal-action="cancel">Batal</button>
        <button type="submit" class="btn btn-primary" data-kt-jenis-pasien-modal-action="submit">
            <span class="indicator-label">Simpan</span>
            <span class="indicator-progress">Mohon tunggu...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
    <!--end::Actions-->
</form>
