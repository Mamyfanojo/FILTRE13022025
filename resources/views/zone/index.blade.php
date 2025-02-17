
@extends('layout')

@section('content')

    <div class="container mt-5">
        <h2 class="mb-4 text-center">📜 Liste des données</h2>

        

        <!-- Boutons pour accéder aux zones -->
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
            @for ($i = 1; $i <= 9; $i++)
                <a href="{{ route('zone.show', ['id' => $i]) }}" class="btn btn-info">
                    Zone {{ $i }}
                </a>
            @endfor
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Formulaire d'import CSV -->
        <div class="card p-3 mb-4 shadow-sm">
            <form action="{{ route('zone.import', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <input type="file" name="csv_file" class="form-control" required>
                    <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Importer CSV</button>
                </div>
            </form>
        </div>

        <!-- TABLE RESPONSIVE -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Flag</th>
                        <th>Vessel Name</th>
                        <th>Registered Owner</th>
                        <th>Call Sign</th>
                        <th>MMSI</th>
                        <th>IMO</th>
                        <th>Ship Type</th>
                        <th>Destination</th>
                        <th>ETA</th>
                        <th>Navigation Status</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Age</th>
                        <th>Time Of Fix</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td><small>{{ $article->id }}</small></td>
                            <td><small>{{ $article->flag }}</small></td>
                            <td><small>{{ $article->vessel_name }}</small></td>
                            <td><small>{{ $article->registered_owner }}</small></td>
                            <td><small>{{ $article->call_sign }}</small></td>
                            <td><small>{{ $article->mmsi }}</small></td>
                            <td><small>{{ $article->imo }}</small></td>
                            <td><small>{{ $article->ship_type }}</small></td>
                            <td><small>{{ $article->destination }}</small></td>
                            <td><small>{{ $article->eta }}</small></td>
                            <td><small>{{ $article->navigation_status }}</small></td>
                            <td><small>{{ $article->latitude }}</small></td>
                            <td><small>{{ $article->longitude }}</small></td>
                            <td><small>{{ $article->age }}</small></td>
                            <td><small>{{ $article->time_of_fix }}</small></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $articles->links() }}
        </div>

    <style>
        table td {
            word-break: break-word; 
            max-width: 150px; 
        }
        td:last-child {
            width: 120px;
        }
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>

@endsection
