<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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

        body{
            margin-top: 6cm;
            margin-bottom: 120px;
        }

    </style>



    <title>Rekam Medis {{ $user->name }}</title>
</head>
<body  style="font-family: 'Nunito Sans', sans-serif;">
<!--begin::Text-->
<header>
    <table style="width:100%;border-bottom-width:5px;border-bottom-style:double">
        <tr style="vertical-align:baseline">
            <td style="width: 50%;vertical-align:top">

                <img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/logo-klinik.png') }}"  style="height:50px;">
            </td>
            <td style="width: 50%; vertical-align:top">
                <p style="margin:0px; margin-top:10px; font-size:12px;text-align: right;color:#000;">
                    Ruko C17, Pasar Intermoda BSD<br>
                    Sampora, Cisauk, Kab. Tangerang, Banten - 15414<br>
                    +62 21 5020 8805 - klinik@dharma.or.id<br>
                    https://klinik.dharma.or.id
                </p>
            </td>
        </tr>
    </table>
    <table style="width:100%;border-bottom-width:2px;border-bottom-style:solid">
        <tr style="vertical-align:baseline">
            <td colspan="2" style="width: 100%;text-align:center">
                <p style="margin:0px;font-size:22px;text-align:center;color:gray;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;">Medical Record</p>
            </td>
        </tr>
    </table>
    <table style="width:100%;font-size:10px;">
        <tr>
            <td style="width:20%;font-size:12px;font-weight:bold">Full Name<td>
            <td style="width:30%;font-size:12px;">: {{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}<td>
            <td style="width:20%;font-size:12px;font-weight:bold">MR No<td>
            <td style="width:30%;font-size:12px;">: {{ $user->mr->medical_record_code }}<td>
        </tr>
        <tr>
            <td style="width:20%;font-size:12px;font-weight:bold">Gender<td>
            <td style="width:30%;font-size:12px;">: {{ $user->info->gender->name }}<td>
            <td style="width:20%;font-size:12px;font-weight:bold">Examination Date<td>
            <td style="width:30%;font-size:12px;">: {{ \Carbon\Carbon::parse($examination->created_at)->locale('id')->format('d F Y H:i:s') }}<td>
        </tr>
        <tr>
            <td style="width:20%;font-size:12px;font-weight:bold">Birth Date / Age<td>
            <td style="width:30%;font-size:12px;">: {{ \Carbon\Carbon::parse($user->info->date_of_birth)->locale('id')->format('d F Y') }} / {{ \Carbon\Carbon::parse($user->info->date_of_birth)->age }}<td>
            <td style="width:20%;font-size:12px;font-weight:bold">Doctor<td>
            <td style="width:30%;font-size:12px;">: {{ (!in_array($examination->health_profesional->user->info->title_prefix,['','-']) ? $examination->health_profesional->user->info->title_prefix.'. ' : '').$examination->health_profesional->user->name.(!in_array($examination->health_profesional->user->info->title_suffix,['','-']) ? ', '.$examination->health_profesional->user->info->title_suffix : '') }}<td>
        </tr>
        <tr>
            <td style="width:20%;font-size:12px;vertical-align:top;font-weight:bold">Phone<td>
            <td style="width:30%;font-size:12px;vertical-align:top">: {{ $user->phone }}<td>
            <td style="width:20%;font-size:12px;font-weight:bold;vertical-align:top">Service Type<td>
            <td style="width:30%;font-size:12px;">: {{ $examination->service_category->name }} </td>
        </tr>{{--
        <tr>
            <td style="width:20%;font-size:12px;font-weight:bold;vertical-align:top">Address<td>
            <td style="width:30%;font-size:12px;vertical-align:top">: {{ $user->info->address }}{{ isset($user->info->subdistrict) ? ', '.$user->info->subdistrict->name : '' }}{{ isset($user->info->district) ? ', '.$user->info->district->name : '' }}{{ isset($user->info->city) ? ', '.$user->info->city->name : '' }}{{ isset($user->info->province) ? ', '.$user->info->province->name : '' }}{{ isset($user->info->country) ? ', '.$user->info->country->name : '' }}{{ $user->info->postal_code!='' ? $user->info->postal_code : (isset($user->info->subdistrict) ? ' - '.$user->info->subdistrict->postal_code : '') }}<td>
            <td style="width:20%;font-size:12px;font-weight:bold;vertical-align:top"><td>
            <td style="width:30%;font-size:12px;vertical-align:top">
                <ul class="list-disc" style="margin:0px; padding-left:20px;">
                    @foreach(service_examination($examination->id) as $service)
                        <li style="margin:0px;">{{ $service->service->name }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>--}}
    </table>
    <table style="margin-top:10px;width:100%;font-size:12px;border-bottom-style: double;border-top-style: double;border-top-width: 3px;border-bottom-width: 3px;">
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
                <h2 style="margin:0px;text-transform: uppercase;font-size: 16px;font-weight: bold">WISHING YOU GOOD HEALTH AND HAPPINESS</h2>
                <p style="margin:0px;text-transform: uppercase;font-size: 14px;">SEMOGA SEHAT DAN BAHAGIA SELALU</p>
            </td>
            <td style="width:50%;text-align: right;vertical-align: bottom;float: right;height:100px">
                <img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/qr.jpeg') }}"  style="height:85px;margin-right:5px;"><img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/logo-yayasan.png') }}"  style="height:75px;">
            </td>
        </tr>
    </table>
</footer>
<main>
    <div>
        <h4 style="font-weight: bolder;color:#436ba4;font-size:12px;margin:0px;margin-top:10px;text-transform: uppercase">Vital Sign & BMI</h4>
        <table style="width:100%;font-size:12px;">
            <tr>
                <td style="font-size:12px;width:35%;padding-left:10px">Weight</td>
                <td style="font-size:12px;width:65%">{{ $examination->vitality->weight ?? "-" }} Kg</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:35%;padding-left:10px">Height</td>
                <td style="font-size:12px;width:65%">{{ $examination->vitality->height ?? "-" }} cm</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:35%;padding-left:10px">Blood Pressure</td>
                <td style="font-size:12px;width:65%">{{ $examination->vitality->blood_pressure ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:35%;padding-left:10px">Heart Rate</td>
                <td style="font-size:12px;width:65%">{{ $examination->vitality->heart_rate ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:35%;padding-left:10px">Respiratory Rate</td>
                <td style="font-size:12px;width:65%">{{ $examination->vitality->respiratory_rate ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:35%;padding-left:10px">Temperature</td>
                <td style="font-size:12px;width:65%">{{ $examination->vitality->temperature ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:35%;padding-left:10px">Oxygen Saturation</td>
                <td style="font-size:12px;width:65%">{{ $examination->vitality->oxygen_saturation ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:35%;padding-left:10px">Body Mass Index</td>
                <td style="font-size:12px;width:65%">{{ $examination->vitality->body_mass_index ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:35%;padding-left:10px">Ideal Weight</td>
                <td style="font-size:12px;width:65%">{{ $examination->vitality->ideal_weight ?? "-" }} Kg</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:35%;padding-left:10px">Body Fat</td>
                <td style="font-size:12px;width:65%">{{ $examination->vitality->body_fat ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:35%;padding-left:10px">BMI Conclusion</td>
                <td style="font-size:12px;width:65%">{{ $examination->vitality->bmi_conclusion ?? "-" }}</td>
            </tr>
        </table>

        <hr class="mt-10">
        @if($examination->service_category->is_mcu == 1)

            <h4 style="margin-bottom:0px;font-weight: bolder;color:#436ba4;font-size:12px;margin:0px;margin-top:10px;text-transform: uppercase">Check up Result</h4>
            @if(isset($examination->anamnesis->anamnesis_value))
                <h3 style="margin-bottom:0px;font-weight: bold;font-size:12px;">1. Anamnesis</h3>
                @php
                    $anamnesis = json_decode($examination->anamnesis->anamnesis_value);
                    $header = '';
                @endphp
            <table style="width:100%;font-size:12px;">
                @foreach($anamnesis as $key => $value)

                    @php
                        $radio = '';
                        if(isset($value->radio)){
                            $radio = json_decode(json_encode($value->radio),true);
                            $radioKeys = array_keys($radio);
                        }
                        $additional = json_decode(json_encode($value->additional),true);
                        $additionalKeys = array_keys($additional);
                    @endphp

                    @if($radio && $additional[$additionalKeys[0]])
                        @if($header != getAnamnesis($key)->anamnesis_category_id)
                            <tr>
                            <td colspan="2" style="padding-left:15px;font-weight:bold">{{ getAnamnesisCategory(getAnamnesis($key)->anamnesis_category_id)->name }}</td></tr>
                            @php $header = getAnamnesis($key)->anamnesis_category_id; @endphp
                        @endif
                            <tr>
                        <td style="width:35%;padding-left:15px;">{{getAnamnesis($key)->name }}</td>
                        <td style="width:65%;">: {{ ucwords($radio[$radioKeys[0]]).', '.$additional[$additionalKeys[0]] }}</td>
                            </tr>
                    @elseif($radio)
                        @if($header != getAnamnesis($key)->anamnesis_category_id)
                            <tr><td colspan="2" style="padding-left:15px;font-weight:bold">{{ getAnamnesisCategory(getAnamnesis($key)->anamnesis_category_id)->name }}</td></tr>
                            @php $header = getAnamnesis($key)->anamnesis_category_id; @endphp
                        @endif
                    <tr>
                        <td style="width:35%;padding-left:15px;">{{getAnamnesis($key)->name }}</td>
                        <td style="width:65%;">: {{ ucwords($radio[$radioKeys[0]])}}</td>
                    </tr>
                    @elseif($additional[$additionalKeys[0]])
                        @if($header != getAnamnesis($key)->anamnesis_category_id)
                            <tr><td colspan="2" style="padding-left:15px;font-weight:bold">{{ getAnamnesisCategory(getAnamnesis($key)->anamnesis_category_id)->name }}</td></tr>
                            @php $header = getAnamnesis($key)->anamnesis_category_id; @endphp
                        @endif
                    <tr>
                        <td style="width:35%;padding-left:15px;">{{getAnamnesis($key)->name }}</td>
                            <td style="width:65%;">: {{$additional[$additionalKeys[0]] }}</td>
                    </tr>
                    @endif

                @endforeach
            </table>
                @endif
            @if(isset($examination->physical->physical_value))
                    <h3 style="margin-bottom:0px;font-weight: bold;font-size:12px;">2. Physical</h3>
                <table style="width:100%;font-size:12px;">
                @php
                    $physicals = json_decode($examination->physical->physical_value);
                    $header = '';
                @endphp
                @foreach($physicals as $key => $value)
                    @php
                        $radio = '';
                        if(isset($value->radio)){
                            $radio = json_decode(json_encode($value->radio),true);
                            $radioKeys = array_keys($radio);
                        }
                        $additional = json_decode(json_encode($value->additional),true);
                        $additionalKeys = array_keys($additional);
                    @endphp

                    @if($radio && $additional[$additionalKeys[0]])
                        @if($header != getPhysicals($key)->physical_category_id)
                            <tr>
                            <td colspan="2" style="padding-left:15px;font-weight:bold">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</td></tr>
                            @php $header = getPhysicals($key)->physical_category_id; @endphp
                        @endif
                           <tr>
                        <td style="width:35%;padding-left:15px;">{{getPhysicals($key)->name }}</td>
                            <td style="width:65%;">: {{ ucwords($radio[$radioKeys[0]]).', '.$additional[$additionalKeys[0]] }}</td>
                            </tr>
                    @elseif($radio)
                        @if($header != getPhysicals($key)->physical_category_id)
                            <tr>
                            <td colspan="2" style="padding-left:15px;font-weight:bold">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</td></tr>
                            @php $header = getPhysicals($key)->physical_category_id; @endphp
                        @endif
                      <tr>
                        <td style="width:35%;padding-left:15px;">{{getPhysicals($key)->name }}</td>
                            <td style="width:65%;">: {{ ucwords($radio[$radioKeys[0]])}}</td>
                            </tr>
                    @elseif($additional[$additionalKeys[0]])
                        @if($header != getPhysicals($key)->physical_category_id)
                            <tr>
                            <td colspan="2" style="padding-left:15px;font-weight:bold">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</td></tr>
                            @php $header = getPhysicals($key)->physical_category_id; @endphp
                        @endif
                      <tr>
                        <td style="width:35%;padding-left:15px;">{{getPhysicals($key)->name }}</td>
                            <td style="width:65%;">: {{$additional[$additionalKeys[0]] }}</td>
                            </tr>
                    @endif
                @endforeach
                </table>
            @endif
            @if(isset($examination->other->other_value))
                <h3 style="margin-bottom:0px;font-weight: bold;font-size:12px;">3. Other</h3>
                <table style="width:100%;font-size:12px;">
            @php
                $others = json_decode($examination->other->other_value);
                $header = '';
            @endphp
            @foreach($others as $key => $value)
                @php
                    $radio = '';
                    if(isset($value->radio)){
                        $radio = json_decode(json_encode($value->radio),true);
                        $radioKeys = array_keys($radio);
                    }
                    $additional = json_decode(json_encode($value->additional),true);
                    $additionalKeys = array_keys($additional);
                @endphp

                        @if($header != getPhysicals($key)->physical_category_id)
                            <tr>
                                <td style="width:35%;padding-left:15px;" colspan="2">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</td>
                                @php $header = getPhysicals($key)->physical_category_id; @endphp
                            </tr>
                        @endif

                @if($radio && $additional[$additionalKeys[0]])

                       <tr>
                    <td style="width:35%;padding-left:15px;">{{getPhysicals($key)->name }}</td>
                        <td style="width:65%;">: {{ ucwords($radio[$radioKeys[0]]).', '.$additional[$additionalKeys[0]] }}</td>
                        </tr>
                @elseif($radio)

                       <tr>
                    <td style="width:35%;padding-left:15px;">{{getPhysicals($key)->name }}</td>
                            <td style="width:65%;">: {{ ucwords($radio[$radioKeys[0]])}}</td>
                        </tr>
                @elseif($additional[$additionalKeys[0]])

                       <tr>
                    <td style="width:35%;padding-left:15px;">{{getPhysicals($key)->name }}</td>
                            <td style="width:65%;">: {{$additional[$additionalKeys[0]] }}</td>
                        </tr>
                @endif
            @endforeach
            </table>
            @endif
            @if(isset($examination->additional->additional_value))
                <h3 style="margin-bottom:0px;font-weight: bold;font-size:12px;">4. Additional Examination</h3>
                <table style="width:100%;font-size:12px;">
                    @php
                        $additionals = json_decode($examination->additional->additional_value);
                        $header = '';
                    @endphp
                    @foreach($additionals as $key => $value)
                        @php
                            $additional = json_decode(json_encode($value->additional),true);
                            $additionalKeys = array_keys($additional);
                        @endphp

                        @if($additional[$additionalKeys[0]])
                            @if($header != getAdditional($key)->additionals_category_id)
                                <tr>
                                    <td style="width:35%;padding-left:15px;font-weight:bold;padding-top:10px" colspan="2">{{ getAdditionalCategory(getAdditional($key)->additionals_category_id)->name }}</td>
                                    @php $header = getAdditional($key)->additionals_category_id; @endphp
                                </tr>
                            @endif
                            <tr>
                                <td style="width:35%;padding-left:15px;">{{getAdditional($key)->name }}</td>
                                <td style="width:65%;">: {{$additional[$additionalKeys[0]] }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            @endif
        @else
            <h4 style="font-weight: bolder;color:#436ba4;font-size:12px;margin:0px;margin-top:10px;text-transform: uppercase">Result</h4>
            <table style="width:100%;font-size: 12px;padding-left:10px">
                <tr><td style="font-weight:bold">Subjective</td></tr>
                <tr><td>{{ $examination->subjective }}</td></tr>
                <tr><td style="font-weight:bold">Objective</td></tr>
                <tr><td>{{ $examination->objective }}</td></tr>
                <tr><td style="font-weight:bold">Assessment</td></tr>
                <tr><td>
                        @php
                            $assessments = explode('|',$examination->assessment);
                        @endphp
                        @foreach($assessments as $assessment)
                            @if(!empty($assessment))
                            <p style="margin:0px;">{{ $assessment }}</p>
                            @endif
                        @endforeach
                </td></tr>
                <tr><td style="font-weight:bold">Plan</td></tr>
                <tr><td>{{ $examination->plan->name ?? '' }}</td></tr>
                <tr><td style="font-weight:bold">Resep</td></tr>
                <tr><td>
                        @php
                            $reseps = explode(',',$examination->resep);
                        @endphp
                        @foreach($reseps as $resep)
                            @if(!empty($resep))
                                <p style="margin:0px;">{{ $resep }}</p>
                            @endif
                        @endforeach
                    </td></tr>
            </table>
        @endif
    </div>
</main>

<!--end::Text-->
</body>
</html>

