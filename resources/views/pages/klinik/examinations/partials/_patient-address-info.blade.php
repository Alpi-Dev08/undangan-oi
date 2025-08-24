{{-- Address Information Section --}}
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ __('Address') }}</label>
    <div class="col-lg-8">
        <a href="#" class="fw-bold fs-6 text-dark text-hover-primary">
            {{ $info->address }}
            {{-- Build complete address string --}}
            @if(isset($info->subdistrict))
                , {{ $info->subdistrict->name }}
            @endif
            @if(isset($info->district))
                , {{ $info->district->name }}
            @endif
            @if(isset($info->city))
                , {{ $info->city->name }}
            @endif
            @if(isset($info->province))
                , {{ $info->province->name }}
            @endif
            @if(isset($info->country))
                , {{ $info->country->name }}
            @endif
            {{-- Postal code --}}
            @if($info->postal_code != '')
                {{ $info->postal_code }}
            @elseif(isset($info->subdistrict))
                - {{ $info->subdistrict->postal_code }}
            @endif
        </a>
    </div>
</div>