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
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;

        }

        /** Define the footer rules **/
        footer {
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
        }

        body {
            margin-top: 0cm;
            margin-bottom: 120px;
        }

    </style>

    <title>Surat Keterangan {{ $user->name }}</title>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jsignature/jSignature.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $("#signature").jSignature({"decor-color":"transparent","height":200,"width":500});
        })
    </script>
</head>
<body style="font-family: 'Nunito Sans', sans-serif;">
<!--begin::Text-->
<header>
    <table style="width:100%;border-bottom-width:5px;border-bottom-style:double">
        <tr style="vertical-align:baseline">
            <td style="width: 50%;vertical-align:top">

                <img src="{{ asset(theme()->getMediaUrlPath() . 'logos/logo-klinik.png') }}" style="height:50px;">
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
<main style="font-size:12px!important;">
    <p style="color:#000;margin:0px;font-size:22px;text-align:center;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;margin-bottom:50px;margin-top:00px;        text-decoration:underline;">BUKTI PENYAMPAIAN INFORMASI</p>
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
                <li>Mengajukan usul, saran, perbaikan atas perlakuan klinik</li>
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

    <div style="width:500px;text-align:center">
        Kab. Tangerang, {{ Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }}
        Pasien/Keluarga Pasien<br><br>
        <div id="signature"></div>
        <form id="signature_form" method="POST" enctype="multipart/form-data" action="{{ route('buktipenyampaianinformasi.store') }}">
            @csrf
            <input type="hidden" name="signature" id="sign"><input type="hidden" name="id" value="{{ $examination->id }}">
            <div class="flex justify-center mt-3">
                <button type="button" id="reset_signature" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-400 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-300"
                        style="display:none">Reset
                </button>
                <button type="button" id="save_signature" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-400 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300" style="display:none">OK</button>
                <button type="submit">Save</button>
                <button type="button" id="download_pdf" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-400 hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-300" style="display:none">Download PDF</button>
            </div>

        </form>
        <hr>
        <b>{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}</b>
    </div>
</main>

<footer>
    <table style="width:100%;border-top-width: 1px;border-top-style: solid">
        <tr>
            <td style="width:50%;text-align: left;vertical-align: top;height:100px">
                <h2 style="margin:0px;text-transform: uppercase;font-size: 16px;font-weight: bold">WISHING YOU GOOD HEALTH AND HAPPINESS</h2>
                <p style="margin:0px;text-transform: uppercase;font-size: 14px;">SEMOGA SEHAT DAN BAHAGIA SELALU</p>
            </td>
            <td style="width:50%;text-align: right;vertical-align: bottom;float: right;height:100px">
                <img src="{{ asset(theme()->getMediaUrlPath() . 'logos/qr.jpeg') }}" style="height:85px;margin-right:5px;"><img src="{{ asset(theme()->getMediaUrlPath() . 'logos/logo-yayasan.png') }}" style="height:75px;">
            </td>
        </tr>
    </table>
</footer>
<!--end::Text-->
<script>
    $(function () {
        @if($examination->bukti_penyampaian_informasi)
        //alert("Anda Sudah Melakukan Tanda Tangan Bukti Penyampaian Informasi");
        //window.location.href = "https://kliniksatriabudi.com";
        @endif

        $(":submit").attr("disabled", true);

        $("#signature").bind('change', function (e) {
            const data = $("#signature").jSignature("getData", "default");
            $("#sign").val(data);
            $("#reset_signature").show();
            $("#save_signature").show();
            $("#download_pdf").hide(); 
            $(":submit").attr("disabled", true);
        });

        $("#save_signature").click(function () {
            $("canvas").css("pointer-events", "none");
            $("#save_signature").hide();
            $("#download_pdf").show(); 
            $(":submit").attr("disabled", false);
        });

        $("#reset_signature").click(function () {
            $("#signature").jSignature("reset");
            $("#save_signature").hide();
            $("#reset_signature").hide();
            $("#download_pdf").hide(); 
            $(":submit").attr("disabled", true);
            $("canvas").css("pointer-events", "");
            $("#sign").val("");
        });

        $("#signature_form").submit(function () {
            if ($("#sign").val() === "") {
                alert("Tanda tangan tidak boleh kosong");
                return false;
            } else {
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: $(this).serialize(),
                    success: function (response) {
                        alert(response.message);
                        window.location.href = "https://kliniksatriabudi.com";
                    }
                });
            }
        });

        // Handle Download PDF button click
        $("#download_pdf").click(function () {
            const pdfUrl = `/generate-pdf?id=${$('input[name="id"]').val()}`;
            
            window.open(pdfUrl, '_blank');
        });
    });
</script>
</body>
</html>
