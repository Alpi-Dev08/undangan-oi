<form method="POST" class="form"
      action="{{ route('kategori_video.update', $kategori->id) }}">
    @csrf
    @method('PUT')

    <div class="d-flex flex-column flex-row-fluid">

        <!-- Jenis Undangan -->
        <input
                type="hidden"
                name="jenis_id"
                class="form-control form-control-solid border border-gray-300
                @error('jenis_id') is-invalid @enderror"
                placeholder="Nama kategori"
                value="{{ old('jenis_id', $kategori->jenis_id) }}"
            />

        <!-- Nama Kategori -->
        <div class="fv-row mb-7">
            <label class="required fw-bold fs-6 mb-2">Nama Kategori</label>

            <input
                type="text"
                name="nama_kategori"
                class="form-control form-control-solid border border-gray-300
                @error('nama_kategori') is-invalid @enderror"
                placeholder="Nama kategori"
                value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
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
                rows="3"
            >{{ old('deskripsi', $kategori->deskripsi) }}</textarea>

            @error('deskripsi')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3">Discard</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
