<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>AVURNAV - {{ $avurnav->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        h1 { text-align: center; font-size: 20px; }
        .highlight { background-color: yellow; font-weight: bold; }
        .bold { font-weight: bold; }
        .contact { font-weight: bold; color: blue; }
        .title { font-weight: bold; text-decoration: underline; }
        .logo { text-align: center; margin-bottom: 20px; }
        .logo img { width: 150px; }
    </style>
</head>
<body>

    <!-- Logo -->
    <div class="logo">
        <img src="{{ public_path('images/aaaaaaaa.png') }}" alt="Logo">
    </div>

    <!-- Contenu -->
    <p class="title">AVURNAV LOCAL MADAGASCAR <span class="highlight">{{ $avurnav->avurnav_local }}</span></p>
    <p><span class="bold">ILE DE MADAGASCAR</span> – <span class="highlight">{{ $avurnav->ile }}</span></p>

    <p class="bold">VOUS SIGNALE <span class="highlight">{{ strtoupper($avurnav->vous_signale) }}</span></p>

    <p><span class="bold">1- POSITION :</span> {{ $avurnav->position }}</p>
    <p><span class="bold">2- NAVIRE :</span> <span class="highlight">{{ $avurnav->navire }}</span></p>
    <p><span class="bold">3- POB :</span> <span class="highlight">{{ $avurnav->pob }}</span></p>
    <p><span class="bold">4- TYPE :</span> {{ $avurnav->type }}</p>
    <p><span class="bold">5- CARACTÉRISTIQUES :</span> <span class="highlight">{{ $avurnav->caracteristiques }}</span></p>
    <p><span class="bold">6- ZONE :</span> <span class="highlight">{{ $avurnav->zone }}</span></p>
    <p><span class="bold">7- DERNIÈRE COMMUNICATION :</span> {{ $avurnav->derniere_communication }}</p>
    <p><span class="bold">8- CONTACTS :</span> <span class="contact">{{ $avurnav->contacts }}</span></p>

    <p>
        <span class="bold">TOUS LES USAGERS DE LA MER DANS CETTE ZONE SONT TENUS DE RENDRE COMPTE DE TOUTES INFORMATIONS DISPONIBLES AU MRCC – APMF SOIT PAR :</span>
    </p>
    <ul>
        <li class="bold">EMAIL : <span class="contact">mrccmadagascar@outlook.com / mrccmada@apmf.mg</span></li>
        <li class="bold">TEL : <span class="contact">032 11 258 96</span></li>
    </ul>

</body>
</html>

