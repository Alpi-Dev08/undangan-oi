<form id="kt_modal_add_kategori_form" method="POST" class="form" action="{{ route('kategori_web.store') }}">
    @csrf

    <div class="d-flex flex-column flex-row-fluid">
        <input name="jenis_id" value="3" type="hidden">

        <!-- Nama Kategori -->
        <div class="fv-row mb-7">
            <label class="required fw-bold fs-6 mb-2">Nama Kategori</label>

            <input
                type="text"
                name="nama_kategori"
                class="form-control form-control-solid border border-gray-300
                @error('nama_kategori') is-invalid @enderror"
                placeholder="Masukkan nama kategori"
                value="{{ old('nama_kategori') }}"
            />

            @error('nama_kategori')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Deskripsi -->
        <div class="fv-row mb-7">
            <label class="fw-bold fs-6 mb-2">Deskripsi</label>

            <textarea
                name="deskripsi"
                class="form-control form-control-solid border border-gray-300
                @error('deskripsi') is-invalid @enderror"
                placeholder="Deskripsi kategori (opsional)"
                rows="3"
            >{{ old('deskripsi') }}</textarea>

            @error('deskripsi')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <!-- Actions -->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3">Discard</button>

        <button type="submit" class="btn btn-primary">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
</form>
