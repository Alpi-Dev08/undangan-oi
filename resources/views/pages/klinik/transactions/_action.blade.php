<div class="d-flex flex-row flex-center">
    @if(Auth::user()->can('klinik.update'))
        <a href="{{ route('examinations.invoice',['id' => $model->examination_id]) }}"
           class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon("icons/duotune/general/gen004.svg", "svg-icon-3") !!}
        </a>
        @if($model->status=='waiting payment')
            <a href="{{ route('transactions.edit',['transaction' => $model->id]) }}"
               class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
                {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3") !!}
            </a>
        @endif
    @endif

</div>

