<div class="d-flex flex-row flex-center">
    <a href="{{ '/account/overview?id='.$model->id}}"
       class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
        {{--icons/duotune/ecommerce/ecm010.svg--}}
        {!! theme()->getSvgIcon("icons/duotune/general/gen004.svg", "svg-icon-3") !!}
    </a>

    @if(Auth::user()->can('klinik.update'))
        <a href="{{ route('patients.edit',['patient' => $model->id]) }}"
           class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3") !!}
        </a>
    @endif

    @if(Auth::user()->can('klinik.delete'))
        {!! Form::open(['method' => 'DELETE','route' => ['patients.destroy', $model->id],'class'=>'']) !!}
        {{ Form::button(theme()->getSvgIcon("icons/duotune/general/gen027.svg", "svg-icon-3"), ['type' => 'submit', 'class' => 'delete btn btn-icon btn-bg-light btn-active-light-danger btn-sm'] )  }}
        {!! Form::close() !!}
    @endif
</div>
