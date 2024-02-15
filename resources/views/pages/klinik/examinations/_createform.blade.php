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
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Alert-->

<!--begin::Card-->
<div class="card card-xxl-stretch mb-5 mb-xl-8">
    <!--begin::Card body-->
    <!--begin::Card header-->
    <div class="card-header position-relative py-0 border-bottom-1">
        <!--begin::Card title-->
        <h3 class="card-title text-gray-800 fw-bold">
            Laboratory Examination {{  $examination->examination_code }}
        </h3>
        <!--end::Card title-->
        <!--begin::Tabs-->
        <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-4">
            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#user">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Patient Profile</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3 active" data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#examination">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Examination</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->
        </ul>
        <!--end::Tabs-->
    </div>

    <div class="card-body pb-0">
        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab pane-->
            <div class="tab-pane" id="user" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <!--end::Name-->
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted"></label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                    <img src="{!!  $user->avatar_url !='' ? $user->avatar_url : asset(theme()->getMediaUrlPath().'photos/blank.png') !!}" alt="image"/>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Patien ID') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $user->patient->patient_code }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Medical Record') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $user->mr->medical_record_code }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Card Type') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ isset($info->card_type_id) ? $info->card->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Card Type') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ isset($info->card_type_id) ? $info->card->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Full Name') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ ($info->title_prefix !='' ? $info->title_prefix.'. ' : '').$user->name.($info->title_suffix!='' ? ', '.$info->title_suffix : '') }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Card Number') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->card_number }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Full Name') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                <span
                    class="fw-bolder fs-6 text-dark">{{ ($info->title_prefix !='' ? $info->title_prefix.'. ' : '').$user->name.($info->title_suffix!='' ? ', '.$info->title_suffix : '') }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Email') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $user->email }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">
                                {{ __('Contact Phone') }}
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                   title="Phone number must be active"></i>
                            </label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 d-flex align-items-center">
                                <span class="fw-bolder fs-6 me-2">{{ $user->phone }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Place and date of Birth') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->place_of_birth.', '.$info->date_of_birth }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Religion') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ isset($info->religion) ? $info->religion->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Gender') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ isset($info->gender) ? $info->gender->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Marital Status') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ isset($info->marital_status_id) ? $info->marital->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Education') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ isset($info->education_id) ? $info->education->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Work') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ isset($info->work_id) ? $info->work->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Blood Type') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ isset($info->blood_type_id) ? $info->blood->name : '' }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Weight') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->weight }} Kg</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Height') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6">{{ $info->height}} cm</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">{{ __('Address') }}</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <a href="#"
                                   class="fw-bold fs-6 text-dark text-hover-primary">{{ $info->address }}{{ isset($info->subdistrict) ? ', '.$info->subdistrict->name : '' }}{{ isset($info->district) ? ', '.$info->district->name : '' }}{{ isset($info->city) ? ', '.$info->city->name : '' }}{{ isset($info->province) ? ', '.$info->province->name : '' }}{{ isset($info->country) ? ', '.$info->country->name : '' }}{{ $info->postal_code!='' ? $info->postal_code : (isset($info->subdistrict) ? ' - '.$info->subdistrict->postal_code : '') }}</a>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::details View-->
            </div>

            <div class="tab-pane active" id="examination" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
                <form id="kt_modal_add_permission_form" method="POST" class="form" action="{{ route('laboratoryexaminations.store') }}">
                {{ csrf_field() }}
                <!--begin::Scroll-->
                    <div class="d-flex flex-column flex-row-fluid">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Laboratory') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                                <select name="laboratory_id" aria-label="{{ __('Laboratory') }}" data-control="select2" data-placeholder="{{ __('Select a Laboratory...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Laboratory...') }}</option>
                                    @foreach($laboratories as $laboratory)
                                        <option value="{{ $laboratory->id }}">{{  $laboratory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Laboratory Unit') }}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <select name="laboratory_unit_id" aria-label="{{ __('Laboratory Unit') }}" data-control="select2" data-placeholder="{{ __('Select a Laboratory Unit...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Laboratory Unit...') }}</option>
                                    @foreach($laboratory_units as $laboratory_unit)
                                        <option value="{{ $laboratory_unit->id }}">{{  $laboratory_unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Laboratory Examination Type</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 pt-5">
                                <ul style="margin-left:-40px;" class="row">
                                    @foreach($categories as $category)
                                        <li class="col-lg-6 mb-6" style="list-style: none;">
                                            <div class="form-check form-check-custom form-check-solid mb-3">
                                                <input class="form-check-input" type="checkbox" value="{{ $category->id }}" name="categories[]" id="category_{{ $category->id }}">
                                                <label class="form-check-label fw-bold" for="category_{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                            <ul>
                                                @foreach(types($category->id) as $type)
                                                    <li style="list-style: none;">
                                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                                            <input class="form-check-input" type="checkbox" value="{{ $type->id }}" name="types[]" id="type_{{ $type->id }}">
                                                            <label class="form-check-label" for="type_{{ $type->id }}">
                                                                {{ $type->name }}
                                                            </label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">

                        <a href="{{ route('examinations.index')  }}" class="btn btn-sm btn-light-primary">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor"/>
                            <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor"/>
                        </svg>
                    </span>
                            <!--end::Svg Icon-->
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary" data-kt-examinations-modal-action="submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
            </div>
        </div>
    </div>
</div>

@push('customscript')
    <script type="text/javascript">
        $(function () {
            $('input[type=checkbox]').change(function () {
                // if is checked
                if (this.checked) {
                    // check all children
                    var lenchk = $(this).closest('ul').find(':checkbox');
                    var lenchkChecked = $(this).closest('ul').find(':checkbox:checked');

                    //if all siblings are checked, check its parent checkbox
                    if (lenchk.length == lenchkChecked.length) {
                        $(this).closest('ul').siblings().find(':checkbox').prop('checked', true);
                    } else {
                        $(this).closest('.form-check-custom').siblings().find(':checkbox').prop('checked', true);
                    }
                } else {
                    // uncheck all children
                    $(this).closest('.form-check-custom').siblings().find(':checkbox').prop('checked', false);
                    $(this).closest('ul').siblings().find(':checkbox').prop('checked', false);
                }
            });
        })
    </script>
@endpush

