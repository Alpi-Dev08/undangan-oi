<div class="d-flex flex-row flex-center">
    @if (Auth::user()->can('role.update'))
        <a href="{{ route('roles.edit', ['role' => $model->id]) }}"
            class="btn btn-bg-light btn-active-light-primary btn-sm me-1" data-bs-toggle="tooltip"
            data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="Edit">
            {!! theme()->getSvgIcon('icons/duotune/art/art005.svg', 'svg-icon-3') !!} Edit
        </a>
    @endif

    @if ($model->id > 5 && Auth::user()->can('role.delete'))
        <form action="{{ route('roles.destroy', $model->id) }}" method="POST" class="">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete btn btn-bg-light btn-active-light-danger btn-sm"
                data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="Delete">
                {!! theme()->getSvgIcon('icons/duotune/general/gen027.svg', 'svg-icon-3') !!} Delete
            </button>
        </form>
    @endif
</div>
