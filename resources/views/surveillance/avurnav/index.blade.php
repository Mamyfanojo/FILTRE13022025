@extends('surveillance.base')

@section('title', 'Liste des AVURNAV')

@section('topmenu')
    <div class="top-menu">
        <button class="btn btn-success">
            <a class="text-decoration-none text-white" href="{{ route('avurnav.create') }}">Créer AVURNAV</a>
        </button>
        <button class="btn btn-secondary">
            <a class="text-decoration-none text-white" href="{{ route('avurnav.index') }}">Liste AVURNAV</a>
        </button>
    </div>
@endsection

@section('content')
<div class="container">
    <h1 class="mt-4">Liste des Données AVURNAV</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-4 table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>AVURNAV Local</th>
                <th>Île</th>
                <th>Vous signale</th>
                <th>Position</th>
                <th>Navire</th>
                <th>POB</th>
                <th>Type</th>
                <th>Caractéristiques</th>
                <th>Zone</th>
                <th>Dernière Communication</th>
                <th>Contacts</th>
                <th style="width: 150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($avurnavs as $avurnav)
                <tr>
                    <td>{{ $avurnav->id }}</td>
                    <td>{{ $avurnav->avurnav_local }}</td>
                    <td>{{ $avurnav->ile }}</td>
                    <td>{{ $avurnav->vous_signale }}</td>
                    <td>{{ $avurnav->position }}</td>
                    <td>{{ $avurnav->navire }}</td>
                    <td>{{ $avurnav->pob }}</td>
                    <td>{{ $avurnav->type }}</td>
                    <td>{{ $avurnav->caracteristiques }}</td>
                    <td>{{ $avurnav->zone }}</td>
                    <td>{{ $avurnav->derniere_communication ?? 'Non disponible' }}</td>
                    <td>{{ $avurnav->contacts }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('export.pdf', $avurnav->id) }}" class="btn btn-secondary btn-sm">Exporter</a>
                            <!-- <a href="{{ route('export.pdf', $avurnav->id) }}" class="btn btn-success btn-sm">Voir détail</a> -->
                            <form action="" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet élément ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="13" class="text-center text-muted">Aucune donnée enregistrée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<style>
    table td {
        word-break: break-word; /* Empêche les débordements */
        max-width: 200px; /* Limite la largeur des colonnes */
    }

    td:last-child {
        width: 120px; /* Ajustement pour la colonne Actions */
    }
    .pagination {
        flex-wrap: wrap; /* Empêche le débordement */
        justify-content: center; /* Centre la pagination */
    }
</style>
@endsection