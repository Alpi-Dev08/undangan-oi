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
            margin: 0.5cm 1.5cm;
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
            margin-top: 3cm;
            margin-bottom: 120px;
        }

    </style>

    <title>Surat Keterangan {{ $user->name }}</title>
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
                    {!! organizationInfo('full') !!}
                </p>
            </td>
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
<main style="font-size:13px!important;">
    <p style="color:#000;margin:0px;font-size:16px;text-align:center;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;margin-top:20px;text-decoration:underline;">Surat Keterangan Berobat/Sakit</p>
    <p style="color:#000;margin:0px;font-size:16px;text-align:center;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;margin-bottom:50px;text-decoration:underline;">ATTENDANCE / ILLNESS CERTIFICATE</p>

    <p>Yang bertanda tangan dibawah ini menerangkan bahwa:<br><em>This is to certify that:</em></p>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:25%;">Nama / Name</td>
                <td style="width:75%;">: <b>{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }} </b></td>
            </tr>
            <tr>
                <td style="width:25%;">Jenis Kelamin / Sex</td>
                <td style="width:75%;">: <b>{{ $info->gender->name ?? "-" }} </b></td>
            </tr>
            <tr>
                <td style="width:25%;">Umur / Age</td>
                <td style="width:75%;">: <b>{{ \Carbon\Carbon::parse($user->info->date_of_birth)->age }} </b></td>
            </tr>
            <tr>
                <td style="width:25%;vertical-align:top">Pekerjaan / Occupation</td>
                <td style="width:75%;">: <b>{{ $data->pekerjaan ?? "-" }} </b></td>
            </tr>
            <tr>
                <td style="width:25%;vertical-align:top">Perusahaan / Company</td>
                <td style="width:75%;">: <b>{{ $data->perusahaan ?? "-" }} </b></td>
            </tr>
        </tbody>
    </table>
    <p>Telah datang ke klinik pada Tanggal : <b style="text-decoration: underline;">{{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }}</b> dan yang bersangkutan :</p>
    <p><em>Has attended to the clinic on : <b style="text-decoration: underline;">{{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }}</b> and the patient :</em></p>
    @if(isset($data->keterangan))
    <table class="table" style="margin-left:10px;width:100%">
        <tbody>
        <tr>
            <td style="vertical-align:top"><input type="checkbox" {{ $data->keterangan==1 ? "checked" : "" }}></td>
            <td style="padding-bottom: 15px">Dapat kembali bekerja <br><em>May return to work</em></td>
        </tr>
        <tr>
            <td style="vertical-align:top"><input type="checkbox" {{ $data->keterangan==2 ? "checked" : "" }}></td>
            @if($data->keterangan==2)
                <td style="padding-bottom: 15px">
                    Disarankan untuk beristirahat selama : <b>{{ $data->hari ?? "0" }}</b> hari, dari <b>{{ $data->start_date ? \Carbon\Carbon::parse($data->start_date)->locale('id')->format('d F Y') : "-" }}</b> s.d <b>{{ $data->end_date ? \Carbon\Carbon::parse($data->end_date)->locale('id')->format('d F Y') : "-" }}</b><br>
                        <em>Should have a complete rest for : <b>{{ $data->hari ?? "0" }}</b> day (s), from <b>{{ $data->start_date ? \Carbon\Carbon::parse($data->start_date)->locale('id')->format('d F Y') : "-" }}</b> to <b>{{ $data->end_date ? \Carbon\Carbon::parse($data->end_date)->locale('id')->format('d F Y') : "-" }}</b></em>
                </td>
            @else
                <td style="padding-bottom: 15px">
                    Disarankan untuk beristirahat selama : <b>0</b> hari, dari <b>-</b> s.d <b>-</b><br>
                    <em>Should have a complete rest for : <b>0</b> day (s), from <b>-</b> to <b>-</b></em>
                </td>
            @endif
        </tr>
        <tr>
            <td style="vertical-align:top"><input type="checkbox" {{ $data->keterangan==3 ? "checked" : "" }}></td>
            @if($data->keterangan==3)
            <td style="padding-bottom: 15px">Perlu datang kembali ke klinik pada : <b>{{ $data->back_date ? \Carbon\Carbon::parse($data->back_date)->locale('id')->format('d F Y') : "-" }}</b><br>
                <em>Need to be seen again at clinic on : <b>{{ $data->back_date ? \Carbon\Carbon::parse($data->back_date)->locale('id')->format('d F Y') : "-" }}</b></em></td>
            @else
                <td style="padding-bottom: 15px">Perlu datang kembali ke klinik pada : <b>-</b><br>
                    <em>Need to be seen again at clinic on : <b>-</b></em></td>
            @endif
        </tr>
        <tr>
            <td style="vertical-align:top"><input type="checkbox" {{ $data->keterangan==4 ? "checked" : "" }}></td>
            <td style="padding-bottom: 15px">Perlu dirujuk ke Rumah Sakit untuk mendapatkan pemeriksaan lebih lanjut<br><em>Need to be referred to hospital for further treatment</em></td>
        </tr>
        </tbody>
    </table>
   @endif
    <p>Keterangan / Comments :</p>
    <p style="margin-bottom:20px;">{{ $data->description ?? "-" }}</p>

    <div style="width:300px;float:right;text-align:center">


    Kab. Tangerang, {{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }}<br><br><br><br><br><br>

    <b>{{ (!in_array($examination->health_profesional->user->info->title_prefix,['','-']) ? $examination->health_profesional->user->info->title_prefix.'. ' : '').$examination->health_profesional->user->name.(!in_array($examination->health_profesional->user->info->title_suffix,['','-']) ? ', '.$examination->health_profesional->user->info->title_suffix : '') }}</b><br>
    <b>{{ $examination->health_profesional->sip_number ? 'SIP.'.$examination->health_profesional->sip_number : '' }}</b>
    </div>
</main>

<!--end::Text-->
</body>
</html>

