<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekam Medis {{ $user->name }}</title>
</head>
<body>
<!--begin::Text-->
<div class="container mx-auto">
    <table style="width:100%">
        <tr>
            <td style="width:40%;font-size:12px;font-weight:bold">Medical Record<td>
            <td style="width:60%;font-size:12px;">: {{ $user->mr->medical_record_code }}<td>
        </tr>
        <tr>
            <td style="width:40%;font-size:12px;font-weight:bold">Examination Code<td>
            <td style="width:60%;font-size:12px;">: {{ $examination->examination_code }}<td>
        </tr>
        <tr>
            <td style="width:40%;font-size:12px;font-weight:bold">Examination Date<td>
            <td style="width:60%;font-size:12px;">: {{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y H:i:s') }}<td>
        </tr>
        <tr>
            <td style="width:40%;font-size:12px;font-weight:bold">Full Name<td>
            <td style="width:60%;font-size:12px;">: {{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}<td>
        </tr>
        <tr>
            <td style="width:40%;font-size:12px;font-weight:bold">Doctor<td>
            <td style="width:60%;font-size:12px;">: {{ $examination->health_profesional->user->name }}<td>
        </tr>
        <tr>
            <td style="width:40%;font-size:12px;font-weight:bold">Jenis Pemeriksaan<td>
            <td style="width:60%;font-size:12px;">: {{ $examination->service_category->name }}
                <ul class="list-disc">
                    @foreach(service_examination($examination->id) as $service)
                        <li class="ml-6">{{ $service->service->name }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
    </table>

    <hr class="mt-10">

    <div class="w-full p-5 ">
        <h3 class="w-full text-lg font-bold mb-2">Vital Sign & BMI</h3>
        <table style="width:100%">
            <tr>
                <td style="font-size:12px;width:40%;font-weight:bold">Weight</td>
                <td style="font-size:12px;width:60%">: {{ $examination->vitality->weight ?? "-" }} Kg</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:40%;font-weight:bold">Height</td>
                <td style="font-size:12px;width:60%">: {{ $examination->vitality->height ?? "-" }} cm</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:40%;font-weight:bold">Blood Pressure</td>
                <td style="font-size:12px;width:60%">: {{ $examination->vitality->blood_pressure ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:40%;font-weight:bold">Heart Rate</td>
                <td style="font-size:12px;width:60%">: {{ $examination->vitality->heart_rate ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:40%;font-weight:bold">Respiratory Rate</td>
                <td style="font-size:12px;width:60%">: {{ $examination->vitality->respiratory_rate ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:40%;font-weight:bold">Temperature</td>
                <td style="font-size:12px;width:60%">: {{ $examination->vitality->temperature ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:40%;font-weight:bold">Oxygen Saturation</td>
                <td style="font-size:12px;width:60%">: {{ $examination->vitality->oxygen_saturation ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:40%;font-weight:bold">Body Mass Index</td>
                <td style="font-size:12px;width:60%">: {{ $examination->vitality->body_mass_index ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:40%;font-weight:bold">Ideal Weight</td>
                <td style="font-size:12px;width:60%">: {{ $examination->vitality->ideal_weight ?? "-" }} Kg</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:40%;font-weight:bold">Body Fat</td>
                <td style="font-size:12px;width:60%">: {{ $examination->vitality->body_fat ?? "-" }}</td>
            </tr>
            <tr>
                <td style="font-size:12px;width:40%;font-weight:bold">BMI Conclusion</td>
                <td style="font-size:12px;width:60%">: {{ $examination->vitality->bmi_conclusion ?? "-" }}</td>
            </tr>
        </table>

        <hr class="mt-10">
        @if($examination->service_category->is_mcu == 1)

                <h1  class="w-full text-2xl font-bold mb-2 mt-10">Check up Result</h1>
        @if(isset($examination->anamnesis->anamnesis_value))
            <h3 class="text-xl font-bold">1. Anamnesis</h3>
            @php
                $anamnesis = json_decode($examination->anamnesis->anamnesis_value);
                $header = '';
            @endphp
        <table style="width:100%">
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
                    <td style="width:40%;padding-left:30px;">{{getAnamnesis($key)->name }}</td>
                    <td style="width:60%;">: {{ ucwords($radio[$radioKeys[0]]).', '.$additional[$additionalKeys[0]] }}</td>
                        </tr>
                @elseif($radio)
                    @if($header != getAnamnesis($key)->anamnesis_category_id)
                        <tr><td colspan="2" style="padding-left:15px;font-weight:bold">{{ getAnamnesisCategory(getAnamnesis($key)->anamnesis_category_id)->name }}</td></tr>
                        @php $header = getAnamnesis($key)->anamnesis_category_id; @endphp
                    @endif
                <tr>
                    <td style="width:40%;padding-left:30px;">{{getAnamnesis($key)->name }}</td>
                    <td style="width:60%;">: {{ ucwords($radio[$radioKeys[0]])}}</td>
                </tr>
                @elseif($additional[$additionalKeys[0]])
                    @if($header != getAnamnesis($key)->anamnesis_category_id)
                        <tr><td colspan="2" style="padding-left:15px;font-weight:bold">{{ getAnamnesisCategory(getAnamnesis($key)->anamnesis_category_id)->name }}</td></tr>
                        @php $header = getAnamnesis($key)->anamnesis_category_id; @endphp
                    @endif
                <tr>
                    <td style="width:40%;padding-left:30px;">{{getAnamnesis($key)->name }}</td>
                        <td style="width:60%;">: {{$additional[$additionalKeys[0]] }}</td>
                </tr>
                @endif

            @endforeach
        </table>
            @endif
        @if(isset($examination->physical->physical_value))
            <h3 class="text-xl font-bold">2. Physical</h3>
            <table style="width:100%">
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
                    <td style="width:40%;padding-left:30px;">{{getPhysicals($key)->name }}</td>
                        <td style="width:60%;">: {{ ucwords($radio[$radioKeys[0]]).', '.$additional[$additionalKeys[0]] }}</td>
                        </tr>
                @elseif($radio)
                    @if($header != getPhysicals($key)->physical_category_id)
                        <tr>
                        <td colspan="2" style="padding-left:15px;font-weight:bold">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</td></tr>
                        @php $header = getPhysicals($key)->physical_category_id; @endphp
                    @endif
                  <tr>
                    <td style="width:40%;padding-left:30px;">{{getPhysicals($key)->name }}</td>
                        <td style="width:60%;">: {{ ucwords($radio[$radioKeys[0]])}}</td>
                        </tr>
                @elseif($additional[$additionalKeys[0]])
                    @if($header != getPhysicals($key)->physical_category_id)
                        <tr>
                        <td colspan="2" style="padding-left:15px;font-weight:bold">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</td></tr>
                        @php $header = getPhysicals($key)->physical_category_id; @endphp
                    @endif
                  <tr>
                    <td style="width:40%;padding-left:30px;">{{getPhysicals($key)->name }}</td>
                        <td style="width:60%;">: {{$additional[$additionalKeys[0]] }}</td>
                        </tr>
                @endif
            @endforeach
            </table>
            @endif
            <table style="width:100%">

                @if(isset($examination->other->other_value))
            <h3 class="text-xl font-bold">3. Other</h3>
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

                @if($radio && $additional[$additionalKeys[0]])
                    @if($header != getPhysicals($key)->anamnesis_category_id)
                        <tr>
                        <td colspan="2" style="padding-left:15px;font-weight:bold">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</td></tr>
                        @php $header = getPhysicals($key)->physical_category_id; @endphp
                    @endif
                       <tr>
                    <td style="width:40%;padding-left:30px;">{{getPhysicals($key)->name }}</td>
                        <td style="width:60%;">: {{ ucwords($radio[$radioKeys[0]]).', '.$additional[$additionalKeys[0]] }}</td>
                        </tr>
                @elseif($radio)
                    @if($header != getPhysicals($key)->physical_category_id)
                        <td class="col-12 font-bold " style="padding-left:15px">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</td></tr>
                        @php $header = getPhysicals($key)->physical_category_id; @endphp
                    @endif
                       <tr>
                    <td style="width:40%;padding-left:30px;">{{getPhysicals($key)->name }}</td>
                            <td style="width:60%;">: {{ ucwords($radio[$radioKeys[0]])}}</td>
                        </tr>
                @elseif($additional[$additionalKeys[0]])
                    @if($header != getPhysicals($key)->physical_category_id)
                        <tr>
                        <td colspan="2" style="padding-left:15px;font-weight:bold">{{ getPhysicalsCategory(getPhysicals($key)->physical_category_id)->name }}</td></tr>
                        @php $header = getPhysicals($key)->physical_category_id; @endphp
                    @endif
                       <tr>
                    <td style="width:40%;padding-left:30px;">{{getPhysicals($key)->name }}</td>
                            <td style="width:60%;">: {{$additional[$additionalKeys[0]] }}</td>
                        </tr>
                @endif
            @endforeach
            <tr style="padding-top:10px">
                <td style="width:40%;padding-left:15px;font-weight:bold">Result</td>
                <td style="width:60%;">:
                    @switch($examination->other->result)
                        @case("fit")
                            {{ "Fit with Note" }}
                            @break
                        @case("fitwork")
                            {{ "Fit for Work" }}
                            @break
                        @case("unfit")
                            {{ "Unfit" }}
                            @break
                        @endswitch
                </td>
            </tr>
            <tr>
                <td style="width:40%;padding-left:15px;font-weight:bold">Description</td>
                <td style="width:60%;">: {{$examination->other->description }}</td>
            </tr>
            </table>
            @endif
        @else
            <h3 class="col-12 text-lg font-bold mb-2">Check up Result</h3>
            <table style="width:100%">
                <tr><td style="font-weight:bold">Subjective :</td></tr>
                <tr><td>{{ $examination->subjective }}</td></tr>
                <tr><td style="font-weight:bold">Objective :</td></tr>
                <tr><td>{{ $examination->objective }}</td></tr>
                <tr><td style="font-weight:bold">Assessment :</td></tr>
                <tr><td>{{ $examination->assessment }}</td></tr>
                <tr><td style="font-weight:bold">Plan :</td></tr>
                <tr><td>{{ $examination->plan }}</td></tr>
                <tr><td style="font-weight:bold">Resep :</td></tr>
                <tr><td>{{ $examination->resep }}</td></tr>
            </table>
        @endif
    </div>
</div>
<!--end::Text-->
</body>
</html>

