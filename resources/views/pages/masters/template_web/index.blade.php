<x-base-layout>
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <div class="d-flex align-items-center position-relative my-1">
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                  transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3
                                     C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19Z"
                                  fill="currentColor"/>
                        </svg>
                    </span>

                    <input type="text"
                           id="searchbox"
                           class="form-control form-control-solid border border-gray-300 w-250px ps-15"
                           placeholder="Search Template">
                </div>
            </h3>

            @if(Auth::user()->can('masters.create'))
                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                     title=""
                     data-bs-original-title="Click to add a role">
                    <a href="{{ route('template_web.create') }}" class="btn btn-sm btn-light-primary">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/metronic/releases/2022-07-14-092914/core/html/src/media/icons/duotune/arrows/arr013.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M11 13H7C6.4 13 6 12.6 6 12C6 11.4 6.4 11 7 11H11V13ZM17 11H13V13H17C17.6 13 18 12.6 18 12C18 11.4 17.6 11 17 11Z" fill="currentColor"/>
                                <path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM17 11H13V7C13 6.4 12.6 6 12 6C11.4 6 11 6.4 11 7V11H7C6.4 11 6 11.4 6 12C6 12.6 6.4 13 7 13H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V13H17C17.6 13 18 12.6 18 12C18 11.4 17.6 11 17 11Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        New Template
                    </a>
                </div>
            @endif
        </div>

        <div class="card-body pt-6">
            @include('pages.masters.template_web._table')
        </div>
    </div>
</x-base-layout>
