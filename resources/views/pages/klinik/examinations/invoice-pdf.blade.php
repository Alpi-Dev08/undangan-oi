<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $transaction->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
            background: #fff;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }

        .logo {
            max-height: 60px;
            margin-bottom: 10px;
        }

        .clinic-info {
            margin-bottom: 15px;
        }

        .clinic-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .clinic-address {
            font-size: 10px;
            margin-bottom: 3px;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            margin-top: 15px;
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
        }

        .total-table {
            width: 300px;
            margin-left: auto;
            border-collapse: collapse;
        }

        .total-table td {
            padding: 5px 10px;
            border-top: 1px solid #000;
        }

        .grand-total {
            font-size: 14px;
            font-weight: bold;
            border-top: 2px solid #000 !important;
        }

        .payment-info {
            margin-top: 25px;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .receipt-table th,
        .receipt-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .receipt-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
        }

        .qr-code {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="clinic-info">
                <div class="clinic-name">{{ organizationInfo()->name ?? 'KLINIK DHARMA HUSADA' }}</div>
                <div class="clinic-address">{{ organizationInfo()->address ?? 'Alamat Klinik' }}</div>
                <div class="clinic-address">Telp: {{ organizationInfo()->phone ?? 'No. Telepon' }}</div>
                <div class="clinic-address">Email: {{ organizationInfo()->email ?? 'email@klinik.com' }}</div>
            </div>
            <div class="invoice-title">INVOICE</div>
        </div>

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
                    <td class="fw-bold">{{ \Carbon\Carbon::parse($transaction->created_at)->locale('id')->format('d F Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Address</td>
                    <td>:</td>
                    <td>{{ $info->address ?? 'N/A' }}</td>
                    <td class="info-label">Registration Date</td>
                    <td>:</td>
                    <td class="fw-bold">{{ \Carbon\Carbon::parse($examination->registration_date)->locale('id')->format('d F Y H:i') }}</td>
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
                    <td>Dr. {{ $examination->health_profesional->user->name ?? 'N/A' }}</td>
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

                <!-- Medicine Section -->
                @if(isset($total_resep) && $total_resep > 0)
                <tr>
                    <td colspan="8" class="fw-bold" style="background-color: #f0f0f0;">MEDICINE</td>
                </tr>
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>OBAT-OBATAN</td>
                    <td></td>
                    <td class="text-center">1</td>
                    <td class="text-center"></td>
                    <td class="text-right">{{ number_format($total_resep, 0, ',', '.') }}</td>
                    <td class="text-center">0</td>
                    <td class="text-right">{{ number_format($total_resep, 0, ',', '.') }}</td>
                </tr>
                @endif
            </tbody>
        </table>

        <!-- Total Section -->
        <div class="total-section">
            <table class="total-table">
                <tr>
                    <td class="text-right fw-bold">SUB TOTAL :</td>
                    <td class="text-right fw-bold">{{ number_format($transaction->amount + ($total_resep ?? 0), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="text-right fw-bold">DISCOUNT :</td>
                    <td class="text-right fw-bold">0</td>
                </tr>
                <tr>
                    <td class="text-right fw-bold">ROUNDING :</td>
                    <td class="text-right fw-bold">0</td>
                </tr>
                <tr class="grand-total">
                    <td class="text-right fw-bold">TOTAL :</td>
                    <td class="text-right fw-bold">{{ number_format($transaction->amount + ($total_resep ?? 0), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="text-right fw-bold">PAYMENT :</td>
                    <td class="text-right fw-bold">{{ number_format($transaction->amount + ($total_resep ?? 0), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="text-right fw-bold">BALANCE :</td>
                    <td class="text-right fw-bold">0</td>
                </tr>
            </table>
        </div>

        <!-- Payment Info -->
        <div class="payment-info">
            <div class="fw-bold">IN WORDS PATIENT : {{ ucwords(terbilang($transaction->amount + ($total_resep ?? 0))) }} rupiah</div>

            <div class="fw-bold" style="margin-top: 15px;">PATIENT RECEIPT / KUITANSI :</div>

            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>PAYMENT METHOD</th>
                        <th>CARD NUMBER</th>
                        <th>AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>CASH</td>
                        <td>-</td>
                        <td>{{ number_format($transaction->amount + ($total_resep ?? 0), 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih atas kunjungan Anda</p>
            <p>{{ organizationInfo()->name ?? 'KLINIK DHARMA HUSADA' }}</p>
        </div>
    </div>
</body>
</html>
