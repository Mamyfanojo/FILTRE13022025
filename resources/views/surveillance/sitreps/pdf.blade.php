<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Export PDF - SITREP</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            text-align: left;
            margin: 50px;
        }
        .title {
            text-align: center;
            font-size: 16pt;
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            text-decoration: underline;
        }
        .content {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="title">SITREP {{ $sitrep->sitrep_sar }} – MRCC MADAGASCAR - {{ $sitrep->mrcc_madagascar }} </div>

    <div class="content"><span class="section-title">A – EVENT:</span></div>
    <div class="content">{{ $sitrep->event }}</div>
    
    <div class="content"><span class="section-title">B - POSITION:</span></div>
    <div class="content">{{ $sitrep->position }}</div>
    
    <div class="content"><span class="section-title">C - SITUATION:</span></div>
    <div class="content"> {{ $sitrep->alerted_at }} </div>
    <div class="content">{{ $sitrep->situation }}</div>
    
    <div class="content"><span class="section-title">D - NUMBER OF PERSONS:</span></div>
    <div class="content">{{ $sitrep->number_of_persons }} PERSONS INVOLVED</div>
    
    <div class="content"><span class="section-title">E - ASSISTANCE REQUIRED:</span></div>
    <div class="content">{{ $sitrep->assistance_required }}</div>
    
    <div class="content"><span class="section-title">F - COORDINATING RCC:</span></div>
    <div class="content">{{ $sitrep->coordinating_rcc }}</div>
    
    <div class="content"><span class="section-title">G - INITIAL ACTION TAKEN:</span></div>
    <div class="content">{!! nl2br(e($sitrep->initial_action_taken)) !!}</div>
    
    <div class="content"><span class="section-title">H - CHRONOLOGY:</span></div>
    <div class="content">{!! nl2br(e($sitrep->chronology)) !!}</div>
    
    <div class="content"><span class="section-title">I - ADDITIONAL INFORMATION:</span></div>
    <div class="content">{!! nl2br(e($sitrep->additional_information)) !!}</div>
</body>
</html>