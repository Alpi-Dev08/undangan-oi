<div class="d-flex flex-row flex-center">

    {{-- Edit --}}
    <a href="{{ route('template_web.edit', $model->id) }}"
       class="btn btn-icon btn-bg-light btn-active-light-primary btn-sm me-1">
        {!! theme()->getSvgIcon('icons/duotune/art/art005.svg', 'svg-icon-3') !!}
    </a>

    {{-- Delete --}}
    <form method="POST"
          action="{{ route('template_web.destroy', $model->id) }}"
          class="d-inline">
        @csrf
        @method('DELETE')

        <button type="button"
                class="delete btn btn-icon btn-bg-light btn-active-light-danger btn-sm">
            {!! theme()->getSvgIcon('icons/duotune/general/gen027.svg', 'svg-icon-3') !!}
        </button>
    </form>

</div>