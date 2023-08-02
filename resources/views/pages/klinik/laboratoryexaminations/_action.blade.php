@if($model->approved_by==null)
<div class="d-flex flex-row flex-center">

    @if($model->hasil!=='')
        <a href="{{ route('laboratoryexaminations.download',['id' => $model->id]) }}"
           class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon("icons/duotune/files/fil008.svg", "svg-icon-3 text-primary") !!}
        </a>
    @endif
</div>
@endif
