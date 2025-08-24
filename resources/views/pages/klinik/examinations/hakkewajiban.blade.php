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
<main style="font-size:12px!important;">
    <p style="color:#000;margin:0px;font-size:22px;text-align:center;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;margin-bottom:50px;margin-top:20px;        text-decoration:underline;">BUKTI PENYAMPAIAN INFORMASI</p>
    <p>Saya yang bertanda tangan di bawah ini menyatakan BENAR telah disampaikan informasi tentang hak dan kewajiban saya selaku pasien yang menggunakan jasa pelayanan di Klinik Satriabudi Dharma Medika Perawatan Mampu sebagai berikut :
    </p>
    <br>
    <ol style="list-style-type: upper-alpha">
        <li style="font-weight: bold">Hak :
            <ol>
                <li>Memperoleh informasi mengenai tata tertib dan peraturan yang berlaku di klinik</li>
                <li>Memperoleh informasi tentang hak dan kewajiban pasien</li>
                <li>Memperoleh layanan yang manusiawi, adil, jujur, dan tanpa diskriminasi</li>
                <li>Memperoleh pelayanan kesehatan yang bermutu sesuai dengan standar profesi dan standar prosedur operasional</li>
                <li>Memperoleh layanan yang efektif dan efisien sehingga pasien terhindar dari kerugian fisik dan materi</li>
                <li>Mengajukan pengaduan atas kualitas pelayanan yang didapatkan</li>
                <li>Memilih dokter, dan perawatan sesuai dengan keinginan dan peraturan yang berlaku di klinik</li>
                <li>Meminta konsultasi tentang penyakit yang diderita kepada dokter lain yang mempunyai Surat Izin Praktik (SIP) baik di dalam maupun di luar klinik</li>
                <li>Mendapatkan privasi dan kerahasiaan penyakit yang diderita termasuk data medisnya</li>
                <li>Mendapat informasi yang meliputi diagnosis dan tata cara tindakan medis, tujuan tindakan medis, alternatif tindakan, risiko dan komplikasi yang mungkin terjadi, dan prognosis terhadap tindakan yang dilakukan serta perkiraan biaya pengobatan</li>
                <li>Memberikan persetujuan atau menolak atas tindakan yang akan dilakukan oleh tenaga kesehatan terhadap penyakit yang dideritanya</li>
                <li>Didampingi keluarga dalam keadaan kritis</li>
                <li>Memperoleh keamanan dan keselamatan diri selama dalam perawatan di klinik</li>
                <li>Mengajukan usul, saran, perbaikan atas perlakuan klinik </li>
            </ol>
        </li>
        <li style="font-weight: bold">Kewajiban :
            <ol>
                <li>Mematuhi peraturan yang berlaku di klinik</li>
                <li>Menggunakan fasilitas klinik secara bertanggung jawab</li>
                <li>Menghormati hak pasien lain, pengunjung, dan hak tenaga kesehatan serta petugas lainnya yang bekerja di klinik</li>
                <li>Memberikan informasi yang jujur, lengkap, dan akurat sesuai dengan kemampuan dan pengetahuan tentang masalah kesehatan</li>
                <li>Memberikan informasi mengenai kemampuan finansial dan jaminan kesehatan yang dimiliki</li>
                <li>Mematuhi rencana terapi yang direkomendasikan oleh tenaga kesehatan di klinik dan disetujui oleh pasien yang bersangkutan setelah mendapatkan penjelasan sesuai dengan ketentuan peraturan perundang-undangan</li>
                <li>Menerima segala konsekuensi atas keputusan pribadi untuk menolak rencana terapi yang direkomendasikan oleh tenaga kesehatan dan/atau tidak mematuhi petunjuk yang diberikan oleh tenaga kesehatan untuk penyembuhan penyakit atau masalah kesehatan</li>
                <li>Memberikan imbalan jasa atas pelayanan yang diterima.</li>
            </ol>
        </li>
    </ol>
    <p>Rumah sakit rujukan yang bekerjasama dengan Klinik Satriabudi Dharma Medika adalah Rumah Sakit Medika BSD</p>

    <div style="width:300px;float:left;text-align:center">
    &nbsp;<br>
        Petugas Kesehatan<br><br><br><br><br><br>

    <b>{{ (!in_array($examination->health_profesional->user->info->title_prefix,['','-']) ? $examination->health_profesional->user->info->title_prefix.'. ' : '').$examination->health_profesional->user->name.(!in_array($examination->health_profesional->user->info->title_suffix,['','-']) ? ', '.$examination->health_profesional->user->info->title_suffix : '') }}</b><br>
    <b>{{ $examination->health_profesional->sip_number ? 'SIP.'.$examination->health_profesional->sip_number : '' }}</b>
    </div>
    <div style="width:300px;float:right;text-align:center">
        Kab. Tangerang, {{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }}<br>
        Pasien/Keluarga Pasien<br><br>
        <img src="{{ public_path($examination->bukti_penyampaian_informasi) }}" style="height:50px;"><br>
        <b>{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}</b>
    </div>
</main>

<!--end::Text-->
</body>
</html>

