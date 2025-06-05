@php
    $nav = array(
        array('title' => 'Overview', 'view' => 'account/overview?id='.$user->id),
        array('title' => 'Settings', 'view' => 'account/settings?id='.$user->id),
    );

    if($user->hasRole('patient')){
        $nav[] = array('title' => 'Rekam Medis', 'view' => 'account/medical-records?id='.$user->id);
    }
@endphp

<div class="card shadow-sm mb-5" id="kt_profile_details_view">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
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
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <span class="text-gray-800 fs-2 fw-bolder me-1">{{
                                ($info && $info->title_prefix ? $info->title_prefix.'. ' : '') .
                                $user->name .
                                ($info && $info->title_suffix ? ', '.$info->title_suffix : '')
                            }}</span>
                        </div>
                        <div class="d-flex flex-column fw-bold fs-6 mb-4 pe-2">
                            @if($user->hasRole('patient'))
                                <span>{!! $user->patient->patient_code ?? ""  !!}</span>
                                <span>IHS Number : {!! $user->patient->his_number ?? '-'   !!}</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex my-4">
                        @if($user->hasRole('patient'))
                            <a href="{{ theme()->getPageUrl('klinik/laboratoryexamination-lab?id='.$user->id) }}" class="btn btn-sm btn-success me-2">{{ __('Lab Examination') }}</a>
                            <a href="{{ theme()->getPageUrl('account/examinations?id='.$user->id) }}" class="btn btn-sm btn-success me-2">{{ __('Examination') }}</a>
                            <a href="{{ theme()->getPageUrl('account/appointments?id='.$user->id) }}" class="btn btn-sm btn-info me-2">{{ __('Appointment') }}</a>
                        @endif
                        <a href="{{ theme()->getPageUrl('account/settings?id='.$user->id) }}" class="btn btn-sm btn-primary me-3">{{ __('Edit Profile') }}</a>
                    </div>
                </div>
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->

        <!--begin::Navs-->
        <div class="d-flex overflow-auto h-55px">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                @foreach($nav as $each)
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 {{ theme()->getPagePath() === $each['view'] ? 'active' : '' }}" href="{{ $each['view'] ? theme()->getPageUrl($each['view']) : '#' }}">
                            {{ $each['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <!--end::Navs-->
    </div>

    <div class="card-body pt-9">
        <div class="row g-5">
            <div class="col-md-6">
                @php
                    $leftDetails = [
                        'Card Type' => isset($info->card_type_id) ? $info->card->name : '',
                        'Card Number' => $info->card_number,
                        'IHS Number' => $user->patient->his_number ?? "-",
                        'Full Name' => ($info->title_prefix !='' ? $info->title_prefix.'. ' : '').$user->name.($info->title_suffix!='' ? ', '.$info->title_suffix : ''),
                        'Email' => $user->email,
                        'Contact Phone' => $user->phone,
                        'Place and date of Birth' => $info->place_of_birth.', '.$info->date_of_birth,
                        'Religion' => isset($info->religion) ? $info->religion->name : ''
                    ];
                @endphp

                @foreach($leftDetails as $label => $value)
                    <div class="d-flex flex-column mb-5">
                        <span class="text-muted fw-bold mb-1">{{ __($label) }}</span>
                        <span class="fw-bolder fs-6">{{ $value }}</span>
                    </div>
                @endforeach
            </div>
            <div class="col-md-6">
                @php
                    $rightDetails = [
                        'Gender' => isset($info->gender) ? $info->gender->name : '',
                        'Marital Status' => isset($info->marital_status_id) ? $info->marital->name : '',
                        'Education' => isset($info->education_id) ? $info->education->name : '',
                        'Work' => isset($info->work_id) ? $info->work->name : '',
                        'Blood Type' => isset($info->blood_type_id) ? $info->blood->name : '',
                        'Address' => $info->address.
                            (isset($info->subdistrict) ? ', '.$info->subdistrict->name : '').
                            (isset($info->district) ? ', '.$info->district->name : '').
                            (isset($info->city) ? ', '.$info->city->name : '').
                            (isset($info->province) ? ', '.$info->province->name : '').
                            (isset($info->country) ? ', '.$info->country->name : '').
                            ($info->postal_code!='' ? $info->postal_code : (isset($info->subdistrict) ? ' - '.$info->subdistrict->postal_code : ''))
                    ];
                @endphp

                @foreach($rightDetails as $label => $value)
                    <div class="d-flex flex-column mb-5">
                        <span class="text-muted fw-bold mb-1">{{ __($label) }}</span>
                        <span class="fw-bolder fs-6">{{ $value }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
