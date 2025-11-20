@php use Carbon\Carbon; @endphp
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
            margin: 0.5cm 0.5cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 6.5cm;

        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
        }

        body {
            margin-top: 6cm;
            margin-bottom: 120px;
        }
    </style>


    <title>Rekam Medis {{ $user->name }}</title>
</head>

<body style="font-family: 'Nunito Sans', sans-serif;">
    <!--begin::Text-->
    <header>
        <table style="width:100%;border-bottom-width:5px;border-bottom-style:double">
            <tr style="vertical-align:baseline">
                <td style="width: 50%;vertical-align:top">

                    <img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/logo-klinik.png') }}"
                        style="height:50px;">
                </td>
                <td style="width: 50%; vertical-align:top">
                    <p style="margin:0px; margin-top:10px; font-size:12px;text-align: right;color:#000;">
                        {!! organizationInfo('full') !!}
                    </p>
                </td>
            </tr>
        </table>
        <table style="width:100%;border-bottom-width:2px;border-bottom-style:solid">
            <tr style="vertical-align:baseline">
                <td colspan="2" style="width: 100%;text-align:center">
                    <p
                        style="margin:0px;font-size:22px;text-align:center;color:gray;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;">
                        Medical Record</p>
                </td>
            </tr>
        </table>
        <table style="width:100%;font-size:10px;">
            <tr>
                <td style="width:17%;font-size:12px;font-weight:bold">Full Name
                <td>
                <td style="width:35%;font-size:12px;">
                    :
                    {{ $user->name }}{{ $user->info && !in_array($user->info->title_prefix, ['', '-']) ? '. ' . $user->info->title_prefix : '' }}{{ $user->info && !in_array($user->info->title_suffix, ['', '-']) ? ', ' . $user->info->title_suffix : '' }}
                <td>
                <td style="width:18%;font-size:12px;font-weight:bold">MR No
                <td>
                <td style="width:30%;font-size:12px;">: {{ $user->mr->medical_record_code }}
                <td>
            </tr>
            <tr>
                <td style="width:17%;font-size:12px;font-weight:bold">Gender
                <td>
                <td style="width:35%;font-size:12px;">: {{ $user->info->gender->name ?? '-' }}
                <td>
                <td style="width:18%;font-size:12px;font-weight:bold">Examination Date
                <td>
                <td style="width:30%;font-size:12px;">
                    : {{ Carbon::parse($examination->created_at)->locale('id')->format('d F Y H:i:s') }}
                <td>
            </tr>
            <tr>
                <td style="width:17%;font-size:12px;font-weight:bold">Birth Date / Age
                <td>
                <td style="width:35%;font-size:12px;">
                    : {{ Carbon::parse($user->info->date_of_birth)->locale('id')->format('d F Y') }}
                    /
                    {{ Carbon::createFromDate($user->info->date_of_birth)->diff(Carbon::now())->format('%y Tahun %m Bulan %d Hari') }}
                <td>
                <td style="width:18%;font-size:12px;font-weight:bold">Doctor
                <td>
                <td style="width:30%;font-size:12px;">
                    :
                    {{ $examination->health_profesional->user->name .
                        ($examination->health_profesional->user->info &&
                        !in_array($examination->health_profesional->user->info->title_prefix, ['', '-'])
                            ? '. ' . $examination->health_profesional->user->info->title_prefix
                            : '') .
                        ($examination->health_profesional->user->info &&
                        !in_array($examination->health_profesional->user->info->title_suffix, ['', '-'])
                            ? ', ' . $examination->health_profesional->user->info->title_suffix
                            : '') }}
                <td>
            </tr>
            <tr>
                <td style="width:17%;font-size:12px;vertical-align:top;font-weight:bold">Phone
                <td>
                <td style="width:35%;font-size:12px;vertical-align:top">: {{ $user->phone }}
                <td>
                <td style="width:18%;font-size:12px;font-weight:bold;vertical-align:top">Service Type
                <td>
                <td style="width:30%;font-size:12px;">: {{ $examination->service_category->name }} </td>
            </tr>{{--
        <tr>
            <td style="width:20%;font-size:12px;font-weight:bold;vertical-align:top">Address<td>
            <td style="width:30%;font-size:12px;vertical-align:top">: {{ $user->info->address }}{{ isset($user->info->subdistrict) ? ', '.$user->info->subdistrict->name : '' }}{{ isset($user->info->district) ? ', '.$user->info->district->name : '' }}{{ isset($user->info->city) ? ', '.$user->info->city->name : '' }}{{ isset($user->info->province) ? ', '.$user->info->province->name : '' }}{{ isset($user->info->country) ? ', '.$user->info->country->name : '' }}{{ $user->info->postal_code!='' ? $user->info->postal_code : (isset($user->info->subdistrict) ? ' - '.$user->info->subdistrict->postal_code : '') }}<td>
            <td style="width:20%;font-size:12px;font-weight:bold;vertical-align:top"><td>
            <td style="width:30%;font-size:12px;vertical-align:top">
                <ul class="list-disc" style="margin:0px; padding-left:20px;">
                    @foreach (service_examination($examination->id) as $service)
                        <li style="margin:0px;">{{ $service->service->name }}</li>
                    @endforeach
                </ul>
            </td>
        </tr> --}}
        </table>
        <table
            style="margin-top:10px;width:100%;font-size:12px;border-bottom-style: double;border-top-style: double;border-top-width: 3px;border-bottom-width: 3px;">
            <tr>
                <td style="font-weight:bolder;width:35%">Jenis Pemeriksaan</td>
                <td style="font-weight:bolder;width:65%">Hasil</td>
            </tr>
        </table>
    </header>
    <footer>
        <table style="width:100%;border-top-width: 1px;border-top-style: solid">
            <tr>
                <td style="width:50%;text-align: left;vertical-align: top;height:100px">
                    <h2 style="margin:0px;text-transform: uppercase;font-size: 16px;font-weight: bold">WISHING YOU GOOD
                        HEALTH AND HAPPINESS</h2>
                    <p style="margin:0px;text-transform: uppercase;font-size: 14px;">SEMOGA SEHAT DAN BAHAGIA SELALU</p>
                </td>
                <td style="width:50%;text-align: right;vertical-align: bottom;float: right;height:100px">
                    <img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/qr.jpeg') }}"
                        style="height:85px;margin-right:5px;"><img
                        src="{{ public_path(theme()->getMediaUrlPath() . 'logos/logo-yayasan.png') }}"
                        style="height:75px;">
                </td>
            </tr>
        </table>
    </footer>
    <main>
        <div>
            <h4
                style="font-weight: bolder;color:#436ba4;font-size:12px;margin:0px;margin-top:10px;text-transform: uppercase">
                Vital Sign & BMI</h4>
            <table style="width:100%;font-size:12px;">
                <tr>
                    <td style="font-size:12px;width:35%;padding-left:10px">Weight</td>
                    <td style="font-size:12px;width:65%">{{ $examination->vitality->weight ?? '-' }} Kg</td>
                </tr>
                <tr>
                    <td style="font-size:12px;width:35%;padding-left:10px">Height</td>
                    <td style="font-size:12px;width:65%">{{ $examination->vitality->height ?? '-' }} cm</td>
                </tr>
                <tr>
                    <td style="font-size:12px;width:35%;padding-left:10px">Blood Pressure</td>
                    <td style="font-size:12px;width:65%">{{ $examination->vitality->blood_pressure ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-size:12px;width:35%;padding-left:10px">Heart Rate</td>
                    <td style="font-size:12px;width:65%">{{ $examination->vitality->heart_rate ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-size:12px;width:35%;padding-left:10px">Respiratory Rate</td>
                    <td style="font-size:12px;width:65%">{{ $examination->vitality->respiratory_rate ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-size:12px;width:35%;padding-left:10px">Temperature</td>
                    <td style="font-size:12px;width:65%">{{ $examination->vitality->temperature ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-size:12px;width:35%;padding-left:10px">Oxygen Saturation</td>
                    <td style="font-size:12px;width:65%">{{ $examination->vitality->oxygen_saturation ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-size:12px;width:35%;padding-left:10px">Body Mass Index</td>
                    <td style="font-size:12px;width:65%">{{ $examination->vitality->body_mass_index ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-size:12px;width:35%;padding-left:10px">Ideal Weight</td>
                    <td style="font-size:12px;width:65%">{{ $examination->vitality->ideal_weight ?? '-' }} Kg</td>
                </tr>
                <tr>
                    <td style="font-size:12px;width:35%;padding-left:10px">BMI Conclusion</td>
                    <td style="font-size:12px;width:65%">{{ $examination->vitality->bmi_conclusion ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-size:12px;width:35%;padding-left:10px">Abdominal Circumference</td>
                    <td style="font-size:12px;width:65%">{{ $examination->vitality->adbdominal_circumference ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-size:12px;width:35%;padding-left:10px">Arm Circumference</td>
                    <td style="font-size:12px;width:65%">{{ $examination->vitality->arm_circumference ?? '-' }}</td>
                </tr>
            </table>
            <hr class="mt-10">
            @if ($examination->psikososial)
                @php
                    $psikososial = json_decode($examination->psikososial);
                @endphp
                <h4
                    style="font-weight: bolder;color:#436ba4;font-size:12px;margin:0px;margin-top:10px;text-transform: uppercase">
                    Kebutuhan Khusus</h4>
                @if (isset($psikososial->khusus))
                    @if ($psikososial->khusus)
                        <table style="width:100%;font-size:12px;">
                            <tr>
                                <td style="font-size:12px;width:35%;padding-left:10px" colspan="2">
                                    {{ ucwords($psikososial->khusus) }}</td>
                            </tr>
                        </table>
                    @endif
                @endif
                <h4
                    style="font-weight: bolder;color:#436ba4;font-size:12px;margin:0px;margin-top:10px;text-transform: uppercase">
                    Data Psikologi dan Sosial</h4>
                <table style="width:100%;font-size:12px;">
                    <tr>
                        <td style="font-size:12px;width:35%;padding-left:10px">Bicara</td>
                        <td style="font-size:12px;width:65%">
                            {{ !isset($psikososial->bicara) ? ucwords($psikososial->bicara) : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:12px;width:35%;padding-left:10px">Komunikasi</td>
                        <td style="font-size:12px;width:65%">
                            {{ !isset($psikososial->komunikasi) ? ucwords($psikososial->komunikasi) : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:12px;width:35%;padding-left:10px">Status Emosional</td>
                        <td style="font-size:12px;width:65%">
                            {{ !isset($psikososial->emosional) ? ucwords($psikososial->emosional) : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:12px;width:35%;padding-left:10px">Sosiologi</td>
                        <td style="font-size:12px;width:65%">
                            {{ !isset($psikososial->sosiologi) ? ucwords($psikososial->sosiologi) : '-' }}</td>
                    </tr>
                </table>

                @if (isset($psikososial->pola_kebiasaan))
                    <h4
                        style="font-weight: bolder;color:#436ba4;font-size:12px;margin:0px;margin-top:10px;text-transform: uppercase">
                        Pola Kebiasaan</h4>
                    <table style="width:100%;font-size:12px;">
                        @foreach ($psikososial->pola_kebiasaan as $key => $value)
                            <tr>
                                <td style="font-size:12px;width:35%;padding-left:10px">{{ ucwords($key) }}</td>
                                <td style="font-size:12px;width:65%">{{ ucwords($value) ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
                @if (isset($psikososial->riwayat_pekerjaan))
                    <h4
                        style="font-weight: bolder;color:#436ba4;font-size:12px;margin:0px;margin-top:10px;text-transform: uppercase">
                        Riwayat Pekerjaan</h4>
                    <table style="width:100%;font-size:12px;">
                        @foreach ($psikososial->riwayat_pekerjaan as $key => $value)
                            <tr>
                                <td style="font-size:12px;width:35%;padding-left:10px">
                                    {{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                <td style="font-size:12px;width:65%">{{ ucwords($value) ?? '-' }}</td>
                            </tr>
                            @if ($key == 'zat_bahaya' && $value == 'Ya')
                                <tr>
                                    <td style="font-size:12px;width:35%;padding-left:10px">Jenis Zat Bahaya</td>
                                    <td style="font-size:12px;width:65%">
                                        {{ ucwords($psikososial->riwayat_pekerjaan_bahaya) ?? '-' }}</td>
                                </tr>
                            @elseif($key == 'berpergian' && $value == 'Ya')
                                <tr>
                                    <td style="font-size:12px;width:35%;padding-left:10px">Tujuan Perjalanan</td>
                                    <td style="font-size:12px;width:65%">
                                        {{ ucwords($psikososial->riwayat_pekerjaan_berpergian) ?? '-' }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                @endif
                @if (isset($psikososial->riwayat_kesehatan))
                    <h4
                        style="font-weight: bolder;color:#436ba4;font-size:12px;margin:0px;margin-top:10px;text-transform: uppercase">
                        Riwayat Kesehatan</h4>
                    <table style="width:100%;font-size:12px;">
                        @foreach ($psikososial->riwayat_kesehatan as $key => $value)
                            @if ($key == 'alergi_obat' && $value == 'Ada')
                                <tr>
                                    <td style="font-size:12px;width:35%;padding-left:10px">Alergi Obat</td>
                                    <td style="font-size:12px;width:65%">
                                        {{ ucwords($psikososial->riwayat_alergi_obat) ?? '-' }}</td>
                                </tr>
                            @elseif($key == 'alergi_makanan' && $value == 'Ada')
                                <tr>
                                    <td style="font-size:12px;width:35%;padding-left:10px">Makanan Alergi</td>
                                    <td style="font-size:12px;width:65%">
                                        {{ ucwords($psikososial->riwayat_alergi_makanan) ?? '-' }}</td>
                                </tr>
                            @elseif($key == 'penyakit_dahulu' && $value !== 'Lain-lain')
                                <tr>
                                    <td style="font-size:12px;width:35%;padding-left:10px">Penyakit Dahulu</td>
                                    <td style="font-size:12px;width:65%">
                                        @if (is_array($value))
                                            @php
                                                $diseases = \App\Models\Klinik\PersonalDiseaseHistory::whereIn(
                                                    'code',
                                                    $value,
                                                )
                                                    ->pluck('name')
                                                    ->toArray();
                                                echo implode(', ', $diseases);
                                            @endphp
                                        @else
                                            {{ ucwords($value) ?? '-' }}
                                        @endif
                                    </td>
                                </tr>
                            @elseif($key == 'penyakit_dahulu' && $value == 'Lain-lain')
                                <tr>
                                    <td style="font-size:12px;width:35%;padding-left:10px">Penyakit Dahulu</td>
                                    <td style="font-size:12px;width:65%">
                                        {{ ucwords($psikososial->riwayat_penyakit_dahulu) ?? '-' }}
                                    </td>
                                </tr>
                            @elseif($key == 'penyakit_keluarga' && $value !== 'Lain-lain')
                                <tr>
                                    <td style="font-size:12px;width:35%;padding-left:10px">Penyakit Keluarga</td>
                                    <td style="font-size:12px;width:65%">
                                        @if (is_array($value))
                                            @php
                                                $diseases = \App\Models\Klinik\FamilyDiseaseHistory::whereIn(
                                                    'code',
                                                    $value,
                                                )
                                                    ->pluck('name')
                                                    ->toArray();
                                                echo implode(', ', $diseases);
                                            @endphp
                                        @else
                                            {{ ucwords($value) ?? '-' }}
                                        @endif
                                    </td>
                                </tr>
                            @elseif($key == 'penyakit_keluarga' && $value == 'Lain-lain')
                                <tr>
                                    <td style="font-size:12px;width:35%;padding-left:10px">Penyakit Keluarga</td>
                                    <td style="font-size:12px;width:65%">
                                        {{ ucwords($psikososial->riwayat_penyakit_keluarga) ?? '-' }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td style="font-size:12px;width:35%;padding-left:10px">
                                        {{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                    <td style="font-size:12px;width:65%">{{ ucwords($value) ?? '-' }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                @endif
                <hr class="mt-10">
            @endif
            @if ($examination->service_category->is_mcu == 1)

                <h4
                    style="margin-bottom:0px;font-weight: bolder;color:#436ba4;font-size:12px;margin:0px;margin-top:10px;text-transform: uppercase">
                    Check up Result</h4>
                @if (isset($examination->anamnesis->anamnesis_value))
                    <h3 style="margin-bottom:0px;font-weight: bold;font-size:12px;">1. Anamnesis</h3>
                    @php
                        $anamnesis = json_decode($examination->anamnesis->anamnesis_value);
                        $header = '';
                    @endphp
                    <table style="width:100%;font-size:12px;">
                        <tr>
                            <td colspan="2" style="padding-left:15px;font-weight:bold">Present Complaint / Keluhan
                                Saat
                                Ini
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-left:15px;">{{ $examination->anamnesis->request }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-left:15px;font-weight:bold">&nbsp;</td>
                        </tr>
                        @foreach ($anamnesis as $key => $value)
                            @php
                                $radio = '';
                                if (isset($value->radio)) {
                                    $radio = json_decode(json_encode($value->radio), true);
                                    $radioKeys = array_keys($radio);
                                }
                                $additional = json_decode(json_encode($value->additional), true);
                                $additionalKeys = array_keys($additional);
                            @endphp

                            @if ($radio && $additional[$additionalKeys[0]])
                                @if ($header != getAnamnesis($key)->anamnesis_category_id)
                                    <tr>
                                        <td colspan="2" style="padding-left:15px;font-weight:bold">
                                            {{ getAnamnesisCategory(getAnamnesis($key)->anamnesis_category_id)->name }}
                                        </td>
                                    </tr>
                                    @php $header = getAnamnesis($key)->anamnesis_category_id; @endphp
                                @endif
                                <tr>
                                    <td style="width:35%;padding-left:15px;">{{ getAnamnesis($key)->name }}</td>
                                    <td style="width:65%;">
                                        : {{ ucwords($radio[$radioKeys[0]]) . ', ' . $additional[$additionalKeys[0]] }}
                                    </td>
                                </tr>
                            @elseif($radio)
                                @if ($header != getAnamnesis($key)->anamnesis_category_id)
                                    <tr>
                                        <td colspan="2" style="padding-left:15px;font-weight:bold">
                                            {{ getAnamnesisCategory(getAnamnesis($key)->anamnesis_category_id)->name }}
                                        </td>
                                    </tr>
                                    @php $header = getAnamnesis($key)->anamnesis_category_id; @endphp
                                @endif
                                <tr>
                                    <td style="width:35%;padding-left:15px;">{{ getAnamnesis($key)->name }}</td>
                                    <td style="width:65%;">: {{ ucwords($radio[$radioKeys[0]]) }}</td>
                                </tr>
                            @elseif($additional[$additionalKeys[0]])
                                @if ($header != getAnamnesis($key)->anamnesis_category_id)
                                    <tr>
                                        <td colspan="2" style="padding-left:15px;font-weight:bold">
                                            {{ getAnamnesisCategory(getAnamnesis($key)->anamnesis_category_id)->name }}
                                        </td>
                                    </tr>
                                    @php $header = getAnamnesis($key)->anamnesis_category_id; @endphp
                                @endif
                                <tr>
                                    <td style="width:35%;padding-left:15px;">{{ getAnamnesis($key)->name }}</td>
                                    <td style="width:65%;">: {{ $additional[$additionalKeys[0]] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                @endif
                @if (isset($examination->physical->physical_value))
                    <h3 style="margin-bottom:0px;font-weight: bold;font-size:12px;">2. Physical</h3>
                    <table style="width:100%;font-size:12px;">
                        @php
                            $physicals = json_decode($examination->physical->physical_value);
                            $header = '';
                        @endphp
                        @foreach ($physicals as $key => $value)
                            @php
                                $radio = '';
                                if (isset($value->radio)) {
                                    $radio = json_decode(json_encode($value->radio), true);
                                    $radioKeys = array_keys($radio);
                                }
                                $additional = json_decode(json_encode($value->additional), true);
                                $additionalKeys = array_keys($additional);
                            @endphp

                            @if ($radio && $additional[$additionalKeys[0]])
                                @if ($header != getPhysicals($key)->physical_category_id)
                                    <tr>
                                        <td colspan="2" style="padding-left:15px;font-weight:bold">
                                            {{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}
                                        </td>
                                    </tr>
                                    @php $header = getPhysicals($key)->physical_category_id; @endphp
                                @endif
                                <tr>
                                    <td style="width:35%;padding-left:15px;">{{ getPhysicals($key)->name }}</td>
                                    <td style="width:65%;">
                                        : {{ ucwords($radio[$radioKeys[0]]) . ', ' . $additional[$additionalKeys[0]] }}
                                    </td>
                                </tr>
                            @elseif($radio)
                                @if ($header != getPhysicals($key)->physical_category_id)
                                    <tr>
                                        <td colspan="2" style="padding-left:15px;font-weight:bold">
                                            {{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}
                                        </td>
                                    </tr>
                                    @php $header = getPhysicals($key)->physical_category_id; @endphp
                                @endif
                                <tr>
                                    <td style="width:35%;padding-left:15px;">{{ getPhysicals($key)->name }}</td>
                                    <td style="width:65%;">: {{ ucwords($radio[$radioKeys[0]]) }}</td>
                                </tr>
                            @elseif($additional[$additionalKeys[0]])
                                @if ($header != getPhysicals($key)->physical_category_id)
                                    <tr>
                                        <td colspan="2" style="padding-left:15px;font-weight:bold">
                                            {{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}
                                        </td>
                                    </tr>
                                    @php $header = getPhysicals($key)->physical_category_id; @endphp
                                @endif
                                <tr>
                                    <td style="width:35%;padding-left:15px;">{{ getPhysicals($key)->name }}</td>
                                    <td style="width:65%;">: {{ $additional[$additionalKeys[0]] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                @endif
                @if (isset($examination->other->other_value))
                    <h3 style="margin-bottom:0px;font-weight: bold;font-size:12px;">3. Other</h3>
                    <table style="width:100%;font-size:12px;">
                        @php
                            $others = json_decode($examination->other->other_value);
                            $header = '';
                        @endphp
                        @foreach ($others as $key => $value)
                            @php
                                $radio = '';
                                if (isset($value->radio)) {
                                    $radio = json_decode(json_encode($value->radio), true);
                                    $radioKeys = array_keys($radio);
                                }
                                $additional = json_decode(json_encode($value->additional), true);
                                $additionalKeys = array_keys($additional);
                            @endphp

                            @if ($header != getPhysicals($key)->physical_category_id)
                                <tr>
                                    <td style="width:35%;padding-left:15px;" colspan="2">
                                        {{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</td>
                                    @php $header = getPhysicals($key)->physical_category_id; @endphp
                                </tr>
                            @endif

                            @if ($radio && $additional[$additionalKeys[0]])
                                <tr>
                                    <td style="width:35%;padding-left:15px;">{{ getPhysicals($key)->name }}</td>
                                    <td style="width:65%;">
                                        : {{ ucwords($radio[$radioKeys[0]]) . ', ' . $additional[$additionalKeys[0]] }}
                                    </td>
                                </tr>
                            @elseif($radio)
                                <tr>
                                    <td style="width:35%;padding-left:15px;">{{ getPhysicals($key)->name }}</td>
                                    <td style="width:65%;">: {{ ucwords($radio[$radioKeys[0]]) }}</td>
                                </tr>
                            @elseif($additional[$additionalKeys[0]])
                                <tr>
                                    <td style="width:35%;padding-left:15px;">{{ getPhysicals($key)->name }}</td>
                                    <td style="width:65%;">: {{ $additional[$additionalKeys[0]] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                @endif
                @if (isset($examination->additional->additional_value))
                    <h3 style="margin-bottom:0px;font-weight: bold;font-size:12px;">4. Additional Examination</h3>
                    <table style="width:100%;font-size:12px;">
                        @php
                            $additionals = json_decode($examination->additional->additional_value);
                            $header = '';
                        @endphp
                        @foreach ($additionals as $key => $value)
                            @php
                                $additional = json_decode(json_encode($value->additional), true);
                                $additionalKeys = array_keys($additional);
                            @endphp

                            @if ($additional[$additionalKeys[0]])
                                @if ($header != getAdditional($key)->additionals_category_id)
                                    <tr>
                                        <td style="width:35%;padding-left:15px;font-weight:bold;padding-top:10px"
                                            colspan="2">
                                            {{ getAdditionalCategory(getAdditional($key)->additionals_category_id)->name }}
                                        </td>
                                        @php $header = getAdditional($key)->additionals_category_id; @endphp
                                    </tr>
                                @endif
                                <tr>
                                    <td style="width:35%;padding-left:15px;">{{ getAdditional($key)->name }}</td>
                                    <td style="width:65%;">: {{ $additional[$additionalKeys[0]] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                @endif
            @else
                <h4
                    style="font-weight: bolder;color:#436ba4;font-size:12px;margin:0px;margin-top:10px;text-transform: uppercase">
                    Result</h4>
                <table style="width:100%;font-size: 12px;padding-left:10px">
                    <tr>
                        <td style="font-weight:bold">Subjective</td>
                    </tr>
                    <tr>
                        <td>{{ $examination->subjective }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold">Objective</td>
                    </tr>
                    <tr>
                        <td>{{ $examination->objective }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold">Assessment</td>
                    </tr>
                    <tr>
                        <td>
                            @php
                                $assessments = explode('|', $examination->assessment);
                            @endphp
                            @foreach ($assessments as $assessment)
                                @if (!empty($assessment))
                                    <p style="margin:0px;">{{ $assessment }}</p>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold">Plan</td>
                    </tr>
                    <tr>
                        <td>{{ $examination->plan->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold">Resep</td>
                    </tr>
                    <tr>
                        <td>
                            @php
                                // Coba tampilkan data prescription terbaru bila tersedia
                                $activePrescription = null;
                                if (method_exists($examination, 'prescriptions')) {
                                    try {
                                        $activePrescription = $examination->prescriptions()
                                            ->with(['items.drug'])
                                            ->orderByDesc('resep_date')
                                            ->first();
                                    } catch (\Throwable $e) {
                                        $activePrescription = null;
                                    }
                                }
                            @endphp

                            @if ($activePrescription && $activePrescription->items && $activePrescription->items->count())
                                @if ($activePrescription->resep_date || !empty($activePrescription->catatan_umum))
                                    <p style="margin:0px;">
                                        @if ($activePrescription->resep_date)
                                            Tanggal Resep: {{ \Carbon\Carbon::parse($activePrescription->resep_date)->format('d/m/Y') }}
                                        @endif
                                        @if (!empty($activePrescription->catatan_umum))
                                            @if ($activePrescription->resep_date) — @endif
                                            Catatan: {{ $activePrescription->catatan_umum }}
                                        @endif
                                    </p>
                                @endif

                                <table style="width:100%; border-collapse: collapse; font-size:12px; margin-top:6px;">
                                    <thead>
                                        <tr>
                                            <th style="border:1px solid #000; padding:4px; text-align:left;">Nama Obat</th>
                                            <th style="border:1px solid #000; padding:4px; text-align:left;">Dosis</th>
                                            <th style="border:1px solid #000; padding:4px; text-align:left;">Aturan Pakai</th>
                                            <th style="border:1px solid #000; padding:4px; text-align:left;">Jumlah</th>
                                            <th style="border:1px solid #000; padding:4px; text-align:left;">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activePrescription->items as $item)
                                            <tr>
                                                <td style="border:1px solid #000; padding:4px;">
                                                    {{ $item->drug_name ?? data_get($item->drug, 'name') ?? $item->kfa_code }}
                                                </td>
                                                <td style="border:1px solid #000; padding:4px;">{{ $item->dosis ?: '-' }}</td>
                                                <td style="border:1px solid #000; padding:4px;">{{ $item->aturan_pakai ?: '-' }}</td>
                                                <td style="border:1px solid #000; padding:4px;">{{ !empty($item->qty) ? ($item->qty . ' ' . ($item->unit ?: '')) : '-' }}</td>
                                                <td style="border:1px solid #000; padding:4px;">{{ $item->keterangan ?: '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                @php
                                    // Fallback: dukung data lama yang disimpan di $examination->resep
                                    $resepRaw = $examination->resep ?? null;
                                    $resepData = is_array($resepRaw)
                                        ? (object) $resepRaw
                                        : (is_string($resepRaw)
                                            ? json_decode($resepRaw ?: '{}', false)
                                            : null);

                                    $obat = data_get($resepData, 'obat', []);
                                    $keterangan = data_get($resepData, 'keterangan', []);
                                    $qty = data_get($resepData, 'qty', []);
                                @endphp

                                @if (!empty($obat))
                                    <table style="width:100%; border-collapse: collapse; font-size:12px; margin-top:6px;">
                                        <thead>
                                            <tr>
                                                <th style="border:1px solid #000; padding:4px; text-align:left;">Nama Obat</th>
                                                <th style="border:1px solid #000; padding:4px; text-align:left;">Dosis</th>
                                                <th style="border:1px solid #000; padding:4px; text-align:left;">Aturan Pakai</th>
                                                <th style="border:1px solid #000; padding:4px; text-align:left;">Jumlah</th>
                                                <th style="border:1px solid #000; padding:4px; text-align:left;">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($obat as $key => $value)
                                                @php $drug = getObat($value); @endphp
                                                @if (isset($drug->name))
                                                    <tr>
                                                        <td style="border:1px solid #000; padding:4px;">{{ $drug->name }}</td>
                                                        <td style="border:1px solid #000; padding:4px;">-</td>
                                                        <td style="border:1px solid #000; padding:4px;">-</td>
                                                        <td style="border:1px solid #000; padding:4px;">{{ isset($qty[$key]) && $qty[$key] !== '' ? $qty[$key] : '-' }}</td>
                                                        <td style="border:1px solid #000; padding:4px;">{{ isset($keterangan[$key]) && $keterangan[$key] !== '' ? $keterangan[$key] : '-' }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p style="margin:0px;">-</p>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @if ($examination->service_category_id == 17)
                        <tr>
                            <td>
                                <table style="width:100%; margin-top:20px;">
                                    <tr>
                                        <td colspan="3" style="font-weight:bold; text-align:center;">ODONTOGRAM
                                        </td>
                                    </tr>
                                    <tr style="page-break-inside: avoid;">
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 18"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 18</p>
                                            <p style="margin: 0;">Kode: {{ $examination->odontogram_symbol_18 ?? '' }}
                                            </p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_18 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 17"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 17</p>
                                            <p style="margin: 0;">Kode: {{ $examination->odontogram_symbol_17 ?? '' }}
                                            </p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_17 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 16"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 16</p>
                                            <p style="margin: 0;">Kode: {{ $examination->odontogram_symbol_16 ?? '' }}
                                            </p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_16 ?? '' }}</p>
                                        </td>
                                    </tr>
                                    <tr style="page-break-inside: avoid;">
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 15"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 15</p>
                                            <p style="margin: 0;">Kode: {{ $examination->odontogram_symbol_15 ?? '' }}
                                            </p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_15 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 14"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 14</p>
                                            <p style="margin: 0;">Kode: {{ $examination->odontogram_symbol_14 ?? '' }}
                                            </p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_14 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 13"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 13</p>
                                            <p style="margin: 0;">Kode: {{ $examination->odontogram_symbol_13 ?? '' }}
                                            </p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_13 ?? '' }}</p>
                                        </td>
                                    </tr>
                                    <tr style="page-break-inside: avoid;">
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 12"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 12</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_12 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_12 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 11"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 11</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_11 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_11 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 21"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 21</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_21 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_21 ?? '' }}</p>
                                        </td>
                                    </tr>
                                    <tr style="page-break-inside: avoid;">
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 22"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 22</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_22 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_22 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 23"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 23</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_23 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_23 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 24"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 24</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_24 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_24 ?? '' }}</p>
                                        </td>
                                    </tr>
                                    <tr style="page-break-inside: avoid;">
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 25"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 25</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_25 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_25 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 26"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 26</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_26 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_26 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 27"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 27</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_27 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_27 ?? '' }}</p>
                                        </td>
                                    </tr>
                                    <tr style="page-break-inside: avoid;">
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 28"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 28</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_28 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_28 ?? '' }}</p>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr style="page-break-before: always;"></tr>

                                    <tr style="page-break-inside: avoid;">
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 48"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 48</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_48 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_48 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 47"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 47</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_47 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_47 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 46"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 46</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_46 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_46 ?? '' }}</p>
                                        </td>
                                    </tr>
                                    <tr style="page-break-inside: avoid;">
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 45"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 45</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_45 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_45 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 44"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 44</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_44 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_44 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 43"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 43</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_43 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_43 ?? '' }}</p>
                                        </td>
                                    </tr>
                                    <tr style="page-break-inside: avoid;">
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 42"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 42</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_42 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_42 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 41"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 41</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_41 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_41 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 31"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 31</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_31 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_31 ?? '' }}</p>
                                        </td>
                                    </tr>
                                    <tr style="page-break-inside: avoid;">
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 32"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 32</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_32 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_32 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 33"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 33</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_33 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_33 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 34"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 34</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_34 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_34 ?? '' }}</p>
                                        </td>
                                    </tr>
                                    <tr style="page-break-inside: avoid;">
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 35"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 35</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_35 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_35 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 36"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 36</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_36 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_36 ?? '' }}</p>
                                        </td>
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 37"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 37</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_37 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_37 ?? '' }}</p>
                                        </td>
                                    </tr>
                                    <tr style="page-break-inside: avoid;">
                                        <td style="text-align:left; padding:10px; width:30%;">
                                            <img src="{{ public_path('images/gigi.jpg') }}"
                                                alt="Gambar Odontogram 38"
                                                style="width:40px; display: block; margin-bottom: 5px;">
                                            <p style="font-weight:bold; margin: 0;">Gambar 38</p>
                                            <p style="margin: 0;">Kode:
                                                {{ $examination->odontogram_symbol_38 ?? '' }}</p>
                                            <p style="margin: 0;">Ket: {{ $examination->keterangan_38 ?? '' }}</p>
                                        </td>
                                        <td colspan="2" style="width:60%;"></td>
                                    </tr>

                                </table>

                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td style="font-weight:bold">Saran</td>
                    </tr>
                    <tr>
                        <td>{{ $examination->saran }}</td>
                    </tr>
                </table>
            @endif
        </div>
    </main>

    <!--end::Text-->
</body>

</html>
