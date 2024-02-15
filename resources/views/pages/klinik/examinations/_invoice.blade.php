<!-- begin::Wrapper-->
<div class="mw-lg-950px mx-auto w-100" id="printableArea">
    <!-- begin::Header-->
    <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
        <h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">INVOICE</h4>
        <!--end::Logo-->
        <div class="text-sm-end">
            <!--begin::Logo-->
            <a href="#" class="d-block mw-150px ms-sm-auto">
                <h1>Klinik Satriabudi Daharma Medika</h1>
            </a>
            <!--end::Logo-->
            <!--begin::Text-->
            <div class="text-sm-end fw-semibold fs-4 text-muted mt-7">
                <div>tangerang</div>
                <div>Indonesia </div>
            </div>
            <!--end::Text-->
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="pb-12">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column gap-7 gap-md-10">
            <!--begin::Message-->
            <div class="fw-bold fs-2">Dear {{ ($info->title_prefix !='' ? $info->title_prefix.'. ' : '').$user->name.($info->title_suffix!='' ? ', '.$info->title_suffix : '') }}
                <span class="fs-6">({{$user->phone}})</span>,
                <br />
                <span class="text-muted fs-5">Here are your order details. We thank you for your purchase.</span></div>
            <!--begin::Message-->
            <!--begin::Separator-->
            <div class="separator"></div>
            <!--begin::Separator-->
            <!--begin::Order details-->
            <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                <div class="flex-root d-flex flex-column">
                    <span class="text-muted">Invoice ID</span>
                    <span class="fs-5">#{{$transaction->invoice_number}}</span>
                </div>
                <div class="flex-root d-flex flex-column">
                    <span class="text-muted">Date</span>
                    <span class="fs-5">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d F Y') }}</span>
                </div>
            </div>
            <!--end::Order details-->
            <!--begin::Billing & shipping-->
            <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                <div class="flex-root d-flex flex-column">
                    <span class="text-muted">Billing Address</span>
                    <span class="fs-6">{{ $info->address }}{{ isset($info->subdistrict) ? ', '.$info->subdistrict->name : '' }}{{ isset($info->district) ? ', '.$info->district->name : '' }}{{ isset($info->city) ? ', '.$info->city->name : '' }}{{ isset($info->province) ? ', '.$info->province->name : '' }}{{ isset($info->country) ? ', '.$info->country->name : '' }}{{ $info->postal_code!='' ? $info->postal_code : (isset($info->subdistrict) ? ' - '.$info->subdistrict->postal_code : '') }}
                </div>
                <div class="flex-root d-flex flex-column">
                    <span class="text-muted">Payment Method</span>
                    <span class="fs-6">{{ ucwords($transaction->metode_pembayaran) }}</span>
                </div>
            </div>
            <!--end::Billing & shipping-->
            <!--begin:Order summary-->
            <div class="d-flex justify-content-between flex-column">
                <!--begin::Table-->
                <div class="table-responsive border-bottom mb-9">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                        <thead>
                        <tr class="border-bottom fs-6 fw-bold text-muted">
                            <th class="min-w-175px pb-2">Layanan</th>
                            <th class="min-w-100px text-end pb-2">Total</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        <!--begin::Products-->
                        @foreach($transaction_detail as $detail)
                            <tr>
                                <td class="d-flex align-items-center">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">{{$detail->name}}</a>
                                    </div>
                                </td>
                                <td class="text-end text-gray-800">
                                    <span class="text-gray-600 me-2">Rp</span>{{number_format($detail->price,0,',','.')}}
                                </td>
                            </tr>
                        @endforeach
                        @if($examination->resep)
                        <tr class="border-bottom fs-6 fw-bold text-muted">
                            <th class="min-w-175px pb-2">Obat</th>
                            <th class="min-w-100px text-end pb-2"></th>
                        </tr>
                        @php
                            $resep = json_decode($examination->resep);
                            $obat = $resep->obat;
                            $qty = $resep->qty;
                            $total_resep = 0;
                        @endphp
                        @foreach($obat as $key => $value)
                            <tr>
                                <td class="d-flex align-items-center">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">{{getObat($value)->name}}</a>
                                    </div>
                                </td>
                                <td class="text-end text-gray-800">
                                    <span class="text-gray-600 me-2">Rp </span>{{number_format($qty[$key]*getObat($value)->price,0,',','.')}}
                                </td>
                            </tr>
                            @php
                                $total_resep += $qty[$key]*getObat($value)->price;
                            @endphp
                        @endforeach
                        @endif

                        <!--end::Products-->

                        <!--begin::Grand total-->
                        <tr>
                            <td class="fs-3 text-dark fw-bold text-end">Grand Total</td>
                            <td class="text-dark fs-3 fw-bolder text-end">Rp</span>{{number_format($transaction->amount+$total_resep,0,',','.')}}</td>
                        </tr>
                        <!--end::Grand total-->
                        <tr>
                  			    <td colspan="2">Notes : </td>
                  			</tr>
                  			<tr>
                  			    <td colspan="2"><pre>{{ $transaction->notes }}</pre></td>
                  			</tr>
                        </tbody>
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end:Order summary-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Body-->
    <!-- begin::Footer-->
    <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13 noprint">
        <!-- begin::Actions-->
        <div class="my-1 me-5">
            <!-- begin::Pint-->
            <button type="button" class="btn btn-success my-1 me-12" onclick="printDiv('printableArea');">Print Invoice</button>
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
  .noprint{
    display:none !important;
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
