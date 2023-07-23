@if($model->file)
    <a href="{{ route('laboratoryexaminations.download',['laboratoryexaminations' => $model->id]) }}"
       class="btn btn-bg-light btn-active-light-primary btn-sm me-1" data-bs-toggle="tooltip"
       data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="Download">
        {!! theme()->getSvgIcon("icons/duotune/files/fil021.svg", "svg-icon-3") !!} Download
    </a>
@endif
    @if($model->result==null && $model->approved_by==null)
        <a href="{{ route('laboratoryexaminations.result',['id' => $model->id, 'status' => "3"]) }}"
           class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon("icons/duotune/files/fil011.svg", "svg-icon-3 text-warning") !!}
        </a>
    @elseif($model->result && $model->approved_by==null)
        <a href="{{ route('laboratoryexaminations.result',['id' => $model->id, 'status' => '2']) }}"
           class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon("icons/duotune/files/fil024.svg", "svg-icon-3 text-info") !!}
        </a>
    @elseif($model->approved_by && $model->result)
        <a href="{{ route('laboratoryexaminations.result',['id' => $model->id, 'status' => '1']) }}"
           class="btn btn-icon btn-bg-light  btn-active-light-primary btn-sm me-1">
            {!! theme()->getSvgIcon("icons/duotune/files/fil008.svg", "svg-icon-3 text-success") !!}
        </a>
    @endif

