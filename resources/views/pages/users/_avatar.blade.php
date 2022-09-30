
    <div class="d-flex align-items-center">
        <div class="symbol symbol-45px me-5">
            <img src="{{ $model->getAvatarUrlAttribute() }}" alt=""/>
        </div>
        <div class="d-flex justify-content-start flex-column">
            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">{{ $model->first_name.' '.$model->last_name }}</a>
        </div>
    </div>
