@php
    $nav = array(
        array('title' => 'Overview', 'view' => 'account/overview?id='.$user->id),
        array('title' => 'Settings', 'view' => 'account/settings?id='.$user->id),
    );

    if($user->hasRole('patient')){
        $nav = array(
            array('title' => 'Overview', 'view' => 'account/overview?id='.$user->id),
            array('title' => 'Settings', 'view' => 'account/settings?id='.$user->id),
            //array('title' => 'Rekam Medis', 'view' => 'account/settings?id='.$user->id),
        );
    }

@endphp

    <!--begin::Navbar-->
<div class="card {{ $class }}">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
            <!--begin: Pic-->
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="{{ $user->avatar_url }}" alt="image"/>
                    <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
                </div>
            </div>
            <!--end::Pic-->

            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->
                        <div class="d-flex align-items-center mb-2">
                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{ ($info->title_prefix !='' ? $info->title_prefix.'. ' : '').$user->name.($info->title_suffix!='' ? ', '.$info->title_suffix : '') }}</a>
                        </div>
                        <!--end::Name-->

                        <!--begin::Info-->
                        <div class="d-flex flex-column fw-bold fs-6 mb-4 pe-2">
                            @if($user->hasRole('patient'))
                                <span>{!! $user->patient->patient_code ?? ""  !!}</span>
                                <span>IHS Number : {!! $user->patient->his_number ?? '-'   !!}</span>
                            @endif


                        </div>
                        <!--end::Info-->

                    </div>
                    <!--end::User-->

                    <!--begin::Actions-->
                    <div class="d-flex my-4">
                        @if($user->hasRole('patient'))
                            <a href="{{ theme()->getPageUrl('klinik/laboratoryexamination-lab?id='.$user->id) }}" class="btn btn-sm btn-success me-2">
                                {{ __('Lab Examination') }}
                            </a>

                            <a href="{{ theme()->getPageUrl('account/examinations?id='.$user->id) }}" class="btn btn-sm btn-success me-2">
                                {{ __('Examination') }}
                            </a>
                            <a href="{{ theme()->getPageUrl('account/appointments?id='.$user->id) }}" class="btn btn-sm btn-info me-2">
                                {{ __('Appointment') }}
                            </a>
                        @endif

                        <a href="{{ theme()->getPageUrl('account/settings?id='.$user->id) }}" class="btn btn-sm btn-primary me-3" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-trigger="hover" title="{{ __('Edit Profile') }}">{{ __('Edit Profile') }}</a>
                    </div>
                    <!--end::Actions-->

                </div>
                <!--end::Title-->

            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->

        <!--begin::Navs-->
        <div class="d-flex overflow-auto h-55px">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                @foreach($nav as $each)
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 {{ theme()->getPagePath() === $each['view'] ? 'active' : '' }}" href="{{ $each['view'] ? theme()->getPageUrl($each['view']) : '#' }}">
                            {{ $each['title'] }}
                        </a>
                    </li>
                    <!--end::Nav item-->
                @endforeach
            </ul>
        </div>
        <!--begin::Navs-->
    </div>
</div>
<!--end::Navbar-->
