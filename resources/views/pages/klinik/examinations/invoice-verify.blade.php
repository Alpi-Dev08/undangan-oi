<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst(theme()->getOption('meta', 'title')) }} | Verifikasi Invoice - {{ $invoice_number }}</title>
    <link rel="shortcut icon" href="{{ asset('assets' . '/' . theme()->getOption('assets', 'favicon')) }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .verification-card {
            max-width: 600px;
            margin: 50px auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .status-valid {
            border-left: 5px solid #28a745;
        }

        .status-invalid {
            border-left: 5px solid #dc3545;
        }

        .status-error {
            border-left: 5px solid #ffc107;
        }

        .clinic-header {
            text-align: left;
            margin-bottom: 30px;
        }

        .clinic-header img {
            max-height: 80px;
            width: auto;
            object-fit: contain;
        }

        @media (max-width: 576px) {
            .clinic-header .d-flex {
                flex-direction: column;
            }

            .clinic-header img {
                margin-bottom: 15px;
                margin-right: 0 !important;
            }
        }

        .invoice-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container">
        <div
            class="verification-card card
            @if ($status === 'valid') status-valid
            @elseif($status === 'not_found') status-invalid
            @else status-error @endif">

            <div class="card-header bg-white">
                <div class="clinic-header">
                    <div class="d-flex align-items-start mb-3">
                        <img src="{{ asset('assets/media/logos/ikon-klinik.png') }}" alt="Logo Klinik" class="me-3"
                            style="height: 60px; width: auto;">
                        <div>
                            <h4 class="mb-1">{{ organization()->name ?? 'Klinik Dharma Medika' }}</h4>
                            <div class="text-muted fs-7 lh-lg text-capitalize">
                                <div>{{ organization()->address }},<br> {{ Str::lower(organization()->city->name) }}
                                    {{ organization()->province->name }} {{ organization()->postal_code }},
                                    {{ organization()->country->name }}</div>
                                <div>Telp. {{ organization()->phone }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="text-center mb-4">
                    @if ($status === 'valid')
                        <div class="text-success">
                            <i class="fas fa-check-circle fa-3x mb-3"></i>
                            <h5 class="text-success">Invoice Valid</h5>
                        </div>
                    @elseif($status === 'not_found')
                        <div class="text-danger">
                            <i class="fas fa-times-circle fa-3x mb-3"></i>
                            <h5 class="text-danger">Invoice Tidak Ditemukan</h5>
                        </div>
                    @else
                        <div class="text-warning">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                            <h5 class="text-warning">Terjadi Kesalahan</h5>
                        </div>
                    @endif
                </div>

                <div class="alert
                    @if ($status === 'valid') alert-success
                    @elseif($status === 'not_found') alert-danger
                    @else alert-warning @endif"
                    role="alert">
                    <strong>Status:</strong> {{ $message }}
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong>Nomor Invoice:</strong>
                    </div>
                    <div class="col-md-6">
                        {{ $invoice_number }}
                    </div>
                </div>

                @if ($status === 'valid')
                    <div class="invoice-details">
                        <h6 class="mb-3">Detail Invoice</h6>

                        <div class="row mb-2">
                            <div class="col-md-5"><strong>Nama Pasien</strong></div>
                            <div class="col-md-7">: {{ $user->name }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-5"><strong>No. Medical Record</strong></div>
                            <div class="col-md-7">: {{ $examination->medical_record->medical_record_code }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-5"><strong>Dokter Pemeriksa</strong></div>
                            <div class="col-md-7">: Dr.
                                {{ $examination->health_profesional->user->name .
                                    (isset($examination->health_profesional->user->info) &&
                                    !in_array($examination->health_profesional->user->info->title_prefix, ['', '-'])
                                        ? $examination->health_profesional->user->info->title_prefix . '. '
                                        : '') .
                                    (isset($examination->health_profesional->user->info) &&
                                    !in_array($examination->health_profesional->user->info->title_suffix, ['', '-'])
                                        ? ', ' . $examination->health_profesional->user->info->title_suffix
                                        : '') }}
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-5"><strong>Tanggal Invoice</strong></div>
                            <div class="col-md-7">:
                                {{ \Carbon\Carbon::parse($transaction->created_at)->format('d F Y H:i') }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-5"><strong>Status Pembayaran</strong></div>
                            <div class="col-md-7">:
                                <span
                                    class="badge
                                    @if ($transaction->status === 'paid') bg-success
                                    @elseif($transaction->status === 'waiting payment') bg-warning
                                    @else bg-secondary @endif">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-5"><strong>Total Amount</strong></div>
                            <div class="col-md-7">
                                <strong>: Rp
                                    {{ number_format($transaction->amount + $total_resep, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-5"><strong>Metode Pembayaran</strong></div>
                            <div class="col-md-7">:
                                {{ ucwords($transaction->metode_pembayaran ?? 'Belum ditentukan') }}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="text-center mt-4">
                    <small class="text-muted">
                        Verifikasi dilakukan pada {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
</body>

</html>
