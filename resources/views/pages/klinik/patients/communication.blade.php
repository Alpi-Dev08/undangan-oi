<x-base-layout>
    <!--begin::Card-->
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-5">
            <!--begin::Card title-->
            <h3 class="card-title align-items-start flex-column">
                Bukti Komunikasi Efektif
            </h3>
            <!--end::Card title-->

            <!--begin::Toolbar (Optional: Adding a cancel button similar to create.blade.php)-->
            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Cancel">
                <a href="{{ route('patients.index') }}" class="btn btn-sm btn-light-primary">
                    <span class="svg-icon svg-icon-muted svg-icon-2hx">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor"/>
                            <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor"/>
                        </svg>
                    </span>
                    Cancel
                </a>
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-6">
            <form id="kt_komunikasi_efektif_form" class="form" method="POST" action="{{ route('komunikasi.efektif.store') }}">
                @csrf
                {{-- <input type="hidden" name="examination_id" value="{{ $examination->id }}"> --}}
                <!--begin::Input group: Situation and Assessment side by side-->
                <div class="row mb-6">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="situation">Situation</label>
                            <textarea name="situation" id="situation" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="assessment">Assessment</label>
                            <textarea name="assessment" id="assessment" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Input group: Background and Recommendation side by side-->
                <div class="row mb-6">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="background">Background</label>
                            <textarea name="background" id="background" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="recommendation">Recommendation</label>
                            <textarea name="recommendation" id="recommendation" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-white btn-active-light-primary me-2">{{ __('Discard') }}</button>
                    <button type="submit" class="btn btn-primary" id="kt_komunikasi_efektif_submit">
                        @include('partials.general._button-indicator', ['label' => __('Save Changes')])
                    </button>
                </div>
                <!--end::Actions-->
            </form>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</x-base-layout>