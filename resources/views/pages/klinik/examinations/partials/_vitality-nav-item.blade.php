{{-- Navigation Item untuk Vitality Form Tabs --}}
<li class="nav-item p-0 ms-0">
    <a class="nav-link btn btn-color-gray-400 flex-center px-3 {{ $active ? 'active' : '' }}" 
       data-kt-timeline-widget-4="tab"
       data-bs-toggle="tab" 
       href="{{ $href }}">
        {{-- Title --}}
        <span class="nav-text fw-semibold fs-4 mb-3">{{ $title }}</span>
        
        {{-- Bullet Indicator --}}
        <span class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
    </a>
</li>