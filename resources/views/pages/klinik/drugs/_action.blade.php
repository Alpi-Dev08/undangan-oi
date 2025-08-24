<div class="d-flex flex-row flex-center">
    @if (Auth::user()->can('klinik.update'))
        <a href="{{ route('drugs.edit', ['drug' => $model->id]) }}"
            class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon('icons/duotune/art/art005.svg', 'svg-icon-3') !!}
        </a>
    @endif
    @if (Auth::user()->can('klinik.update'))
        <a href="{{ route('drugs.detail', ['drug' => $model->id]) }}"
            class="btn btn-icon btn-bg-light btn-active-light-primary btn-sm me-1">
            <i class="bi bi-plus-circle-fill svg-icon-3"></i>
        </a>
    @endif
    @if (Auth::user()->can('klinik.update'))
        <a href="{{ route('drugs.reduceDetail', ['drug' => $model->id]) }}"
            class="btn btn-icon btn-bg-light btn-active-light-primary btn-sm me-1">
            <i class="bi bi-dash-circle-fill svg-icon-3"></i>
        </a>
    @endif
    @if (Auth::user()->can('klinik.delete'))
        <form method="POST" action="{{ route('drugs.destroy', $model->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete btn btn-icon btn-bg-light btn-active-light-danger btn-sm">
                {!! theme()->getSvgIcon('icons/duotune/general/gen027.svg', 'svg-icon-3') !!}
            </button>
        </form>
    @endif
</div>
