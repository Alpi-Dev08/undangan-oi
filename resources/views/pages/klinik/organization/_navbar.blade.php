<!--begin::Navbar-->
<div class="card {{ $class }}">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
            <!--begin: Pic-->
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="{{ $organization->logo }}" alt="image"/>
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
                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{ $organization->name }}</a>
                        </div>
                        <!--end::Name-->

                        <!--begin::Info-->
                        <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                            <span>{{ $organization->email }} {{ $organization->phone }}, {{ $organization->fax }}</span>
                            <span>{{ $organization->address }}{{ isset($organization->subdistrict) ? ', '.$organization->subdistrict->name : '' }}{{ isset($organization->district) ? ', '.$organization->district->name : '' }}{{ isset($organization->city) ? ', '.$organization->city->name : '' }}{{ isset($organization->province) ? ', '.$organization->province->name : '' }}{{ isset($organization->country) ? ', '.$organization->country->name : '' }}{{ $organization->postal_code!='' ? $organization->postal_code : (isset($organization->subdistrict) ? ' - '.$organization->subdistrict->postal_code : '') }}</span>
                        </div>
                        <!--end::Info-->

                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->
    </div>
</div>
<!--end::Navbar-->
