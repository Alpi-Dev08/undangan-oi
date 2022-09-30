<x-base-layout>
    <!--begin::Card-->
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <!--begin::Card body-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                              height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                              fill="currentColor"></rect>
														<path
                                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                            fill="currentColor"></path>
													</svg>
												</span>
                    <!--end::Svg Icon-->
                    <input type="text" id="searchbox" class="form-control form-control-solid border border-gray-300 w-250px ps-15"
                           placeholder="Search Users">
                </div>

            </h3>

            @if(Auth::user()->can('user.create'))
            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title=""
                 data-bs-original-title="Click to add a user">
                <a href="{{ route('users.create')  }}" class="btn btn-sm btn-light-primary">
                    <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr075.svg-->
                    <span class="svg-icon svg-icon-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                           viewBox="0 0 24 24" fill="none">
<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)"
      fill="black"></rect>
<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black"></rect>
</svg></span>
                    <!--end::Svg Icon-->
                    New User
                </a>
            </div>
                @endif
        </div>
        <div class="card-body pt-6">
            @include('pages.users._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</x-base-layout>
