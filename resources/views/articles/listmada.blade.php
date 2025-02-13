@extends('layout')

@section('content')

    <div class="container mt-5">
        <h2 class="mb-4 text-center">📜 Liste des données MADA</h2>

        <div class="d-flex justify-content-between flex-wrap mb-3">
            <a href="{{ route('listmadas.export') }}" class="btn btn-success">
                <i class="fas fa-file-csv"></i> Exporter tous les listmadas
            </a>
            <a href="{{ route('listmadas.export') }}" class="btn btn-primary">
                <i class="fas fa-file-csv"></i> Retour
            </a>
        </div>

        <!-- Formulaire d'import CSV -->
        <div class="card p-3 mb-4 shadow-sm">
            <form action="{{ route('listmadas.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <input type="file" name="csv_file" class="form-control" required>
                    <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Importer CSV</button>
                </div>
            </form>
        </div>

        <!-- Formulaire de filtre -->
        <div class="card p-3 mb-4 shadow-sm">
            <form method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label for="year">Année :</label>
                        <input type="number" name="year" id="year" class="form-control" placeholder="YYYY" 
                               value="{{ request('year') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="month">Mois :</label>
                        <input type="number" name="month" id="month" class="form-control" placeholder="MM" min="1" max="12" 
                               value="{{ request('month') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="day">Jour :</label>
                        <input type="number" name="day" id="day" class="form-control" placeholder="DD" min="1" max="31" 
                               value="{{ request('day') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="start_date">Date de début :</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" 
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="end_date">Date de fin :</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" 
                               value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3 mt-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                    </div>
                </div>
            </form>
            
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
                    @foreach ($listmadas as $listmada)
                        <tr>
                            <td><small>{{ $listmada->id }}</small></td>
                            <td><small>{{ $listmada->flag }}</small></td>
                            <td><small>{{ $listmada->vessel_name }}</small></td>
                            <td><small>{{ $listmada->registered_owner }}</small></td>
                            <td><small>{{ $listmada->call_sign }}</small></td>
                            <td><small>{{ $listmada->mmsi }}</small></td>
                            <td><small>{{ $listmada->imo }}</small></td>
                            <td><small>{{ $listmada->ship_type }}</small></td>
                            <td><small>{{ $listmada->destination }}</small></td>
                            <td><small>{{ $listmada->eta }}</small></td>
                            <td><small>{{ $listmada->navigation_status }}</small></td>
                            <td><small>{{ $listmada->latitude }}</small></td>
                            <td><small>{{ $listmada->longitude }}</small></td>
                            <td><small>{{ $listmada->age }}</small></td>
                            <td><small>{{ $listmada->time_of_fix }}</small></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('listmadas.destroy', $listmada->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    <style>
        table td {
            word-break: break-word;
            max-width: 150px;
        }

        td:last-child {
            width: 120px;
        }
    </style>
@endsection
