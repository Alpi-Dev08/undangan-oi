<!DOCTYPE html>
{{--
Product Name: {{ theme()->getOption('product', 'description') }}
Author: KeenThemes
Purchase: {{ theme()->getOption('product', 'purchase') }}
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: {{ theme()->getOption('product', 'license') }}
--}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"{!! theme()->printHtmlAttributes('html') !!}
    {{ theme()->printHtmlClasses('html') }}>
{{-- begin::Head --}}

<head>
    <meta charset="utf-8" />
    <title>{{ ucfirst(theme()->getOption('meta', 'title')) }}</title>
    <meta name="description" content="{{ ucfirst(theme()->getOption('meta', 'description')) }}" />
    <meta name="keywords" content="{{ theme()->getOption('meta', 'keywords') }}" />
    <link rel="canonical" href="{{ ucfirst(theme()->getOption('meta', 'canonical')) }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('assets' . '/' . theme()->getOption('assets', 'favicon')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- begin::Fonts --}}
    {{ theme()->includeFonts() }}
    {{-- end::Fonts --}}

    @if (theme()->hasOption('page', 'assets/vendors/css'))
        {{-- begin::Page Vendor Stylesheets(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/vendors/css')) as $file)
            {!! preloadCss(assetCustom($file)) !!}
        @endforeach
        {{-- end::Page Vendor Stylesheets --}}
    @endif

    @if (theme()->hasOption('page', 'assets/custom/css'))
        {{-- begin::Page Custom Stylesheets(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/custom/css')) as $file)
            {!! preloadCss(assetCustom($file)) !!}
        @endforeach
        {{-- end::Page Custom Stylesheets --}}
    @endif

    @if (theme()->hasOption('assets', 'css'))
        {{-- begin::Global Stylesheets Bundle(used by all pages) --}}
        @foreach (array_unique(theme()->getOption('assets', 'css')) as $file)
            @if (strpos($file, 'plugins') !== false)
                {!! preloadCss(assetCustom($file)) !!}
            @else
                <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css" />
            @endif
        @endforeach
        {{-- end::Global Stylesheets Bundle --}}
    @endif

    @if (theme()->getViewMode() === 'preview')
        {{ theme()->getView('partials/trackers/_ga-general') }}
        {{ theme()->getView('partials/trackers/_ga-tag-manager-for-head') }}
    @endif

    @yield('styles')
    <style>
        .table.gy-5 th,
        .table.gy-5 td {
            padding-top: 0.25rem !important;
            padding-bottom: 0.25rem !important;
        }

        .marquee {
            white-space: nowrap;
            overflow: hidden;
            box-sizing: border-box;
        }

        .marquee span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 30s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(-100%, 0);
            }
        }
    </style>
</head>
{{-- end::Head --}}

{{-- begin::Body --}}

<body {!! theme()->printHtmlAttributes('body') !!} {!! theme()->printHtmlClasses('body') !!} {!! theme()->printCssVariables('body') !!} data-kt-name="metronic">
<!-- 
    <div class="alert alert-warning p-2 mb-0"
        style="position: fixed; bottom: 0; left: 0; width: 100%; z-index: 100000; overflow: hidden;display:none">
        <div class="marquee">
            <span class="d-flex align-items-center">
                <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3"
                            d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z"
                            fill="currentColor"></path>
                        <path
                            d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 9.4 13 10C13 10.6 12.6 11 12 11C11.4 11 11 10.6 11 10ZM12 21C11.4 21 11 20.6 11 20C11 19.4 11.4 19 12 19C12.6 19 13 19.4 13 20C13 20.6 12.6 21 12 21Z"
                            fill="currentColor"></path>
                    </svg>
                    <strong class="text-warning me-2">Pemberitahuan Update:</strong>
                    Akan dilakukan Update Module ICD-10 pukul 21.00, diharapkan semua pekerjaan telah tersimpan sebelum
                    dilakukan update. Terima kasih.
                </span>
            </span>
        </div>
    </div> -->

    <!--begin::Theme mode setup on page load-->
    <script>
        if (document.documentElement) {
            var name = document.body.getAttribute("data-kt-name");
            var themeMode = localStorage.getItem("kt_" + name + "_theme_mode_value");
            var enableSystemMode = true;

            if (themeMode) {
                if (themeMode === "dark") {
                    document.documentElement.setAttribute("data-theme", "dark");
                } else if (themeMode === "light") {
                    document.documentElement.setAttribute("data-theme", "light");
                } else if (enableSystemMode === true || themeMode === "system") {
                    document.documentElement.setAttribute("data-theme", window.matchMedia('(prefers-color-scheme: dark)') ?
                        "dark" : "light");
                }
            } else {
                document.documentElement.setAttribute("data-theme", "light");
            }
        }
    </script>
    <!--end::Theme mode setup on page load-->

    @if (theme()->getOption('layout', 'loader/display') === true)
        {{ theme()->getView('layout/_loader') }}
    @endif

    @yield('content')

    {{-- begin::Javascript --}}
    @if (theme()->hasOption('assets', 'js'))
        {{-- begin::Global Javascript Bundle(used by all pages) --}}
        @foreach (array_unique(theme()->getOption('assets', 'js')) as $file)
            <script src="{{ asset('assets' . '/' . $file) }}"></script>
        @endforeach
        {{-- end::Global Javascript Bundle --}}
    @endif

    @if (theme()->hasOption('page', 'assets/vendors/js'))
        {{-- begin::Page Vendors Javascript(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/vendors/js')) as $file)
            <script src="{{ asset('assets' . '/' . $file) }}"></script>
        @endforeach
        {{-- end::Page Vendors Javascript --}}
    @endif

    @if (theme()->hasOption('page', 'assets/custom/js'))
        {{-- begin::Page Custom Javascript(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/custom/js')) as $file)
            <script src="{{ asset('assets' . '/' . $file) }}"></script>
        @endforeach
        {{-- end::Page Custom Javascript --}}
    @endif
    {{-- end::Javascript --}}

    @if (theme()->getViewMode() === 'preview')
        {{ theme()->getView('partials/trackers/_ga-tag-manager-for-body') }}
    @endif

    @yield('scripts')
    @stack('customscript')
    <script>
        $(function() {
            $('.form-select.form-select-solid').addClass('border border-gray-300')
        })
    </script>
    <script>
        $(function() {
            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @endif

            @if (session('error'))
                toastr.error('{{ session('error') }}');
            @endif

            @if (session('warning'))
                toastr.warning('{{ session('warning') }}');
            @endif

            @if (session('info'))
                toastr.info('{{ session('info') }}');
            @endif
        });
    </script>
</body>
{{-- end::Body --}}

</html>
