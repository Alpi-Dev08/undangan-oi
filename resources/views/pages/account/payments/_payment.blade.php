<!--begin::Basic info-->
<div class="card {{ $class }}">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('Payment Confirtmation') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->

    <!--begin::Content-->
    <div id="kt_account_profile_details" class="collapse show">
        <!--begin::Form-->
        <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('settings.create.payment') }}" enctype="multipart/form-data">
        @csrf
        <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Input group-->
                <div class="row mb-6" style="text-align:center">
                    <h3>Lakukan Pembayaran Senilai : </h3>
                    <h3>Rp. {{ number_format($examination->total, 0, ',', '.') }}</h3>
                    <h3>Ke Rekening : </h3>
                    <h3>Bank BCA</h3>
                    <h3>Atas Nama : PT. Konsultasi Dokter</h3>
                    <h3>No. Rekening : 1234567890</h3>
                </div>
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-white btn-active-light-primary me-2">{{ __('Discard') }}</button>
                <input type="hidden" name="id" value="{{ $examination->id }}">
                <input type="hidden" name="status" value="paid">
                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                    @include('partials.general._button-indicator', ['label' => __('Konfirmasi Pembayaran')])
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->
