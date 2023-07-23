@if($model->approved_by==null)
<div class="d-flex flex-row flex-center">

    @if($model->status=='paid')
        <a href="{{ route('laboratoryexaminations.show',['laboratoryexamination' => $model->id]) }}"
           class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon("icons/duotune/ecommerce/ecm010.svg", "svg-icon-3 svg-icon-primary") !!}
        </a>
    @endif

    @if(Auth::user()->can('klinik.update'))
        <a href="{{ route('laboratoryexaminations.edit',['laboratoryexamination' => $model->id]) }}"
           class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3 svg-icon-warning") !!}
        </a>
    @endif

    @if($model->status!='paid')
        @if(Auth::user()->can('klinik.delete'))
            {!! Form::open(['method' => 'DELETE','route' => ['laboratoryexaminations.destroy', $model->id],'class'=>'']) !!}
            {{ Form::button(theme()->getSvgIcon("icons/duotune/general/gen027.svg", "svg-icon-3 svg-icon-danger"), ['type' => 'submit', 'class' => 'delete btn btn-icon btn-bg-light btn-active-light-danger btn-sm'] )  }}
            {!! Form::close() !!}
        @endif
    @endif
</div>
@endif
