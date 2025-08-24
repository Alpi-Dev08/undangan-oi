<x-base-layout>
    <!--begin::Card-->
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @if(isset($examination->service_category->is_mcu))
                @if($examination->service_category->is_mcu == 1)
                    @include('pages.klinik.examinations._mcuform')
                @else
                    @include('pages.klinik.examinations._editform')
                @endif
            @else
                @include('pages.klinik.examinations._editform')
            @endif


        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</x-base-layout>
