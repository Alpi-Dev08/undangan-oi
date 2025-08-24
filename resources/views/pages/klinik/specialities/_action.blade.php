<div class="d-flex flex-row flex-center">
    @if (Auth::user()->can('klinik.update'))
        <a href="{{ route('specialities.edit', ['speciality' => $model->id]) }}"
            class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon('icons/duotune/art/art005.svg', 'svg-icon-3') !!}
        </a>
    @endif

    @if (Auth::user()->can('klinik.delete'))
        <form method="POST" action="{{ route('specialities.destroy', $model->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete btn btn-icon btn-bg-light btn-active-light-danger btn-sm">
                {!! theme()->getSvgIcon('icons/duotune/general/gen027.svg', 'svg-icon-3') !!}
            </button>
        </form>
    @endif
</div>
