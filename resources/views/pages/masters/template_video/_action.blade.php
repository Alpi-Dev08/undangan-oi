<div class="d-flex flex-row flex-center gap-1">

    {{-- TOGGLE STATUS --}}
    <button 
        class="btn btn-sm toggle-status 
        {{ $model->status == 'aktif' ? 'btn-light-success' : 'btn-light-danger' }}"
        data-id="{{ $model->id }}"
        title="Klik untuk ubah status">
        {{ $model->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}
    </button>

    {{-- EDIT --}}
    <a href="{{ route('template_video.edit', $model->id) }}"
       class="btn btn-icon btn-bg-light btn-active-light-primary btn-sm">
        {!! theme()->getSvgIcon('icons/duotune/art/art005.svg', 'svg-icon-3') !!}
    </a>

    {{-- DELETE --}}
    <form method="POST"
          action="{{ route('template_video.destroy', $model->id) }}"
          class="d-inline">
        @csrf
        @method('DELETE')

        <button type="button"
                class="delete btn btn-icon btn-bg-light btn-active-light-danger btn-sm">
            {!! theme()->getSvgIcon('icons/duotune/general/gen027.svg', 'svg-icon-3') !!}
        </button>
    </form>

</div>