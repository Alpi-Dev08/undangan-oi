@php use Carbon\Carbon; @endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $transaction->invoice_number }}</title>
    <style>
        @font-face {
            font-family: 'Roboto Condensed';
            src: public_path('assets/fonts/Roboto_Condensed/RobotoCondensed-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Roboto';
            src: public_path('assets/fonts/Roboto/Roboto-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Nunito Sans';
            src: public_path('assets/fonts/Nunito_Sans/NunitoSans-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /**
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 1cm;
            left: 1cm;
            right: 1cm;
            height: 0px;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 1cm;
            left: 1cm;
            right: 1cm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', Helvetica, 'sans-serif';
            font-size: 16px;
            line-height: 1.4;
            color: #000;
            background: #fff;
            margin-top: 1.8cm;
            margin-bottom: 0px;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 50px;
        }

        .invoice-title {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            margin: 0;
        }

        .patient-info {
            margin-bottom: 25px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 3px 5px;
            vertical-align: top;
            font-size: 14px;
        }

        .info-label {
            width: 150px;
            font-weight: bold;
        }

        .services-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .services-table th,
        .services-table td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: left;
            font-size: 14px;
        }

        .services-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .total-section {
            margin-top: 20px;
            margin-bottom: 25px;
        }

        .total-table {
            width: 300px;
            margin-left: auto;
            border-collapse: collapse;
        }

        .total-table td {
            padding: 5px 10px;
            border-top: 1px solid #000;
            font-size: 14px;
        }

        .grand-total {
            font-size: 14px;
            font-weight: bold;
            border-top: 2px solid #000 !important;
        }

        .payment-info {
            margin-bottom: 25px;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .receipt-table th,
        .receipt-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            font-size: 14px;
        }

        .receipt-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .footer-info {
            margin-bottom: 20px;
        }

        .footer-box {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 15px;
        }

        .footer-text {
            font-size: 12px;
            line-height: 1.4;
        }

        .cashier-section {
            text-align: right;
            margin-bottom: 15px;
        }

        .signature-space {
            height: 50px;
            margin: 10px 0;
        }

        .signature-line {
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 10px;
        }

        .print-footer {
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 10px;
            font-size: 12px;
        }
    </style>
</head>

<body style="font-family: 'Nunito Sans', sans-serif;">
    <!--begin::Header-->
    <header>
        <table style="width:100%;border-bottom-width:5px;border-bottom-style:double">
            <tr style="vertical-align:baseline">
                <td style="width: 50%;vertical-align:top">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path(theme()->getMediaUrlPath() . 'logos/logo-klinik.png'))) }}"
                        style="height:50px;">
                </td>
                <td style="width: 50%; vertical-align:top">
                    <p style="margin:0px; margin-top:10px; font-size:12px;text-align: right;color:#000;">
                        {!! organizationInfo('full') !!}
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
        </table>
    </header>
    <!--end::Header-->

    <!--begin::Footer-->
    <footer>
        <table style="width:100%;border-top-width: 1px;border-top-style: solid">
            <tr>
                <td style="width:50%;text-align: left;vertical-align: top;height:120px">
                    <h2 style="margin:0px;text-transform: uppercase;font-size: 16px;font-weight: bold">WISHING YOU GOOD
                        HEALTH AND HAPPINESS</h2>
                    <p style="margin:0px;text-transform: uppercase;font-size: 14px;">SEMOGA SEHAT DAN BAHAGIA SELALU</p>
                </td>
                <td style="width:50%;text-align: right;vertical-align: bottom;float: right;height:100px">
                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path(theme()->getMediaUrlPath() . 'logos/qr.jpeg'))) }}"
                        style="height:100px;margin-right:5px;margin-top:5px">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path(theme()->getMediaUrlPath() . 'logos/logo-yayasan.png'))) }}"
                        style="height:85px;">
                </td>
            </tr>
        </table>
    </footer>
    <!--end::Footer-->

    <div class="container">
        <!-- Invoice Title -->
        <div class="invoice-title">INVOICE</div>

        <!-- Patient Info -->
        <div class="patient-info">
            <table class="info-table">
                <tr>
                    <td class="info-label">Registration No / MR</td>
                    <td>:</td>
                    <td class="fw-bold">{{ $examination->medical_record->medical_record_code }}</td>
                    <td class="info-label">Invoice No</td>
                    <td>:</td>
                    <td class="fw-bold">{{ $transaction->invoice_number }}</td>
                </tr>
                <tr>
                    <td class="info-label">Name</td>
                    <td>:</td>
                    <td class="fw-bold">{{ strtoupper($user->name) }}</td>
                    <td class="info-label">Invoice Date</td>
                    <td>:</td>
                    <td class="fw-bold">
                        {{ Carbon::parse($transaction->updated_at)->locale('id')->format('d F Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Address</td>
                    <td>:</td>
                    <td>{{ $info->address ?? 'N/A' }}</td>
                    <td class="info-label">Registration Date</td>
                    <td>:</td>
                    <td class="fw-bold">
                        {{ Carbon::parse($examination->created_at)->locale('id')->format('d F Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Patient Type</td>
                    <td>:</td>
                    <td>{{ $examination->jenis_pasien->nama ?? 'UMUM' }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="info-label">Primary Doctor</td>
                    <td>:</td>
                    <td style="text-tranform:capitalize">
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
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>

        <!-- Services Table -->
        <table class="services-table">
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th style="width: 60px;">Qty</th>
                    <th style="width: 60px;">UOM</th>
                    <th style="width: 100px;">Amount</th>
                    <th style="width: 60px;">Disc</th>
                    <th style="width: 100px;">Patient</th>
                </tr>
            </thead>
            <tbody>
                <!-- Consultation Section -->
                <tr>
                    <td colspan="8" class="fw-bold" style="background-color: #f0f0f0;">CONSULTATION AND VISIT</td>
                </tr>
                @php $no = 1; @endphp
                @foreach ($transaction_detail as $detail)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ strtoupper($detail->name) }}</td>
                        <td></td>
                        <td class="text-center">1</td>
                        <td class="text-center"></td>
                        <td class="text-right">{{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td class="text-center">0</td>
                        <td class="text-right">{{ number_format($detail->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                <!-- Drugs Section -->
                @php $total_resep = 0; @endphp
                @if ($examination->resep)
                    <tr>
                        <td colspan="8" class="fw-bold" style="background-color: #f0f0f0;">DRUGS</td>
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
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td>{{ strtoupper(getObat($value)->name) }}</td>
                                    <td>PHARMACY OPD 2ND FL</td>
                                    <td class="text-center">{{ $qty[$key] }}</td>
                                    <td class="text-center">{{ getObat($value)->unit?->name ?? 'TAB' }}</td>
                                    <td class="text-right">
                                        {{ number_format(getObat($value)->price * $qty[$key], 0, ',', '.') }}</td>
                                    <td class="text-center">0</td>
                                    <td class="text-right">
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

        <!-- Total Section -->
        <div class="total-section">
            <table class="total-table">
                <tr>
                    <td class="text-right fw-bold">SUB TOTAL :</td>
                    <td class="text-right fw-bold">
                        {{ number_format($transaction->amount + $total_resep, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="text-right fw-bold">ADMIN CHARGE :</td>
                    <td class="text-right fw-bold">0</td>
                </tr>
                <tr>
                    <td class="text-right fw-bold">ROUNDING :</td>
                    <td class="text-right fw-bold">0</td>
                </tr>
                <tr class="grand-total">
                    <td class="text-right fw-bold">TOTAL :</td>
                    <td class="text-right fw-bold">
                        {{ number_format($transaction->amount + $total_resep + 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="text-right fw-bold">PAYMENT :</td>
                    <td class="text-right fw-bold">
                        {{ number_format($transaction->amount + $total_resep + 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="text-right fw-bold">BALANCE :</td>
                    <td class="text-right fw-bold">0</td>
                </tr>
            </table>
        </div>

        <!-- Payment Info -->
        <div class="payment-info">
            <div class="fw-bold">IN WORDS PATIENT : {{ ucwords(terbilang($transaction->amount + $total_resep + 0)) }}
                rupiah</div>

            <div class="fw-bold" style="margin-top: 15px;">PATIENT RECEIPT / KUITANSI :</div>

            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Payment Mode</th>
                        <th>Cashier</th>
                        <th>Patient</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Payment</td>
                        <td>{{ Carbon::parse($transaction->created_at)->format('d/m/Y') }}</td>
                        <td>{{ ucwords($transaction->metode_pembayaran) }}</td>
                        <td>{{ $transaction->paymentConfirmationUser?->name ?? 'System' }}</td>
                        <td class="text-right">
                            {{ number_format($transaction->amount + $total_resep + 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="fw-bold text-right">TOTAL :</td>
                        <td class="fw-bold text-right">
                            {{ number_format($transaction->amount + $total_resep + 0, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer Info -->
        <div class="footer-info">
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <tr>
                    <td style="width: 60%; vertical-align: top; padding-right: 20px;">
                        <div class="footer-box">
                            <div class="footer-text">
                                <div class="mb-1"><strong>NPWP:</strong> 94.990.535.0-435.000</div>
                                <div class="mb-1"><strong>Catatan:</strong> Invoice ini berlaku sebagai faktur Pajak
                                    sesuai dengan Peraturan Direktur Jenderal Pajak No. 27/PJ/2011, Tanggal 18 September
                                    2011
                                </div>

                                <div class="mb-1">@include('partials.bank-accounts')</div>

                                <div class="contact-info">
                                    <div class="contact-item">
                                        <span class="contact-label">Reservasi Rawat Jalan:</span>
                                        <span class="contact-value">{{ organization()->phone }}</span>
                                        <span class="contact-hours">(Senin-Jumat 08.00-20.00)</span>
                                    </div>
                                    <div class="contact-item">
                                        <span class="contact-label">Weekend Clinic:</span>
                                        <span class="contact-value">Sabtu & Minggu</span>
                                        <span class="contact-hours">08.00-17.00</span>
                                    </div>
                                </div>
                            </div>

                            <style>
                                .contact-info {
                                    margin-top: 1rem;
                                }

                                .contact-item {
                                    margin-bottom: 0.5rem;
                                }

                                .contact-label {
                                    font-weight: 600;
                                    display: inline-block;
                                    width: 130px;
                                    vertical-align: top;
                                }

                                .contact-value {
                                    font-weight: 500;
                                    display: inline-block;
                                    margin-right: 0.5rem;
                                }

                                .contact-hours {
                                    color: #666;
                                    font-size: 0.9em;
                                    display: inline-block;
                                }

                                @media print {
                                    .contact-item {
                                        font-size: 8px;
                                        margin-bottom: 0.25rem;
                                    }

                                    .contact-label {
                                        width: 150px;
                                    }
                                }
                            </style>
                        </div>
                    </td>
                    <td style="width: 40%; vertical-align: top; text-align: right;">
                        <div class="cashier-section">
                            <div class="fw-bold" style="font-size: 10px; margin-bottom: 5px;">CASHIER</div>
                            <div class="signature-space"></div>
                            <div class="signature-line">
                                <div class="fw-bold" style="font-size: 9px;">
                                    {{ $transaction->paymentConfirmationUser?->name ?? ('Dr ' . $examination->health_profesional->user->name ?? 'System') }}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Print Footer -->
        <div class="print-footer">
            <div>Invoice ini merupakan bukti pembayaran yang sah</div>
            <div>Printed on {{ Carbon::now()->format('d-M-Y H:i') }} by {{ auth()->user()->name ?? 'System' }}</div>
            <div style="margin:10px auto;width:100px; padding:5px; border:1px solid black">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/invoice/' . $transaction->invoice_number . '.svg'))) }}"
                    alt="Logo Klinik" class="h-80px print-logo">
            </div>
        </div>
    </div>
</body>

</html>
