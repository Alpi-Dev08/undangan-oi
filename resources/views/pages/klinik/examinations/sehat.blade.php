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
    <p style="color:#000;margin:0px;font-size:22px;text-align:center;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;margin-bottom:50px;margin-top:20px;        text-decoration:underline;">Surat Keterangan Sehat</p>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:20%;">Nama</td>
                <td style="width:80%;">: <b>{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Tanggal Lahir</td>
                <td style="width:80%;">: <b>{{ \Carbon\Carbon::parse($user->info->date_of_birth)->locale('id')->format('d F Y') }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;vertical-align:top">Alamat</td>
                <td style="width:80%;">: <b>{{ $info->address }}{{ isset($info->subdistrict) ? ', '.$info->subdistrict->name : '' }}{{ isset($info->district) ? ', '.$info->district->name : '' }}{{ isset($info->city) ? ', '.$info->city->name : '' }}{{ isset($info->province) ? ', '.$info->province->name : '' }}{{ isset($info->country) ? ', '.$info->country->name : '' }}{{ $info->postal_code!='' ? $info->postal_code : (isset($info->subdistrict) ? ' - '.$info->subdistrict->postal_code : '') }}</b></td>
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
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $examination->vitality->height ?? "-" }} cm</b></td>
        </tr>
        <tr>
            <td style="width:25%;">- Berat Badan</td>
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $examination->vitality->weight ?? "-" }} kg</b></td>
        </tr>
        <tr>
            <td style="width:25%;">- Tekanan Darah</td>
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $examination->vitality->blood_pressure ?? "-" }}</b></td>
        </tr>
        <tr>
            <td style="width:25%;">- Nadi</td>
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $examination->vitality->heart_rate ?? "-" }}</b></td>
        </tr>
        <tr>
            <td style="width:25%;">- Suhu Tubuh</td>
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $examination->vitality->temperature ?? "-" }}</b></td>
        </tr>
        <tr>
            <td style="width:25%;">- Gigi</td>
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $data->gigi ?? "-"}}{{ $data->keterangan_gigi ? ', '.$data->keterangan_gigi : '' }}</b></td>
        </tr>
        <tr>
            <td style="width:25%;">- Keadaan Umum</td>
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $data->keadaan_umum ?? "-"}}{{ $data->keterangan_keadaan_umum ? ', '.$data->keterangan_keadaan_umum : '' }}</b></td>
        </tr>
        <tr>
            <td style="width:25%;">- Mata</td>
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $data->mata ?? "-"}}{{ $data->keterangan_mata ? ', '.$data->keterangan_mata : '' }}</b></td>
        </tr>
        <tr>
            <td style="width:25%;">- THT</td>
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $data->tht ?? "-"}}{{ $data->keterangan_tht ? ', '.$data->keterangan_tht : '' }}</b></td>
        </tr>
        <tr>
            <td style="width:25%;">- Mulut</td>
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $data->mulut ?? "-"}}{{ $data->keterangan_mulut ? ', '.$data->keterangan_mulut : '' }}</b></td>
        </tr>
        <tr>
            <td style="width:25%;">- Dada (Paru & Jantung)</td>
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $data->dada ?? "-"}}{{ $data->keterangan_dada ? ', '.$data->keterangan_dada : '' }}</b></td>
        </tr>
        <tr>
            <td style="width:25%;">- Perut</td>
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $data->perut ?? "-"}}{{ $data->keterangan_perut ? ', '.$data->keterangan_perut : '' }}</b></td>
        </tr>
        <tr>
            <td>- Extremitas</td>
            <td style="width:75%;">: <b style="padding-left:10px;">{{ $data->extremitas ?? "-"}}{{ $data->keterangan_extremitas ? ', '.$data->keterangan_extremitas : '' }}</b></td>
        </tr>
        </tbody>
    </table>
    <p>Keterangan / Comments :</p>
    <p style="margin-bottom:20px;">{{ $data->description ?? "-" }}</p>

    <div style="width:300px;float:right;text-align:center">


    Kab. Tangerang, {{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }}<br><br><br><br><br><br>

    <b>{{ (!in_array($examination->health_profesional->user->info->title_prefix,['','-']) ? $examination->health_profesional->user->info->title_prefix.'. ' : '').$examination->health_profesional->user->name.(!in_array($examination->health_profesional->user->info->title_suffix,['','-']) ? ', '.$examination->health_profesional->user->info->title_suffix : '') }}</b>
    <b>{{ $examination->health_profesional->sip_number ? '<br>SIP.'.$examination->health_profesional->sip_number : '' }}</b>
    </div>
</main>

<!--end::Text-->
</body>
</html>

