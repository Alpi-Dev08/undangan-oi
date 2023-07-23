<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
</head>
<body>
<div class="container mt-2">
    <div class="row">
        @php
            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
        @endphp
        @if($total%2==1)
            @php $total = $total+1 @endphp
        @endif
        @php $cut = $total - 2; @endphp
        @for($i=1;$i<=$total;$i++)
            <div class="mb-3 col-6 row" style="height:1.5cm;margin:0px auto;">
                <div class="col-5 text-left" style="font-size:8px;font-family: 'Roboto', sans-serif;">
                    <span>{{ $user->name }}</span><br>
                    <span>{{ \Carbon\Carbon::parse($user->info->date_of_birth)->format('d-m-Y') }}</span><br>
                    <span>{{ \Carbon\Carbon::parse($user->info->date_of_birth)->age }} thn / {{ $user->info->gender->name }}</span><br>
                    <span>{{ $labUnit->name }}</span><br>
                    <span>{{ $laboratoryexamination->sub_unit ?? "-" }}</span>
                </div>
                <div class="col-7" style="font-size:8px;">
                    <span style="font-family: 'Roboto', sans-serif;">{{ $laboratoryexamination->laboratory->name }}</span><br>
                    <span style="font-family: 'Roboto', sans-serif;">{{ $laboratoryexamination->laboratory_registration_number }}</span><br><br>
                    <div style="width:85px;postition:relative;">
                        <img style="width:90px;height:20px;margin-top:-10px" src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($patient->patient_code, $generatorPNG::TYPE_CODE_128)) }}"><br>
                        <span style="font-family: 'Roboto', sans-serif;width:100%;text-align:center;font-size:6px;margin-top:0px;display:block;padding-top:0px;letter-spacing: 2px;font-weight:bold ">{{$patient->user->mr->medical_record_code}}</span>
                    </div>
                </div>
            </div>
           @endfor
    </div>
</div>
</body>
</html>
