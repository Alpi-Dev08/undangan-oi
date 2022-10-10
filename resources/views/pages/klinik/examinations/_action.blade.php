<div class="d-flex flex-row flex-center">
    @if($model->status=='waiting' || $model->status=='processing')
        @if(Auth::user()->can('klinik.update'))
            <a href="{{ route('examinations.vitality',['id' => $model->id]) }}"
               class="btn btn-icon btn-bg-light btn-active-light-success btn-sm me-1">
                {!! theme()->getSvgIcon("icons/duotune/medicine/med006.svg", "svg-icon-3 text-success") !!}
            </a>
        @endif

        @if(Auth::user()->can('klinik.update'))
            <a href="{{ route('examinations.edit',['examination' => $model->id]) }}"
               class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
                {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3 text-primary") !!}
            </a>
        @endif
    @endif
        @if(Auth::user()->can('klinik.delete') && $model->status=='waiting')
            {!! Form::open(['method' => 'DELETE','route' => ['examinations.destroy', $model->id],'class'=>'']) !!}
            {{ Form::button(theme()->getSvgIcon("icons/duotune/general/gen027.svg", "svg-icon-3 text-danger"), ['type' => 'submit', 'class' => 'delete btn btn-icon btn-bg-light btn-active-light-danger btn-sm'] )  }}
            {!! Form::close() !!}
        @endif
</div>

