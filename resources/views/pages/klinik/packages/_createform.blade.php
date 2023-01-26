<form id="kt_modal_add_permission_form" method="POST" class="form" action="{{ route('packages.store') }}">
{{ csrf_field() }}
<!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid">

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Package Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('name') is-invalid @enderror" placeholder="Package name" value=""/>
            </div>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        <!--end::Input-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Package Price</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <input type="text" name="price" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('price') is-invalid @enderror" placeholder="Package price" value=""/>
            </div>
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-bold fs-6 mb-2">Description</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group input-group-solid has-validation mb-3">
                <textarea name="description" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('description') is-invalid @enderror" placeholder="Description"></textarea>
            </div>
            @error('description')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <div class="fv-row mb-7">
            <ul style="padding-top:10px" class="row">
                @foreach($service_categories as $category)
                    <li class="col-lg-4 mb-6" style="list-style: none;">
                        <div class="form-check fw-bold form-check-custom form-check-solid mb-3">
                            {{ $category->name }}
                        </div>
                        <ul>
                            @foreach(services($category->id) as $service)
                                <li style="list-style: none;">
                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" value="{{ $service->id }}" name="service_id[]" id="service_{{ $service->id }}">
                                        <label class="form-check-label" for="type_{{ $service->id }}">
                                            {{ $service->name }}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Switch-->
            <label class="form-check form-switch form-check-custom form-check-solid">
                <input class="form-check-input" name="is_active" type="checkbox" value="1" checked="checked"/>
                <span class="form-check-label fw-semibold text-muted">
                   Aktif
                </span>
            </label>
            <!--end::Switch-->

            @error('is_active')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <!--end::Input-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Scroll-->
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-packages-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-packages-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
    <!--end::Actions-->
</form>

