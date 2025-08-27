@php use Carbon\Carbon; @endphp
<!-- begin::Wrapper-->
<div class="mw-lg-950px mx-auto w-100" id="printableArea">
    <!-- begin::Header-->
    <div class="border-bottom pb-4 mb-6">
        <div class="d-flex justify-content-between align-items-start">
            <!-- Logo dan Info Klinik -->
            <div class="d-flex align-items-center">
                <div class="me-4">
                    <!-- Logo Klinik -->
                    <img src="{{ asset('assets/media/logos/ikon-klinik.png') }}" alt="Logo Klinik"
                        class="h-80px print-logo">
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-1 text-capitalize">{{ Str::lower(organization()->name) }}</h3>
                    <div class="text-muted fs-7 lh-lg text-capitalize">
                        <div>{{ organization()->address }},<br> {{ Str::lower(organization()->city->name) }}
                            {{ organization()->province->name }} {{ organization()->postal_code }},
                            {{ organization()->country->name }}</div>
                        <div>Telp. {{ organization()->phone }}</div>
                    </div>
                </div>
            </div>
            <!-- QR Code -->
            <div class="text-end">
                <div class="border border-dark p-2 d-inline-block">
                    <!-- QR Code placeholder -->
                    <div class="bg-dark" style="width: 80px; height: 80px;">
                        <img src="{{ asset('storage/invoice/' . $transaction->invoice_number . '.svg') }}"
                            alt="Logo Klinik" class="h-80px print-logo">
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Title -->
        <div class="text-center mt-4">
            <h1 class="fw-bold text-dark fs-1 mb-0">INVOICE</h1>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Patient Info-->
    <div class="row mb-6">
        <div class="col-md-6">
            <table class="table table-borderless table-sm">
                <tr>
                    <td class="fw-bold text-dark" style="width: 150px;">Registration No / MR</td>
                    <td class="fw-bold">:</td>
                    <td class="fw-bold text-dark">
                        {{ $examination->medical_record->medical_record_code }}
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">Name</td>
                    <td class="fw-bold">:</td>
                    <td class="fw-bold text-dark">{{ strtoupper($user->name) }}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">Address</td>
                    <td class="fw-bold">:</td>
                    <td class="fw-bold text-dark">{{ $info->address ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">Patient Type</td>
                    <td class="fw-bold">:</td>
                    <td class="fw-bold text-dark">{{ $examination->jenis_pasien->nama ?? 'UMUM' }}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">Primary Doctor</td>
                    <td class="fw-bold">:</td>
                    <td class="fw-bold text-dark">
                        {{ (isset($examination->health_profesional->user->info) &&
                        !in_array($examination->health_profesional->user->info->title_prefix, ['', '-'])
                            ? $examination->health_profesional->user->info->title_prefix . '. '
                            : 'dr.') .
                            $examination->health_profesional->user->name .
                            (isset($examination->health_profesional->user->info) &&
                            !in_array($examination->health_profesional->user->info->title_suffix, ['', '-'])
                                ? ', ' . $examination->health_profesional->user->info->title_suffix
                                : '') }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <table class="table table-borderless table-sm">
                <tr>
                    <td class="fw-bold text-dark" style="width: 120px;">Invoice No</td>
                    <td class="fw-bold">:</td>
                    <td class="fw-bold text-dark">{{ $transaction->invoice_number }}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">Invoice Date</td>
                    <td class="fw-bold">:</td>
                    <td class="fw-bold text-dark">
                        {{ Carbon::parse($transaction->updated_at)->locale('id')->format('d F Y H:i') }}
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">Registration Date</td>
                    <td class="fw-bold">:</td>
                    <td class="fw-bold text-dark">
                        {{ Carbon::parse($examination->created_at)->locale('id')->format('d F Y H:i') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <!--end::Patient Info-->

    <!--begin::Services Table-->
    <div class="mb-6">
        <table class="table table-bordered border-dark">
            <thead class="bg-light">
                <tr>
                    <th class="border-dark fw-bold text-dark text-center" style="width: 40px;">No</th>
                    <th class="border-dark fw-bold text-dark">Name</th>
                    <th class="border-dark fw-bold text-dark">Description</th>
                    <th class="border-dark fw-bold text-dark text-center" style="width: 80px;">Qty</th>
                    <th class="border-dark fw-bold text-dark text-center" style="width: 60px;">UOM</th>
                    <th class="border-dark fw-bold text-dark text-center" style="width: 100px;">Amount</th>
                    <th class="border-dark fw-bold text-dark text-center" style="width: 60px;">Disc</th>
                    <th class="border-dark fw-bold text-dark text-center" style="width: 100px;">Patient</th>
                </tr>
            </thead>
            <tbody>
                <!-- Consultation Section -->
                <tr>
                    <td colspan="8" class="border-dark fw-bold text-dark bg-light">CONSULTATION AND VISIT</td>
                </tr>
                @php $no = 1; @endphp
                @foreach ($transaction_detail as $detail)
                    <tr>
                        <td class="border-dark text-center">{{ $no++ }}</td>
                        <td class="border-dark">{{ strtoupper($detail->name) }}</td>
                        <td class="border-dark"></td>
                        <td class="border-dark text-center">1</td>
                        <td class="border-dark text-center"></td>
                        <td class="border-dark text-end">{{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td class="border-dark text-center">0</td>
                        <td class="border-dark text-end">{{ number_format($detail->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                <!-- Drugs Section -->
                @php $total_resep = 0; @endphp
                @if ($examination->resep)
                    <tr>
                        <td colspan="8" class="border-dark fw-bold text-dark bg-light">DRUGS</td>
                    </tr>
                    @php
                        $resep = json_decode($examination->resep);
                    @endphp
                    @if (isset($resep->obat))
                        @php
                            $obat = $resep->obat;
                            $qty = $resep->qty;
                        @endphp
                        @foreach ($obat as $key => $value)
                            @if (isset(getObat($value)->name))
                                <tr>
                                    <td class="border-dark text-center">{{ $no++ }}</td>
                                    <td class="border-dark">{{ strtoupper(getObat($value)->name) }}</td>
                                    <td class="border-dark">PHARMACY OPD 2ND FL</td>
                                    <td class="border-dark text-center">{{ $qty[$key] }}</td>
                                    <td class="border-dark text-center">{{ getObat($value)->unit?->name ?? 'TAB' }}
                                    </td>
                                    <td class="border-dark text-end">
                                        {{ number_format(getObat($value)->price * $qty[$key], 0, ',', '.') }}</td>
                                    <td class="border-dark text-center">0</td>
                                    <td class="border-dark text-end">
                                        {{ number_format(getObat($value)->price * $qty[$key], 0, ',', '.') }}</td>
                                </tr>
                                @php
                                    $total_resep += $qty[$key] * getObat($value)->price;
                                @endphp
                            @endif
                        @endforeach
                    @endif
                @endif
            </tbody>
        </table>
    </div>
    <!--end::Services Table-->

    <!--begin::Total Section-->
    <div class="row mb-6">
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <table class="table table-borderless table-sm">
                <tr>
                    <td class="fw-bold text-dark text-end">SUB TOTAL :</td>
                    <td class="fw-bold text-dark text-end" style="width: 120px;">
                        {{ number_format($transaction->amount + $total_resep, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark text-end">ADMIN CHARGE :</td>
                    <td class="fw-bold text-dark text-end">0</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark text-end">ROUNDING :</td>
                    <td class="fw-bold text-dark text-end">0</td>
                </tr>
                <tr class="border-top border-dark">
                    <td class="fw-bold text-dark text-end fs-5">TOTAL :</td>
                    <td class="fw-bold text-dark text-end fs-5">
                        {{ number_format($transaction->amount + $total_resep + 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark text-end">PAYMENT :</td>
                    <td class="fw-bold text-dark text-end">
                        {{ number_format($transaction->amount + $total_resep + 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark text-end">BALANCE :</td>
                    <td class="fw-bold text-dark text-end">0</td>
                </tr>
            </table>
        </div>
    </div>
    <!--end::Total Section-->

    <!--begin::Payment Info-->
    <div class="mb-6">
        <div class="fw-bold text-dark mb-2">IN WORDS PATIENT :
            {{ ucwords(terbilang($transaction->amount + $total_resep + 0)) }} rupiah</div>

        <div class="fw-bold text-dark mb-3">PATIENT RECEIPT / KUITANSI :</div>

        <table class="table table-bordered border-dark table-sm " style="width: 100%">
            <thead>
                <tr>
                    <th class="border-dark fw-bold text-dark">Type</th>
                    <th class="border-dark fw-bold text-dark">Date</th>
                    <th class="border-dark fw-bold text-dark">Payment Mode</th>
                    <th class="border-dark fw-bold text-dark">Cashier</th>
                    <th class="border-dark fw-bold text-dark text-end">Patient</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border-dark">Payment</td>
                    <td class="border-dark">{{ Carbon::parse($transaction->created_at)->format('d/m/Y') }}</td>
                    <td class="border-dark">{{ ucwords($transaction->metode_pembayaran) }}</td>
                    <td class="border-dark">{{ $transaction->paymentConfirmationUser?->name ?? 'System' }}</td>
                    <td class="border-dark text-end">
                        {{ number_format($transaction->amount + $total_resep + 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="border-dark fw-bold text-end">TOTAL :</td>
                    <td class="border-dark fw-bold text-end">
                        {{ number_format($transaction->amount + $total_resep + 0, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!--end::Payment Info-->

    <!--begin::Footer Info-->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="border border-dark p-3">
                <div class="fs-8 text-dark lh-lg">
                    <div><strong>NPWP:</strong> 94.990.535.0-435.000</div>
                    <div><strong>Catatan:</strong> Invoice ini berlaku sebagai faktur Pajak sesuai dengan Peraturan Direktur Jenderal Pajak No. 27/PJ/2011, Tanggal 18 September 2011</div>
                    <div class="mt-2">@include('partials.bank-accounts')</div>
                    <div class="mt-2">
                        <div><strong>Reservasi Rawat Jalan:</strong> {{ organization()->phone }} (Senin-Jumat 08.00-20.00)</div>
                        <div><strong>Weekend Clinic:</strong> Sabtu & Minggu 08.00-17.00</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 text-end">
            <div class="mb-4">
                <div class="fw-bold text-dark mb-2">CASHIER</div>
                <div style="height: 60px;"></div>
                <div class="border-top border-dark pt-2">
                    <div class="fw-bold text-dark">
                        {{ $transaction->paymentConfirmationUser?->name ?? ('Dr ' . $examination->health_profesional->user->name ?? 'System') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Footer Info-->

    <!--begin::Print Footer-->
    <div class="text-center border-top border-dark pt-3">
        <div class="fs-8 text-dark">Invoice ini merupakan bukti pembayaran yang sah</div>
        <div class="fs-8 text-dark">Printed on {{ Carbon::now()->format('d-M-Y H:i') }} by
            {{ auth()->user()->name ?? 'System' }}</div>
    </div>
    <!--end::Print Footer-->

    <!-- begin::Footer Actions-->
    <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13 noprint">
        <!-- begin::Actions-->
        <div class="my-1 me-5">
            <!-- begin::Print-->
            <div class="d-flex justify-content-end gap-3 mb-4 noprint">
                <a href="{{ route('examinations.invoice.pdf', ['id' => $examination->id]) }}" class="btn btn-primary"
                    target="_blank">
                    <i class="ki-duotone ki-file-down fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Print Invoice
                </a>
            </div>
            <!-- end::Print-->
        </div>
        <!-- end::Actions-->

        <!-- begin::Payment Action-->
        @if ($transaction->status == 'waiting payment')
            <form id="kt_account_profile_details_form" class="form" method="POST"
                action="{{ route('examinations.create.payment') }}" enctype="multipart/form-data">
                @csrf
                <div class="d-flex justify-content-end">
                    <input type="hidden" name="id" value="{{ $transaction->id }}">
                    <input type="hidden" name="status" value="paid">
                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                        @include('partials.general._button-indicator', ['label' => __('Confirm Payment')])
                    </button>
                </div>
            </form>
        @endif
        <!-- end::Payment Action-->
    </div>
    <!-- end::Footer Actions-->
</div>
<!-- end::Wrapper-->

@section('styles')
    <style>
        @media print {
            .noprint {
                display: none !important;
            }

            body {
                font-size: 11px;
                line-height: 1.3;
                background: white !important;
                color: black !important;
            }

            * {
                background: white !important;
                color: black !important;
            }

            .print-logo {
                max-height: 50px !important;
                width: auto;
            }

            .table {
                font-size: 10px !important;
            }

            .table th,
            .table td {
                padding: 4px !important;
                border: 1px solid black !important;
                background: white !important;
                color: black !important;
            }

            .border-dark {
                border-color: black !important;
            }

            .bg-light {
                background-color: #f8f9fa !important;
            }

            .text-dark {
                color: black !important;
            }

            .fw-bold {
                font-weight: 600 !important;
            }

            .fs-1 {
                font-size: 1.8rem !important;
            }

            .fs-5 {
                font-size: 1rem !important;
            }

            .fs-6 {
                font-size: 0.9rem !important;
            }

            .fs-7 {
                font-size: 0.8rem !important;
            }

            .fs-8 {
                font-size: 0.7rem !important;
            }

            .letter-spacing-3 {
                letter-spacing: 3px !important;
            }

            .lh-lg {
                line-height: 1.6 !important;
            }

            /* Remove all colors except black and white */
            .btn,
            .badge,
            .card {
                background: white !important;
                color: black !important;
                border-color: black !important;
            }

            /* Ensure proper spacing */
            .mb-6 {
                margin-bottom: 1.5rem !important;
            }

            .mb-4 {
                margin-bottom: 1rem !important;
            }

            .mb-3 {
                margin-bottom: 0.75rem !important;
            }

            .mb-2 {
                margin-bottom: 0.5rem !important;
            }

            .mb-1 {
                margin-bottom: 0.25rem !important;
            }

            .p-3 {
                padding: 0.75rem !important;
            }

            .pt-3 {
                padding-top: 0.75rem !important;
            }

            .pb-4 {
                padding-bottom: 1rem !important;
            }
        }

        /* Screen styles */
        @media screen {
            .letter-spacing-3 {
                letter-spacing: 3px;
            }
        }
    </style>
@endsection

@push('customscript')
    <script>
        /**
         * Function to print specific div content
         * @param {string} divName - ID of the div to print
         */
        function printDiv(divName) {
            // Get the content to print
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            // Replace body content with print content
            document.body.innerHTML = printContents;

            // Print the page
            window.print();

            // Restore original content
            document.body.innerHTML = originalContents;

            // Reload the page to restore functionality
            location.reload();
        }

        /**
         * Helper function to convert number to words (Indonesian)
         * @param {number} number - Number to convert
         * @returns {string} - Number in words
         */
        function terbilang(number) {
            // This is a placeholder - you should implement proper number to words conversion
            return 'tujuh juta tujuh ratus dua puluh ribu';
        }
    </script>
@endpush
