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
            <td style="witdh:30%;font-weight:bold">Medical Record<td>
            <td style="width:70%">: {{ $user->mr->medical_record_code }}<td>
        </tr>
        <tr>
            <td style="witdh:30%;font-weight:bold">Examination Code<td>
            <td style="width:70%">: {{ $examination->examination_code }}<td>
        </tr>
        <tr>
            <td style="witdh:30%;font-weight:bold">Full Name<td>
            <td style="width:70%">: {{ $user->name }}<td>
        </tr>
        <tr>
            <td style="witdh:30%;font-weight:bold">Doctor<td>
            <td style="width:70%">: {{ $examination->health_profesional->user->name }}<td>
        </tr>
        <tr>
            <td style="witdh:30%;font-weight:bold">Jenis Pemeriksaan<td>
            <td style="width:70%">: {{ $examination->service_category->name }}
                <ul class="list-disc">
                    @foreach(service_examination($examination->id) as $service)
                        <li class="ml-6">{{ $service->service->name }}</li>
                    @endforeach
                </ul>
            </div>
        </tr>
    </table>

    <hr class="mt-10">

    <div class="w-full p-5 ">
        <h1 class="w-full text-2xl font-bold mb-2">Vitality</h1>
        <table style="width:100%">
            <tr>
                <td style="witdh:30%;font-weight:bold">Weight</td>
                <td style="width:70%">: {{ $examination->vitality->weight ?? "-" }} Kg</td>
            </tr>
            <tr>
                <td style="witdh:30%;font-weight:bold">Height</td>
                <td style="width:70%">: {{ $examination->vitality->height ?? "-" }} cm</td>
            </tr>
            <tr>
                <td style="witdh:30%;font-weight:bold">Blood Pressure</td>
                <td style="width:70%">: {{ $examination->vitality->blood_pressure ?? "-" }}</td>
            </tr>
            <tr>
                <td style="witdh:30%;font-weight:bold">Heart Rate</td>
                <td style="width:70%">: {{ $examination->vitality->heart_rate ?? "-" }}</td>
            </tr>
            <tr>
                <td style="witdh:30%;font-weight:bold">Respiratory Rate</td>
                <td style="width:70%">: {{ $examination->vitality->respiratory_rate ?? "-" }}</td>
            </tr>
            <tr>
                <td style="witdh:30%;font-weight:bold">Temperature</td>
                <td style="width:70%">: {{ $examination->vitality->temperature ?? "-" }}</td>
            </tr>
            <tr>
                <td style="witdh:30%;font-weight:bold">Oxygen Saturation</td>
                <td style="width:70%">: {{ $examination->vitality->oxygen_saturation ?? "-" }}</td>
            </tr>
            <tr>
                <td style="witdh:30%;font-weight:bold">Body Mass Index</td>
                <td style="width:70%">: {{ $examination->vitality->body_mass_index ?? "-" }}</td>
            </tr>
            <tr>
                <td style="witdh:30%;font-weight:bold">Ideal Weight</td>
                <td style="width:70%">: {{ $examination->vitality->ideal_weight ?? "-" }} Kg</td>
            </tr>
            <tr>
                <td style="witdh:30%;font-weight:bold">Body Fat</td>
                <td style="width:70%">: {{ $examination->vitality->body_fat ?? "-" }}</td>
            </tr>
            <tr>
                <td style="witdh:30%;font-weight:bold">BMI Conclusion</td>
                <td style="width:70%">: {{ $examination->vitality->bmi_conclusion ?? "-" }}</td>
            </tr>
        </table>

        <hr class="mt-10">
        @if($examination->service_category->is_mcu == 1)

                <h1  class="w-full text-2xl font-bold mb-2 mt-10">Check up Result</h1>
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
            <table style="width:100%">

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
                <td style="width:60%;">: {{ $examination->other->result  }}</td>
            </tr>
            <tr>
                <td style="width:40%;padding-left:15px;font-weight:bold">Description</td>
                <td style="width:60%;">: {{$examination->other->description }}</td>
            </tr>
            </table>
        @else
            <h5 class="col-12">Check up Result</h5>
            <div class="col-12 row">
                <div class="col-2 fw-bolder">Subjective</div>
                <div class="col-10">: {{ $examination->subjective }}</div>
            </div>
            <div class="col-12 row">
                <div class="col-2 fw-bolder">Objective</div>
                <div class="col-10">: {{ $examination->objective }}</div>
            </div>
            <div class="col-12 row">
                <div class="col-2 fw-bolder">Assessment</div>
                <div class="col-10">: {{ $examination->assessment }}</div>
            </div>
            <div class="col-12 row">
                <div class="col-2 fw-bolder">Plan</div>
                <div class="col-10">: {{ $examination->plan }}</div>
            </div>
            <div class="col-12 row">
                <div class="col-2 fw-bolder">Resep</div>
                <div class="col-10">: {{ $examination->resep }}</div>
            </div>
        @endif
    </div>

</div>
<!--end::Text-->
</body>
</html>
