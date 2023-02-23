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
            margin-top: 4cm;
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
                <p style="margin:0px;font-size:22px;text-align:center;color:gray;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;">Surat Keterangan Sakit</p>
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
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:20%;">Nama</td>
                <td style="width:80%;">: {{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}</td>
            </tr>
            <tr>
                <td style="width:20%;">Tanggal Lahir</td>
                <td style="width:80%;">: {{ \Carbon\Carbon::parse($user->info->date_of_birth)->locale('id')->format('d F Y') }}</td>
            </tr>
            <tr>
                <td style="width:20%;">Alamat</td>
                <td style="width:80%;">: {{ $info->address }}{{ isset($info->subdistrict) ? ', '.$info->subdistrict->name : '' }}{{ isset($info->district) ? ', '.$info->district->name : '' }}{{ isset($info->city) ? ', '.$info->city->name : '' }}{{ isset($info->province) ? ', '.$info->province->name : '' }}{{ isset($info->country) ? ', '.$info->country->name : '' }}{{ $info->postal_code!='' ? $info->postal_code : (isset($info->subdistrict) ? ' - '.$info->subdistrict->postal_code : '') }}</td>
            </tr>
        </tbody>
    </table>

    <br>
    <p>Telah melakukan pemeriksaan kesehatan pada Tanggal : <b>{{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }}</b> di Klinik Satriabudi Dharma Medika, Sampora, Cisauk, Kab. Tangerang.</p>
    <p>Berikut ini hasil pemeriksaan tersebut:</p>
    <table class="table" style="margin-left:10px;width:100%">
        <tbody>
        <tr>
            <td style="width:25%;">- Tinggi Badan</td>
            <td style="width:75%;">: {{ $examination->vitality->height ?? "-" }} cm</td>
        </tr>
        <tr>
            <td style="width:25%;">- Berat Badan</td>
            <td style="width:75%;">: {{ $examination->vitality->weight ?? "-" }} kg</td>
        </tr>
        <tr>
            <td style="width:25%;">- Tekanan Darah</td>
            <td style="width:75%;">: {{ $examination->vitality->blood_pressure ?? "-" }}</td>
        </tr>
        <tr>
            <td style="width:25%;">- Nadi</td>
            <td style="width:75%;">: {{ $examination->vitality->heart_rate ?? "-" }}</td>
        </tr>
        <tr>
            <td style="width:25%;">- Suhu Tubuh</td>
            <td style="width:75%;">: {{ $examination->vitality->temperature ?? "-" }}</td>
        </tr>
        <tr>
            <td style="width:25%;">- Gigi</td>
            <td style="width:75%;">: Normal</td>
        </tr>
        <tr>
            <td style="width:25%;">- Keadaan Umum</td>
            <td style="width:75%;">: Normal</td>
        </tr>
        <tr>
            <td style="width:25%;">- Mata</td>
            <td style="width:75%;">: Normal</td>
        </tr>
        <tr>
            <td style="width:25%;">- THT</td>
            <td style="width:75%;">: Normal</td>
        </tr>
        <tr>
            <td style="width:25%;">- Mulut</td>
            <td style="width:75%;">: Normal</td>
        </tr>
        <tr>
            <td style="width:25%;">- Dada (Paru & Jantung)</td>
            <td style="width:75%;">: Normal</td>
        </tr>
        <tr>
            <td style="width:25%;">- Perut</td>
            <td style="width:75%;">: Normal</td>
        </tr>
        <tr>
            <td>- Extremitas</td>
            <td style="width:75%;">: Normal</td>
        </tr>
        </tbody>
    </table>
    <p>Keterangan / Comments :</p>
    <p>Saat ini pasien dalam keadaan <b>SEHAT</b>.</p>

    <div style="width:300px;float:right;text-align:center">


    Kab. Tangerang, {{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }}<br><br><br><br><br><br>

    {{ (!in_array($examination->health_profesional->user->info->title_prefix,['','-']) ? $examination->health_profesional->user->info->title_prefix.'. ' : '').$examination->health_profesional->user->name.(!in_array($examination->health_profesional->user->info->title_suffix,['','-']) ? ', '.$examination->health_profesional->user->info->title_suffix : '') }}
    {{ $examination->health_profesional->sip_number ? '<br>SIP.'.$examination->health_profesional->sip_number : '' }}
    </div>
</main>

<!--end::Text-->
</body>
</html>

