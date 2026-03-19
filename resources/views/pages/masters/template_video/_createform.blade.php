<form id="kt_modal_add_template_video_form"
      method="POST"
      class="form"
      action="{{ route('template_video.store') }}"
      enctype="multipart/form-data">

    @csrf

    <div class="d-flex flex-column flex-row-fluid">

        <input type="hidden" name="jenis_id" value="3">

        <!-- Nama Template -->
        <div class="fv-row mb-7">
            <label class="required fw-bold fs-6 mb-2">Nama Template</label>

            <input type="text"
                name="nama_template"
                class="form-control form-control-solid border border-gray-300 @error('nama_template') is-invalid @enderror"
                placeholder="Masukkan nama template"
                value="{{ old('nama_template') }}"
            />

            @error('nama_template')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Kategori -->
        <div class="fv-row mb-7">
            <label class="fw-bold fs-6 mb-2">Kategori</label>

            <select name="kategori_id"
                class="form-control form-control-solid border border-gray-300 @error('kategori_id') is-invalid @enderror">

                <option value="">-- Pilih Kategori --</option>

                @foreach($kategori as $k)
                    <option value="{{ $k->id }}"
                        {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>

            @error('kategori_id')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Harga -->
        <div class="fv-row mb-7">
            <label class="fw-bold fs-6 mb-2">Harga</label>

            <div class="input-group">
                <span class="input-group-text">Rp</span>

                <input type="text"
                    id="harga"
                    name="harga"
                    class="form-control form-control-solid border border-gray-300 @error('harga') is-invalid @enderror"
                    placeholder="Masukkan harga"
                    value="{{ old('harga') ? number_format(old('harga'), 0, ',', '.') : '' }}"
                    autocomplete="off"
                />
            </div>

            @error('harga')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- ================= IMAGE PREVIEW ================= -->
        <div class="fv-row mb-7">

            <!-- LABEL -->
            <label class="fw-bold fs-6 mb-3 d-block">Preview Image</label>

            <!-- WRAPPER KIRI -->
            <div class="image-input image-input-outline">
                <div id="preview_image_box"
                    class="image-input-wrapper w-125px h-125px"
                    style="background-image: url('https://via.placeholder.com/150');">
                </div>

                <!-- tombol edit -->
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                    title="Upload Image"
                    style="position:absolute; bottom:0; right:0;">
                    <i class="bi bi-pencil-fill fs-7"></i>
                    <input type="file" name="preview_image" id="preview_image_input" accept="image/*" hidden>
                </label>
            </div>

            <!-- TEXT -->
            <div class="text-muted fs-7 mt-2">
                Allowed file types: png, jpg, jpeg
            </div>

            @error('preview_image')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- ================= VIDEO PREVIEW ================= -->
        <div class="fv-row mb-7">
            <label class="fw-bold fs-6 mb-2">Preview Video</label>

            <input type="file"
                name="preview_video"
                id="preview_video_input"
                accept="video/*"
                class="form-control form-control-solid border border-gray-300 mb-3" />

            <video id="preview_video_player"
                width="300"
                controls
                style="display:none; border-radius:10px;">
            </video>

            @error('preview_video')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Status -->
        <input type="hidden" name="status" value="aktif">

        <!-- Deskripsi -->
        <div class="fv-row mb-7">
            <label class="fw-bold fs-6 mb-2">Deskripsi</label>

            <textarea name="deskripsi"
                class="form-control form-control-solid border border-gray-300 @error('deskripsi') is-invalid @enderror"
                rows="3"
                placeholder="Deskripsi template (opsional)">{{ old('deskripsi') }}</textarea>

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

@push('customscript')
<style>
.image-input {
    position: relative;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // FORMAT HARGA
    // =========================
    const hargaInput = document.getElementById('harga');
    const form = document.getElementById('kt_modal_add_template_video_form');

    if (hargaInput && form) {

        hargaInput.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '');
            this.value = value 
                ? new Intl.NumberFormat('id-ID').format(value)
                : '';
        });

        hargaInput.addEventListener('paste', function (e) {
            let pasteData = (e.clipboardData || window.clipboardData).getData('text');
            pasteData = pasteData.replace(/\D/g, '');

            setTimeout(() => {
                this.value = pasteData 
                    ? new Intl.NumberFormat('id-ID').format(pasteData)
                    : '';
            }, 0);
        });

        form.addEventListener('submit', function () {
            hargaInput.value = hargaInput.value.replace(/\./g, '');
        });
    }

    // =========================
    // IMAGE PREVIEW
    // =========================
    const imageInput = document.getElementById('preview_image_input');
    const imageBox = document.getElementById('preview_image_box');

    if (imageInput) {
        imageInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    imageBox.style.backgroundImage = `url(${e.target.result})`;
                }

                reader.readAsDataURL(file);
            }
        });
    }

    // =========================
    // VIDEO PREVIEW
    // =========================
    const videoInput = document.getElementById('preview_video_input');
    const videoPlayer = document.getElementById('preview_video_player');

    if (videoInput) {
        videoInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                const url = URL.createObjectURL(file);
                videoPlayer.src = url;
                videoPlayer.style.display = 'block';
            }
        });
    }

});
</script>
@endpush