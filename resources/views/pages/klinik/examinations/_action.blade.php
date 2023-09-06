<div class="d-flex flex-row flex-center">
    <a href="{{ route('patients.print',['id' => $model->id]) }}"
       class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
        {!! theme()->getSvgIcon("icons/duotune/ecommerce/ecm010.svg", "svg-icon-3") !!}
    </a>

@if($model->status!='waiting payment')
    <a href="{{ route('examinations.pdf',['id' => $model->id]) }}"
       class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
        {!! theme()->getSvgIcon("icons/duotune/files/fil008.svg", "svg-icon-3 text-primary") !!}
    </a>
@endif
    @if(Auth::user()->hasRole(['ners','administrator']))
        <a href="{{ route('examinations.vitality',['id' => $model->id]) }}"
           class="btn btn-icon btn-bg-light btn-active-light-success btn-sm me-1">
            @if(cekVitalityExamination($model->id))
                {!! theme()->getSvgIcon("icons/duotune/medicine/med006.svg", "svg-icon-3 text-success") !!}
            @else
                {!! theme()->getSvgIcon("icons/duotune/medicine/med006.svg", "svg-icon-3 text-danger") !!}
            @endif
        </a>
    @endif

    @if(Auth::user()->hasRole(['dokter','administrator']))
        <a href="{{ route('examinations.edit',['examination' => $model->id]) }}"
           class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3 text-primary") !!}
        </a>
    @endif
        {!! Form::open(['method' => 'DELETE','route' => ['examinations.destroy', $model->id],'class'=>'']) !!}
        {{ Form::button(theme()->getSvgIcon("icons/duotune/general/gen027.svg", "svg-icon-3 text-danger"), ['type' => 'submit', 'class' => 'delete btn btn-icon btn-bg-light btn-active-light-danger btn-sm'] )  }}
        {!! Form::close() !!}
</div>

