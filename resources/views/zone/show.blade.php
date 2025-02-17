@extends('layout')

@section('content')

    <div class="container mt-5 text-center">
        <h2>Zone {{ $zoneId }}</h2>
        <p>Bienvenue dans la zone {{ $zoneId }} !</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Retour à l'accueil</a>
    </div>

@endsection