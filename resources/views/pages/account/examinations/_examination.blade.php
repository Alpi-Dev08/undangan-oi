<!--begin::Basic info-->
<div class="card {{ $class }}">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('Register Examination') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->

    <!--begin::Content-->
    <div id="kt_account_profile_details" class="collapse show">
        <!--begin::Form-->
        <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('settings.create.examination') }}" enctype="multipart/form-data">
            @csrf
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Alert-->
                @if(isset($pemeriksaan_awal))
                    @if($pemeriksaan_awal->user_id == null)
                        @if($pemeriksaan_awal->kriteria_satu=='ya' && $pemeriksaan_awal->kriteria_dua=='ya')
                            <div class="alert alert-danger d-flex align-items-center p-5">
                                @elseif($pemeriksaan_awal->kriteria_satu=='ya' || $pemeriksaan_awal->kriteria_dua=='ya')
                                    <div class="alert alert-warning d-flex align-items-center p-5">
                                        @else
                                            <div class="alert alert-success d-flex align-items-center p-5">
                                                @endif
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Title-->
                                                    <h4 class="mb-1 text-dark">{{ $pemeriksaan_awal->interpretasi  }}</h4>
                                                    <!--end::Title-->

                                                    <!--begin::Content-->
                                                    <span>{{ ucwords($pemeriksaan_awal->tindakan)  }}</span>
                                                    <!--end::Content-->
                                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                                        <input value="{{ $pemeriksaan_awal->id }}" class="form-check-input h-20px w-30px me-5" checked="checked" type="checkbox" name="pemeriksaan_awal" id="pemeriksaan_awal"/>
                                                        <label class="form-check-label" for="kriteria_dua">
                                                            Tambahkan kedalam informasi Pasien
                                                        </label>
                                                    </div>
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Alert-->
                                        @endif
                                        @endif

                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Health Profesional') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                                <select name="health_profesional_id" aria-label="{{ __('Health Profesional') }}" data-control="select2" data-placeholder="{{ __('Select a Health Profesional...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                                    <option value="">{{ __('Select a Health Profesional...') }}</option>
                                                    @foreach($healthprofesionals as $healthprofesional)
                                                        @if(isset($healthprofesional->user->name))
                                                            <option value="{{ $healthprofesional->id }}">
                                                                @if(isset($healthprofesional->user->info))
                                                                    {{ ($healthprofesional->user->info->title_prefix !='' ? $healthprofesional->user->info->title_prefix.'. ' : '').$healthprofesional->user->name.($healthprofesional->user->info->title_suffix!='' ? ', '.$healthprofesional->user->info->title_suffix : '') }}
                                                                @else
                                                                    {{$healthprofesional->user->name}}
                                                                @endif
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Package') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <select name="service_category_id" aria-label="{{ __('Package') }}" data-control="select2" data-placeholder="{{ __('Select a Package...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                                    <option value="">{{ __('Select a Package...') }}</option>
                                                    @foreach($packages as $package)
                                                        <option value="{{ $package->id }}">{{ $package->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Service Category') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <select name="service_category_id" aria-label="{{ __('Service Category') }}" data-control="select2" data-placeholder="{{ __('Select a Service Category...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                                    <option value="">{{ __('Select a Service Category...') }}</option>
                                                    @foreach($servicecategories as $servicecategory)
                                                        <option value="{{ $servicecategory->id }}">{{ $servicecategory->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Locations') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <select name="location_id" aria-label="{{ __('Location') }}" data-control="select2" data-placeholder="{{ __('Select a Location...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                                    <option value="">{{ __('Select a Location...') }}</option>
                                                    @foreach($locations as $location)
                                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Jenis Pasien') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <select name="jenis_pasien_id" aria-label="{{ __('Jenis Pasien') }}" data-control="select2" data-placeholder="{{ __('Pilih Jenis Pasien...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                                    <option value="">{{ __('Pilih Jenis Pasien...') }}</option>
                                                    @foreach($jenisPasien as $jenis)
                                                        <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!--end::Input group-->

                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">&nbsp;</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input value="ya" class="form-check-input h-20px w-30px me-5" type="checkbox" name="isConsent" id="satusehat"/>
                                                    <label class="form-check-label" for="kriteria_dua">
                                                        Telah Mendandatangni Inform Consent SATU SEHAT
                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        <!--begin::Actions-->
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <button type="reset" class="btn btn-white btn-active-light-primary me-2">{{ __('Discard') }}</button>

                                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                                                @include('partials.general._button-indicator', ['label' => __('Register')])
                                            </button>
                                        </div>
                                        <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->

@push('customscript')
    <script type="text/javascript">
        $(document).ready(function () {
            swal.fire({
                title: "Informasi",
                text: "Pastikan pasien telah mendapatkan inform consent SATU SEHAT",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Sudah",
                cancelButtonText: "Belum",
            }).then(function (result) {
                if (result.isConfirmed) {
                    $('#satusehat').prop('checked', true);
                }
            });
        });
    </script>
@endpush
