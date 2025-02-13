<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Export PDF - Pollution</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .logo {
            margin-top: 20px;
        }
        img {
            max-width: 150px;
            height: auto;
        }
        .content {
            margin: 50px auto;
            text-align: left;
            width: 70%;
            padding: 20px;
        }
        .data-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .section {
            font-size: 18px;
            flex: 1;
        }
        .section-title {
            font-weight: bold;
        }
        .data-value {
            color: orange;
            font-weight: bold;
        }
        .image-container {
            flex: 1;
            text-align: center;
            margin: 20px auto;
        }
        .image-container img {
            max-width: 400px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path('images/aaaaaaaa.png') }}" alt="Logo">
    </div>

    <div class="content">
        <div class="data-container">
            <div class="section">
                <span class="section-title">Pollution SRR Madagascar N° :</span>
                <span class="data-value">{{ $pollution->numero }}</span>
            </div>
        </div>
        <div class="data-container">
            <div class="section">
                <span class="section-title">Zone :</span>
                <span class="data-value">{{ $pollution->zone }}</span>
            </div>
        </div>
        <div class="data-container">
            <div class="section">
                <span class="section-title">Coordonnées Géographiques :</span>
                <span class="data-value">{{ $pollution->coordonnees }}</span>
            </div>
        </div>
        <div class="data-container">
            <div class="section">
                <span class="section-title">Type Pollution :</span>
                <span class="data-value">{{ $pollution->type_pollution }}</span>
            </div>
        </div>
        <div class="data-container">
            <div class="section">
                <span class="section-title">Insertion Images Satellites :</span>
            </div>
            <div class="image-container">
                <img src="{{ public_path('storage/' . $pollution->image_satellite) }}">
            </div>
        </div>
    </div>
</body>
</html>
