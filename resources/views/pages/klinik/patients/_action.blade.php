<div class="d-flex flex-row flex-center">
    <a href="{{ route('laboratoryexaminations.lab', ['id' => $model->id]) }}"
        class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
        {{-- icons/duotune/ecommerce/ecm010.svg --}}
        {!! theme()->getSvgIcon('icons/duotune/medicine/med004.svg', 'svg-icon-3 svg-icon-info') !!}
    </a>

    <a href="{{ '/account/overview?id=' . $model->id }}"
        class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
        {{-- icons/duotune/ecommerce/ecm010.svg --}}
        {!! theme()->getSvgIcon('icons/duotune/general/gen004.svg', 'svg-icon-3') !!}
    </a>

    @if (Auth::user()->can('klinik.update'))
        <a href="{{ route('patients.edit', ['patient' => $model->id]) }}"
            class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon('icons/duotune/art/art005.svg', 'svg-icon-3') !!}
        </a>
    @endif

    <a href="{{ route('komunikasi.efektif.form', ['examination' => $model->id]) }}"
        class="btn bi bi-telephone-plus-fill btn-bg-light  btn-active-light-primary btn-sm me-1">
        {!! theme()->getSvgIcon('icons/duotune/bi bi-telephone-plus-fill/med004.svg', 'svg-icon-3') !!}
    </a>

    @if (Auth::user()->can('klinik.delete'))
        <form method="POST" action="{{ route('patients.destroy', $model->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete btn btn-icon btn-bg-light btn-active-light-danger btn-sm">
                {!! theme()->getSvgIcon('icons/duotune/general/gen027.svg', 'svg-icon-3') !!}
            </button>
        </form>
    @endif
</div>
