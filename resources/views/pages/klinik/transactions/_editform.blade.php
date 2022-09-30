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
                    <!--begin::Table head-->
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

                            <input type="text" class="form-control form-control-solid mb-2" name="name[]" placeholder="Item name"  value="{{$detail->name}}"/>
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
                    <tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                        <th class="text-primary">
                            <button type="button" class="btn btn-link py-1" data-kt-element="add-item">Add item</button>
                        </th>
                        <th colspan="2" class="border-bottom border-bottom-dashed ps-0">
                            <div class="d-flex flex-column align-items-start">
                                <div class="fs-5">Subtotal</div>
                                <button class="btn btn-link py-1" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Coming soon">Add tax</button>
                                <button class="btn btn-link py-1" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Coming soon">Add discount</button>
                            </div>
                        </th>
                        <th colspan="2" class="border-bottom border-bottom-dashed text-end">Rp
                            <span data-kt-element="sub-total">{{ number_format($transaction->amount,2,'.',',') }}</span></th>
                    </tr>
                    <tr class="align-top fw-bold text-gray-700">
                        <th></th>
                        <th colspan="2" class="fs-4 ps-0">Total</th>
                        <th colspan="2" class="text-end fs-4 text-nowrap">Rp
                            <span data-kt-element="grand-total">{{ number_format($transaction->amount,2,'.',',') }}</span></th>
                    </tr>
                    </tfoot>
                    <!--end::Table foot-->
                </table>
            </div>
            <!--end::Table-->
            <!--begin::Item template-->
            <table class="table d-none" data-kt-element="item-template">
                <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                    <td class="pe-7">
                        <input type="text" class="form-control form-control-solid mb-2" name="name[]" placeholder="Item name" />
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
    <script src="{{ asset(theme()->getDemo().'/js/custom/apps/invoices/create.js') }}"></script>
    @endpush
