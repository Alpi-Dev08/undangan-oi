{{--@if(1)--}}
@if($examination->health_profesional->health_profesional_type_id == 3)
<div class="row mb-6">
        <!--begin::Label-->
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Odontogram') }}</label>
        <!--end::Label-->
        <!--begin::Input-->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- Upper Teeth -->
                    <div class="row mb-10">
                        <div class="col-12 text-center mb-4">
                            <h4>Upper Teeth</h4>
                        </div>
                        <!-- Row 1 (Gigi 18-11) -->
                        <div class="row mb-6 justify-content-center">
                            @foreach(range(18, 11) as $tooth)
                                <div class="col text-center p-2">
                                    @include('pages.klinik.examinations.partials._tooth', ['tooth' => $tooth])
                                </div>
                            @endforeach
                        </div>
                        <!-- Row 2 (Gigi 21-28) -->
                        <div class="row justify-content-center">
                            @foreach(range(21, 28) as $tooth)
                                <div class="col text-center p-2">
                                    @include('pages.klinik.examinations.partials._tooth', ['tooth' => $tooth])
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Lower Teeth -->
                    <div class="row">
                        <div class="col-12 text-center mb-4">
                            <h4>Lower Teeth</h4>
                        </div>
                        <!-- Row 3 (Gigi 48-41) -->
                        <div class="row mb-6 justify-content-center">
                            @foreach(range(48, 41) as $tooth)
                                <div class="col text-center p-2">
                                    @include('pages.klinik.examinations.partials._tooth', ['tooth' => $tooth])
                                </div>
                            @endforeach
                        </div>
                        <!-- Row 4 (Gigi 31-38) -->
                        <div class="row justify-content-center">
                            @foreach(range(31, 38) as $tooth)
                                <div class="col text-center p-2">
                                    @include('pages.klinik.examinations.partials._tooth', ['tooth' => $tooth])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Input-->
    </div>
@endif
