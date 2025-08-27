<div class="d-flex flex-row flex-center">
    @if(Auth::user()->hasRole(['admin','administrator']))
        <a href="{{ route('examinations.services',['id' => $model->id]) }}"
           class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3") !!}
        </a>
    @endif

    @if(Auth::user()->hasRole('administrator') && $model->status=='waiting payment')
        <form method="POST" action="{{ route('appointments.destroy', $model->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete btn btn-icon btn-bg-light btn-active-light-danger btn-sm">
                {!! theme()->getSvgIcon("icons/duotune/general/gen027.svg", "svg-icon-3") !!}
            </button>
        </form>
    @endif
</div>

