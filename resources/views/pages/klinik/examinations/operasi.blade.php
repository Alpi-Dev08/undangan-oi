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
        
        #point {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 2px solid red;
            border-radius: 50%;
            left: {{ $data->coordinate_x ?? 0 }}px; /* Adjust the position of the point */
            top:{{ $data->coordinate_y+218 ?? 0 }}px;
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
                    Ruko C17, Pasar Intermoda BSD<br>
                    Sampora, Cisauk, Kab. Tangerang, Banten - 15414<br>
                    +62 21 5020 8805 - klinik@dharma.or.id<br>
                    https://klinik.dharma.or.id
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
<main style="font-size:12px!important;">
    <p style="color:#000;margin:0px;font-size:18px;text-align:center;font-weight:bolder;text-transform:uppercase;margin-bottom:10px;font-family: 'Roboto Condensed', sans-serif;text-decoration:underline;">FORMULIR PENANDAAN LOKASI OPERASI METODE ALTERNATIF</p>
    <p style="margin:0px">Ruangan : <b>{{ $data->ruangan ?? "" }}</b></p>
    <p style="margin:0px">Tanggal : <b>{{ $data->tanggal ?? "" }}</b></p>
    <p style="margin:0px">Waktu : <b>{{ $data->jam ?? "" }}</b></p>
    <p style="margin:0px">Jenis Operasi : <b>{{ $data->operasi ?? "" }}</b></p>
    <div id="penandaanoperasi" style="margin-top:125px">
        @if($info->gender->name == 'Pria')
        <img id="penandaan_operasi" src="{{ public_path(theme()->getMediaUrlPath().'penandaan_operasi_pria.png') }}">
        @else
        <img id="penandaan_operasi" src="{{ public_path(theme()->getMediaUrlPath().'penandaan_operasi_wanita.png') }}">
        @endif
        <div id="point"></div>
    </div>
    <p style="margin-top:-90px">Saya menyatakan bahwa lokasi operasi yang telah dutetapkan pada diagram adalah benar</p>

    <div style="width:300px;float:left;text-align:center">
    &nbsp;<br>
        Petugas Kesehatan<br><br><br><br><br><br>

    <b>{{ (!in_array($examination->health_profesional->user->info->title_prefix,['','-']) ? $examination->health_profesional->user->info->title_prefix.'. ' : '').$examination->health_profesional->user->name.(!in_array($examination->health_profesional->user->info->title_suffix,['','-']) ? ', '.$examination->health_profesional->user->info->title_suffix : '') }}</b><br>
    <b>{{ $examination->health_profesional->sip_number ? 'SIP.'.$examination->health_profesional->sip_number : '' }}</b>
    </div>
    <div style="width:300px;float:right;text-align:center">
        Kab. Tangerang, {{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }}<br>
        Pasien/Keluarga Pasien<br><br><br><br><br>

        <b>{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}</b>
    </div>
</main>

<!--end::Text-->
</body>
</html>

