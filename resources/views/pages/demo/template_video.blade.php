<!DOCTYPE html>
<html>
<head>
    <title>{{ $template->nama_template }}</title>

    <style>
        body {
            margin: 0;
            background-color: #0f172a;
            font-family: Arial, sans-serif;
            color: #fff;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .title {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .video-box {
            width: 90%;
            max-width: 1000px;
        }

        video {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color: #000;
            background: #fff;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
        }
    </style>
</head>

<body>

<a href="{{ url()->previous() }}" class="back-btn">← Kembali</a>

<div class="container">
    
    <div class="title">
        {{ $template->nama_template }}
    </div>

    <div class="video-box">
        <video controls>
            <source src="{{ asset('storage/'.$template->preview_video) }}" type="video/mp4">
            Browser tidak mendukung video
        </video>
    </div>

</div>

</body>
</html>