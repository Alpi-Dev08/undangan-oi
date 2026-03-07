<form method="POST"
      action="{{ route('template_web.store') }}"
      enctype="multipart/form-data">

    @csrf

    <!-- Nama Template --> 
    <div class="mb-7">
        <label class="required fw-bold fs-6 mb-2">Nama Template</label>
        <input type="text"
               name="nama_template"
               class="form-control form-control-solid border border-gray-300 @error('nama_template') is-invalid @enderror"
               value="{{ old('nama_template') }}">

        @error('nama_template')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Kategori -->
    <div class="mb-7">
        <label class="required fw-bold fs-6 mb-2">Kategori</label>
        <select name="kategori_id"
                class="form-select form-select-solid border border-gray-300 @error('kategori_id') is-invalid @enderror">

            <option value="">-- Pilih Kategori --</option>

            @foreach($kategori as $item)
                <option value="{{ $item->id }}"
                    {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_kategori }}
                </option>
            @endforeach
        </select>

        @error('kategori_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Premium -->
    <div class="mb-7">
        <label class="fw-bold fs-6 mb-2">Tipe Template</label>
        <select name="is_premium"
                class="form-select form-select-solid border border-gray-300">

            <option value="0" {{ old('is_premium') == 0 ? 'selected' : '' }}>
                Free
            </option>

            <option value="1" {{ old('is_premium') == 1 ? 'selected' : '' }}>
                Premium
            </option>
        </select>
    </div>

    <!-- Harga -->
    <div class="mb-7">
        <label class="fw-bold fs-6 mb-2">Harga (Jika Premium)</label>
        <input type="number"
               name="harga"
               min="0"
               class="form-control form-control-solid border border-gray-300 @error('harga') is-invalid @enderror"
               value="{{ old('harga') }}">
    </div>

    <!-- Preview Image -->
    <div class="mb-7">
        <label class="fw-bold fs-6 mb-2">Preview Image</label>
        <input type="file"
               name="preview_image"
               class="form-control @error('preview_image') is-invalid @enderror">

        @error('preview_image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="text-center pt-10">
        <button type="submit" class="btn btn-primary">
            Simpan Template
        </button>
    </div>

</form>