<div class="d-flex flex-row flex-center">
    @if(Auth::user()->can('masters.update'))
        <a href="{{ route('countries.edit',['country' => $model->id]) }}"
           class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3") !!}
        </a>
    @endif

    @if(Auth::user()->can('masters.delete'))
        {!! Form::open(['method' => 'DELETE','route' => ['countries.destroy', $model->id],'class'=>'']) !!}
        {{ Form::button(theme()->getSvgIcon("icons/duotune/general/gen027.svg", "svg-icon-3"), ['type' => 'submit', 'class' => 'delete btn btn-icon btn-bg-light btn-active-light-danger btn-sm'] )  }}
        {!! Form::close() !!}
    @endif
</div>
