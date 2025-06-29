{{-- Photo Upload Section --}}
<div class="row mb-6">
    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Photo') }}</label>

    <div class="col-lg-8">
        <div class="image-input image-input-outline {{ isset($info) && $info->photo ? '' : 'image-input-empty' }}"
             data-kt-image-input="true"
             style="background-image: url({{ asset(theme()->getMediaUrlPath() . 'photos/blank.png') }})">

            {{-- Preview existing avatar --}}
            <div class="image-input-wrapper w-125px h-125px"
                 style="background-image: {{ isset($info) && $info->photo ? 'url('.asset('storage/'.$info->photo).')' : 'none' }};"></div>

            {{-- Change button --}}
            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                   data-kt-image-input-action="change"
                   data-bs-toggle="tooltip"
                   title="{{ __('Change avatar') }}">
                <i class="bi bi-pencil-fill fs-7"></i>
                <input type="file" name="photo" accept=".png, .jpg, .jpeg"/>
                <input type="hidden" name="avatar_remove"/>
            </label>

            {{-- Cancel button --}}
            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                  data-kt-image-input-action="cancel"
                  data-bs-toggle="tooltip"
                  title="{{ __('Cancel avatar') }}">
                <i class="bi bi-x fs-2"></i>
            </span>

            {{-- Remove button --}}
            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                  data-kt-image-input-action="remove"
                  data-bs-toggle="tooltip"
                  title="{{ __('Remove avatar') }}">
                <i class="bi bi-x fs-2"></i>
            </span>
        </div>

        <div class="form-text">{{ __('Allowed file types: png, jpg, jpeg.') }}</div>
    </div>
</div>
