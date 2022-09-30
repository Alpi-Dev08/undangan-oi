<form id="kt_modal_add_user_form" method="POST" class="form" action="{{ route('users.update',['user' => $user->id]) }}">
@method('PUT')
{{ csrf_field() }}
    <!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
        <!--begin::Input group-->
        <div class="row fv-row">
            <div class="fv-row col-6 mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">First Name</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="input-group input-group-solid has-validation mb-3">
                    <input type="text" name="first_name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('first_name') is-invalid @enderror" placeholder="First name" value="{{ $user->first_name ?? '' }}" />
                </div>
                @error('first_name')
                 <div class="text-danger">{{ $message }}</div>
                @enderror
                <!--end::Input-->
            </div>
            <div class="fv-row col-6 mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Last Name</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="input-group input-group-solid has-validation mb-3">
                    <input type="text" name="last_name" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('last_name') is-invalid @enderror" placeholder="Last name" value="{{ $user->last_name ?? '' }}" />
                </div>
                @error('last_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <!--end::Input-->
            </div>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="row fv-row">
            <div class="fv-row col-6 mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Email</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="input-group input-group-solid has-validation mb-3">
                    <input type="email" name="email" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('email') is-invalid @enderror" placeholder="example@domain.com" value="{{ $user->email ?? '' }}" />
                </div>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row col-6 mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Phone</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="input-group input-group-solid has-validation mb-3">
                    <input type="text" name="phone" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('phone') is-invalid @enderror" placeholder="081234567890" value="{{ $user->phone ?? '' }}" />
                </div>
                @error('phone')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            <!--end::Input-->
            </div>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="row fv-row">
            <div class="fv-row col-6 mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Password</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="input-group input-group-solid has-validation mb-3">
                    <input type="password" name="password" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('password') is-invalid @enderror" value="" />
                </div>
                <!--end::Input-->
            </div>

            <div class="fv-row col-6 mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Confirm Password</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="input-group input-group-solid has-validation mb-3">
                    <input type="password" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('password') is-invalid @enderror" value="" name="password_confirmation" />
                </div>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <!--end::Input-->
            </div>
        </div>
        <!--end::Input group-->

        <div class="mb-7">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-5">Role</label>
            <!--end::Label-->
            <!--begin::Roles-->
        @php $n = 1; @endphp
        @foreach($roles as $role)
            <!--begin::Input row-->
                <div class="d-flex fv-row">
                    <!--begin::Radio-->
                    <div class="form-check form-check-custom form-check-solid">
                        <!--begin::Input-->
                            <input class="form-check-input me-3" name="roles" type="radio" value="{{ $role->id }}"
                                   id="{{ Str::slug($role->name,'-') }}" {{ $user->hasRole($role->name) ? 'checked="checked"' : '' }}>
                            <!--end::Input-->
                            <!--begin::Label-->
                            <label class="form-check-label" for="{{ Str::slug($role->name,'-') }}">
                                <div class="fw-bolder text-gray-800 text-capitalize">{{ $role->name }}</div>
                            </label>
                            <!--end::Label-->
                    </div>
                    <!--end::Radio-->
                </div>
                @if($n < count($roles))
                    <div class="separator separator-dashed my-5"></div>
            @endif
            <!--end::Input row-->
            @php $n++; @endphp
        @endforeach
        <!--end::Roles-->
        </div>
    </div>
    <!--end::Scroll-->
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
																		<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Actions-->
</form>
