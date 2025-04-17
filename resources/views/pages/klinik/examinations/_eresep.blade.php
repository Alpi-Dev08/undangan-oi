@php use Carbon\Carbon; @endphp
    <!-- begin::Wrapper-->
<div class="mw-lg-950px mx-auto w-100" id="printableArea">
    <!-- begin::Header-->
    <header>
        <table style="width:100%;border-bottom-width:5px;border-bottom-style:double">
            <tr style="vertical-align:baseline">
                <div>
                    <img src="{{ asset('logos/logo-klinik.png') }}"  class="img-fluid mb-1 custom-img" style="max-width: 40px;">
                </div>
                <td style="width: 50%; vertical-align:top">
                    <p style="margin:0px; margin-top:10px; font-size:12px;text-align: right;color:#000;">
                        {!! organizationInfo('full') !!}
                    </p>
                </td>
            </tr>
        </table>
        <table style="width:100%;border-bottom-width:5px;border-bottom-style:double">
            <tr>
                <td>Dokter Pemeriksa</td>
                <td>: {{ (!in_array($examination->health_profesional->user->info->title_prefix,['','-']) ? $examination->health_profesional->user->info->title_prefix.'. ' : '').$examination->health_profesional->user->name.(!in_array($examination->health_profesional->user->info->title_suffix,['','-']) ? ', '.$examination->health_profesional->user->info->title_suffix : '') }}</b>
                </td>
            </tr>
            <tr>
                <td>SIP</td>
                <td>: {{ $examination->health_profesional->sip_number ? 'SIP.'.$examination->health_profesional->sip_number : '' }}
                </td>
            </tr>
        </table>
    </header>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="pb-12">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column gap-7 gap-md-10">
            <!--begin::Order details-->
            <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold justify-content-end">
                <div class="flex-root d-flex flex-column text-end">
                    <span class="text-muted"></span>
                    <span class="fs-5">{{ Carbon::parse($transaction->created_at)->format('d F Y') }}</span>
                </div>
            </div>
            <!--end::Order details-->
            <h2 style="font-weight: bolder;color:#436ba4;font-size:26px;margin:0px;margin-top:10px;text-transform: uppercase">
            R/</h2>
            <!--begin:Order summary-->
            <div class="d-flex justify-content-between flex-column">
                <!--begin::Table-->
                <div class="table-responsive border-bottom mb-9">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                        <tbody class="fw-semibold text-gray-600">
                        <!--begin::Products-->

                        @php $total_resep = 0; @endphp
                        @if($examination->resep)
                        <thead>
                        <tr class="border-bottom fs-6 fw-bold text-muted">
                            <th class="min-w-175px pb-2">Obat</th>
                            <th class="min-w-100px text-end pb-2">Jumlah</th>
                            <th class="min-w-100px text-end pb-2">Keterangan</th>
                        </tr>
                        </thead>
                        @php
                            $resep = json_decode($examination->resep);
                        @endphp
                        @if(isset($resep->obat))
                            @php
                                $obat = $resep->obat;
                                $qty = $resep->qty;
                                $keterangan = $resep->keterangan ?? [];
                            @endphp
                            @foreach($obat as $key => $value)
                                @if(isset(getObat($value)->name))
                                    <tr>
                                        <td class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <a href="#" class="text-gray-800 text-hover-primary mb-1">{{getObat($value)->name ?? ''}}</a>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-muted">{{$qty[$key]?? ''}}</span>
                                        </td>
                                        <td class="text-end text-gray-800">
                                            <span class="text-gray-600 me-2">{{ $keterangan[$key] ?? ''}}</span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endif

                        <!--end::Products-->

                        </tbody>
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end:Order summary-->

            <!--begin::Pasien details-->
            <table class="table"  style="width:100%;">
                <tbody>
                    <tr>
                        <td style="width:20%;">Nama</td>
                        <td style="width:80%;">: <b>{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}</b></td>
                    </tr>
                    <tr>
                        <td style="width:20%;">Umur</td>
                        <td style="width:80%;">: <b>{{ \Carbon\Carbon::parse($info->date_of_birth)->age  }} tahun</b></td>
                    </tr>
                    <tr>
                        <td style="width:20%;">Alamat</td>
                        <td style="width:80%;">: <b>{{ $user->info->address }}{{ isset($user->info->subdistrict) ? ', '.$user->info->subdistrict->name : '' }}{{ isset($user->info->district) ? ', '.$user->info->district->name : '' }}{{ isset($user->info->city) ? ', '.$user->info->city->name : '' }}{{ isset($user->info->province) ? ', '.$user->info->province->name : '' }}{{ isset($user->info->country) ? ', '.$user->info->country->name : '' }}{{ $user->info->postal_code!='' ? $user->info->postal_code : (isset($user->info->subdistrict) ? ' - '.$user->info->subdistrict->postal_code : '') }}</b></td>
                    </tr>
                </tbody>
            </table>
            <!--end::Pasien details-->

            <h4 style="font-weight: bolder;color:#436ba4;font-size:12px;margin:0px;margin-top:10px;text-transform: uppercase;text-align: center;">
                Obat tsb, tidak boleh diganti tanpa sepengetahuan dokter
            </h4>

        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Body-->
    <!-- begin::Footer-->
    <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13 noprint">
        <!-- begin::Actions-->
        <div class="my-1 me-5">
            <!-- begin::Pint-->
            <button type="button" class="btn btn-success my-1 me-12" onclick="printDiv('printableArea');">Print E-Resep</button>
            <!-- end::Pint-->
        </div>
        <!-- end::Actions-->
        <!-- begin::Action-->
        @if($transaction->status=='waiting payment')
            <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('examinations.create.payment') }}" enctype="multipart/form-data">
                @csrf
                <!--begin::Card body-->
                <!--begin::Input group-->

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <input type="hidden" name="id" value="{{ $transaction->id }}">
                    <input type="hidden" name="status" value="paid">
                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                        @include('partials.general._button-indicator', ['label' => __('Confirm Payment')])
                    </button>
                </div>
                <!--end::Actions-->
            </form>
        @endif
        <!-- end::Action-->
    </div>
    <!-- end::Footer-->
</div>
<!-- end::Wrapper-->
@section('styles')
    <style>
        @media print {
            .noprint {
                display: none !important;
            }
        }
    </style>
@endsection
@push('customscript')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
