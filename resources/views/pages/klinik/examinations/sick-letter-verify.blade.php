<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst(theme()->getOption('meta', 'title')) }} | Verifikasi Surat Sakit - {{ $sick_letter_number }}
    </title>
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

        .sick-letter-details {
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
                    <div class="d-flex flex-column align-items-start text-left mb-3">
                        <img src="{{ asset('assets/media/logos/logo-klinik.png') }}" alt="Logo Klinik" class="mb-3"
                            style="height: 50px; width: auto;">
                        <div>
                            <div class="text-muted fs-7 text-capitalize" style="font-size: 12px;">
                                <div>{!! organizationInfo('full') !!}</div>
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
                            <h5 class="text-success">Surat Sakit Valid</h5>
                        </div>
                    @elseif($status === 'not_found')
                        <div class="text-danger">
                            <i class="fas fa-times-circle fa-3x mb-3"></i>
                            <h5 class="text-danger">Surat Sakit Tidak Ditemukan</h5>
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
                        <strong>Nomor Surat Sakit:</strong>
                    </div>
                    <div class="col-md-6">
                        {{ $sick_letter_number }}
                    </div>
                </div>

                @if ($status === 'valid')
                    <div class="sick-letter-details">
                        <h6 class="mb-3">Detail Surat Sakit</h6>

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
                            <div class="col-md-7">:
                                {{ (isset($examination->health_profesional->user->info) &&
                                !in_array($examination->health_profesional->user->info->title_prefix, ['', '-'])
                                    ? $examination->health_profesional->user->info->title_prefix . '. '
                                    : 'dr.') .
                                    $examination->health_profesional->user->name .
                                    (isset($examination->health_profesional->user->info) &&
                                    !in_array($examination->health_profesional->user->info->title_suffix, ['', '-'])
                                        ? ', ' . $examination->health_profesional->user->info->title_suffix
                                        : '') }}
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-5"><strong>Tanggal Pemeriksaan</strong></div>
                            <div class="col-md-7">:
                                {{ \Carbon\Carbon::parse($examination->examination_date)->format('d F Y') }}</div>
                        </div>

                        @if (isset($sick_letter_data->keterangan))
                            <div class="row mb-2">
                                <div class="col-md-5"><strong>Status Pasien</strong></div>
                                <div class="col-md-7">:
                                    @if ($sick_letter_data->keterangan == 1)
                                        <span class="badge bg-success">Dapat kembali bekerja</span>
                                    @elseif($sick_letter_data->keterangan == 2)
                                        <span class="badge bg-warning">Disarankan istirahat
                                            {{ $sick_letter_data->hari ?? '0' }} hari</span>
                                    @elseif($sick_letter_data->keterangan == 3)
                                        <span class="badge bg-info">Perlu kontrol kembali</span>
                                    @elseif($sick_letter_data->keterangan == 4)
                                        <span class="badge bg-danger">Perlu dirujuk ke RS</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if (isset($sick_letter_data->description) && $sick_letter_data->description)
                            <div class="row mb-2">
                                <div class="col-md-5"><strong>Keterangan</strong></div>
                                <div class="col-md-7">: {{ $sick_letter_data->description }}</div>
                            </div>
                        @endif
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
