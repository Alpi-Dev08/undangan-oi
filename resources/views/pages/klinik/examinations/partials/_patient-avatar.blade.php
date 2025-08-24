{{-- Patient Avatar Section --}}
<div class="row mb-7">
    {{-- Empty label column for alignment --}}
    <label class="col-lg-4 fw-bold text-muted"></label>

    {{-- Avatar display column --}}
    <div class="col-lg-8 fv-row">
        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
            <img src="{{ $user->avatar_url != '' ? $user->avatar_url : asset(theme()->getMediaUrlPath().'photos/blank.png') }}"
                 alt="{{ __('Patient Avatar') }}"
                 class="rounded"
                 loading="lazy">

            {{-- Optional: Status indicator overlay --}}
            @if(isset($user->is_active) && $user->is_active)
                <div class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n3 mt-n3"></div>
            @endif
        </div>

        {{-- Optional: Patient status or additional info --}}
        @if(isset($info->patient_status))
            <div class="mt-2">
                <span class="badge badge-light-{{ $info->patient_status == 'active' ? 'success' : 'warning' }}">
                    {{ ucfirst($info->patient_status) }}
                </span>
            </div>
        @endif
    </div>
</div>
