<!--begin::Form-->
    <form id="kt_invoice_form" method="POST" class="form" action="{{ route('transactions.update',['transaction' => $transaction->id]) }}">
    {{ csrf_field() }}
    @method('PUT')
    <!--begin::Wrapper-->
        <div class="mb-0">
            <!--begin::Row-->

            <!--begin::Table wrapper-->
            <div class="table-responsive mb-10">
                <!--begin::Table-->
                <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items">


                    <thead>
                    <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                        <th class="min-w-300px w-475px">Service</th>
                        <th class="min-w-100px w-100px">QTY</th>
                        <th class="min-w-150px w-150px">Price</th>
                        <th class="min-w-100px w-150px text-end">Total</th>
                        <th class="min-w-75px w-75px text-end">Action</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    <input type="hidden" name="transaction_id" value="{{$transaction->id}}">
                    @foreach($transaction->transactionDetails as $detail)
                    <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                        <td class="pe-7">
                            <input type="hidden" name="id[]" value="{{$detail->id}}">

                            @if($detail->service->category->id == $examination->service_category_id)
                            <select name="service_id[]" aria-label="{{ __('Select a Service') }}" data-control="select2" data-placeholder="{{ __('Select a service...') }}" class="mb-2 form-select form-select-solid form-select-lg fw-bold">
                                <option value="">{{ __('Select a Service...') }}</option>
                                @foreach($category->services as $key => $value)
                                    <option value="{{ $value['id'] }}" {{ $value['id']==$detail->service_id ? "selected" : '' }}>{{ $value['name'] }}</option>
                                @endforeach
                            </select>
                            @else
                                <select name="service_id[]" aria-label="{{ __('Select a Service') }}" data-control="select2" data-placeholder="{{ __('Select a service...') }}" class="mb-2 form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">{{ __('Select a Service...') }}</option>
                                    @foreach($services as $key => $value)
                                        <option value="{{ $value['id'] }}" {{ $value['id']==$detail->service_id ? "selected" : '' }}>{{ $value['name'] }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <input type="text" class="form-control form-control-solid" name="description[]" placeholder="Description" value="{{$detail->description}}" />
                        </td>
                        <td class="ps-0">
                            <input class="form-control form-control-solid" type="number" min="1" name="quantity[]" placeholder="1" value="{{$detail->quantity}}" data-kt-element="quantity" />
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-solid text-end" name="price[]" placeholder="0" value="{{ number_format($detail->price,2,'.',',') }}" data-kt-element="price" />
                        </td>
                        <td class="pt-8 text-end text-nowrap">Rp
                            <span data-kt-element="total">{{ number_format($detail->quantity*$detail->price,0,'.',',') }}</span></td>
                        <td class="pt-5 text-end">
                            <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                <span class="svg-icon svg-icon-3">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
																							<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
																							<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
																						</svg>
																					</span>
                                <!--end::Svg Icon-->
                            </button>
                        </td>
                    </tr>
                        @endforeach

                    </tbody>
                    <!--end::Table body-->
                    <!--begin::Table foot-->
                    <tfoot>
                    <!--begin::Table head-->
                    <tr class="border-bottom border-bottom-dashed">
                        <td class="pe-7" colspan="5">
                            <button type="button" class="btn btn-link py-1" data-kt-element="add-item">Add item</button>
                        </td>
                    </tr>
                    <!-- <tr class="border-bottom border-bottom-dashed">
                        <td class="pe-7" colspan="5">
                            RESEP OBAT
                        </td>
                    </tr> -->
                    @php $totalobat = 0; @endphp

                    @php
                        // Tampilkan obat dari Prescription terbaru jika tersedia
                        $latestPrescription = null;
                        try {
                            if (method_exists($examination, 'prescriptions')) {
                                $latestPrescription = $examination->prescriptions()
                                    ->with(['items.drug'])
                                    ->orderByDesc('resep_date')
                                    ->first();
                            }
                        } catch (Throwable $e) {
                            $latestPrescription = null;
                        }
                    @endphp

                    @if($latestPrescription && $latestPrescription->items && $latestPrescription->items->count())
                        <tr class="border-bottom border-bottom-dashed">
                            <td class="pe-7" colspan="5">RESEP OBAT (Prescription)</td>
                        </tr>
                        @foreach($latestPrescription->items as $item)
                            @php
                                $drugName = $item->drug_name ?? data_get($item->drug, 'name') ?? $item->kfa_code;
                                $price = isset($item->drug) && isset($item->drug->price) ? (float) $item->drug->price : null;
                                if($price === null && !empty($item->drug_id) && function_exists('getObat')){
                                    $drug = getObat($item->drug_id);
                                    $price = isset($drug->price) ? (float) $drug->price : 0.0;
                                }
                                $qtyPresc = is_numeric($item->qty) ? (float) $item->qty : 0.0;
                                $unit = $item->unit ?? data_get($item->drug, 'unit') ?? data_get($item->drug, 'uom') ?? data_get($item, 'uom') ?? data_get($item, 'satuan') ?? '-';
                                $lineTotal = ($price ?? 0.0) * $qtyPresc;
                                $totalobat += $lineTotal;
                            @endphp
                            <tr class="border-bottom border-bottom-dashed">
                                <td class="pe-7">{{ $drugName }}</td>
                                <td class="pe-7">{{ $qtyPresc }} {{ $unit }}</td>
                                <td class="pe-7" style="text-align: right">Rp {{ number_format($price ?? 0,2,'.',',') }}</td>
                                <td class="pe-7" style="text-align: right">Rp {{ number_format($lineTotal,2,'.',',') }}</td>
                                <td class="pe-7"></td>
                            </tr>
                        @endforeach
                    @endif

                    @if($examination->resep)
                        @php
                            $resepRaw = $examination->resep;
                            $resep = is_string($resepRaw) ? json_decode($resepRaw ?: '{}') : (is_array($resepRaw) ? (object) $resepRaw : null);
                            $obat = $resep->obat ?? [];
                            $qty = $resep->qty ?? [];
                        @endphp
                        @if (!empty($obat))
                            <tr class="border-bottom border-bottom-dashed">
                                <td class="pe-7" colspan="5">RESEP OBAT (Legacy)</td>
                            </tr>
                            @for($i=0;$i<count($obat);$i++)
                                @php $_obat = function_exists('getObat') ? getObat($obat[$i]) : null; @endphp
                                @if(isset($_obat->id))
                                    @php
                                        $qtyLegacy = isset($qty[$i]) && is_numeric($qty[$i]) ? (float) $qty[$i] : 0.0;
                                        $priceLegacy = isset($_obat->price) ? (float) $_obat->price : 0.0;
                                        $unitLegacy = data_get($_obat, 'unit') ?? data_get($_obat, 'uom') ?? data_get($_obat, 'satuan') ?? '-';
                                        $lineTotalLegacy = $priceLegacy * $qtyLegacy;
                                        $totalobat += $lineTotalLegacy;
                                    @endphp
                                    <tr class="border-bottom border-bottom-dashed">
                                        <td class="pe-7">{{ $_obat->name ?? "-" }}</td>
                                        <td class="pe-7">{{ $qtyLegacy }} {{ $unitLegacy->name }}</td>
                                        <td class="pe-7" style="text-align: right">Rp {{ number_format($priceLegacy,2,'.',',') }}</td>
                                        <td class="pe-7" style="text-align: right">Rp {{ number_format($lineTotalLegacy,2,'.',',') }}</td>
                                        <td class="pe-7"></td>
                                    </tr>
                                @endif
                            @endfor
                        @endif
                    @endif
                    <tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                        <th class="text-primary">
                           &nbsp;
                        </th>
                        <th colspan="2" class="border-bottom border-bottom-dashed ps-0">
                            <div class="d-flex flex-column align-items-start">
                                <div class="fs-5">Subtotal</div>
                            </div>
                        </th>
                        <th colspan="2" class="border-bottom border-bottom-dashed text-end">Rp
                            <span data-kt-element="sub-total">{{ number_format($transaction->amount,2,'.',',') }}</span></th>
                    </tr>
                    <tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                        <th class="text-primary">
                            &nbsp;
                        </th>
                        <th colspan="2" class="border-bottom border-bottom-dashed ps-0">
                            <div class="d-flex flex-column align-items-start">
                                <div class="fs-5">Subtotal Obat</div>
                            </div>
                        </th>
                        <th colspan="2" class="border-bottom border-bottom-dashed text-end">Rp
                            <span data-kt-element="sub-total">{{ number_format($totalobat,2,'.',',') }}</span></th>
                    </tr>
                    <tr class="align-top fw-bold text-gray-700">
                        <th></th>
                        <th colspan="2" class="fs-4 ps-0">Total</th>
                        <th colspan="2" class="text-end fs-4 text-nowrap">Rp
                            <span data-kt-element="grand-total">{{ number_format(($transaction->amount ?? 0) + ($totalobat ?? 0),2,'.',',') }}</span></th>
                    </tr>
                    </tfoot>
                    <!--end::Table foot-->
                </table>
            </div>
            <!--end::Table-->
            <!--begin::Item template-->
            <table class="table d-none services" data-kt-element="item-template">
                <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                    <td class="pe-7">
                        <select name="service_id[]" aria-label="{{ __('Select a Service') }}" data-placeholder="{{ __('Select a service...') }}" class="mb-2 form-select form-select-solid form-select-lg fw-bold">
                            <option value="">{{ __('Select a Service...') }}</option>
                            @foreach($services as $key => $value)
                                <option value="{{ $value['id'] }}" data-harga="{{ $value['price'] }}">{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control form-control-solid" name="description[]" placeholder="Description" />
                    </td>
                    <td class="ps-0">
                        <input class="form-control form-control-solid" type="number" min="1" name="quantity[]" placeholder="1" data-kt-element="quantity" />
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-solid text-end" name="price[]" placeholder="0.00" data-kt-element="price" />
                    </td>
                    <td class="pt-8 text-end">Rp
                        <span data-kt-element="total">0.00</span></td>
                    <td class="pt-5 text-end">
                        <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                            <span class="svg-icon svg-icon-3">
																				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																					<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
																					<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
																					<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
																				</svg>
																			</span>
                            <!--end::Svg Icon-->
                        </button>
                    </td>
                </tr>
            </table>
            <table class="table d-none" data-kt-element="empty-template">
                <tr data-kt-element="empty">
                    <th colspan="5" class="text-muted text-center py-10">No items</th>
                </tr>
            </table>
            <!--end::Item template-->
            <!--begin::Notes-->
            <div class="mb-0">
                <label class="form-label fs-6 fw-bold text-gray-700">Notes</label>
                <textarea name="notes" class="form-control form-control-solid" rows="3" placeholder="Thanks for your business">{{ $transaction->notes }}</textarea>
            </div>
            <!--end::Notes-->

            <div class="mt-5 mb-0">
                <label class="form-label fs-6 fw-bold text-gray-700">Payment Method</label>
                <select name="metode_pembayaran" aria-label="{{ __('Select a Payment Method') }}" data-placeholder="{{ __('Select a Payment Method...') }}" class="mb-2 form-select form-select-solid form-select-lg fw-bold">
                    <option value="cash" {{ $transaction->metode_pembayaran=='cash' ? 'selected' : "" }}>Cash</option>
                    <option value="transfer" {{ $transaction->metode_pembayaran=='transfer' ? 'selected' : "" }}>Transfer</option>
                    <option value="qris" {{ $transaction->metode_pembayaran=='qris' ? 'selected' : "" }}>QRIS</option>
                </select>
            </div>

            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-transactions-modal-action="cancel">Discard</button>
                <button type="submit" class="btn btn-primary" data-kt-transactions-modal-action="submit">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
                </button>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Wrapper-->
    </form>
    <!--end::Form-->

@push('customscript')
    <script src="{{ asset('/assets/js/custom/apps/invoices/create.js') }}"></script>
    <script>
        $(".services > .form-select").change(function(){
            alert("The text has been changed.");
        });
    </script>
    @endpush
