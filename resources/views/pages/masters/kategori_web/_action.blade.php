<div class="d-flex flex-row flex-center">
    @if (Auth::user()->can('masters.update'))
        <a href="{{ route('kategori_web.edit', ['kategori_web' => $model->id]) }}"
            class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon('icons/duotune/art/art005.svg', 'svg-icon-3') !!}
        </a>
    @endif

    @if (Auth::user()->can('masters.delete'))
    <form method="POST" action="{{ route('kategori_web.destroy', $model->id) }}" class="d-inline">
        @csrf
        @method('DELETE')

        <button
            type="button"
            class="delete btn btn-icon btn-bg-light btn-active-light-danger btn-sm"
            title="Hapus">
            {!! theme()->getSvgIcon('icons/duotune/general/gen027.svg', 'svg-icon-3') !!}
        </button>
    </form>
    @endif
</div>
