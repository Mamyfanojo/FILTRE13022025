@extends('surveillance.base')
@section('content')

@section('topmenu')
    <div class="top-menu">
        <button class="btn btn-success">
            <a class="text-decoration-none text-white" href="{{ route('sitreps.create') }}">Créer SITREP</a>
        </button>
        <button class="btn btn-secondary">
            <a class="text-decoration-none text-white" href="{{ route('sitreps.index') }}">Liste SITREP</a>
        </button>
    </div>
@endsection

<div class="container format mt-5">
    <h2>Créer un nouveau SITREP</h2>
    <form action="{{ route('sitreps.store') }}" method="POST">
        @csrf
        <div class="row">
        <div class="row">
            @foreach(['sitrep_sar', 'mrcc_madagascar', 'event', 'position', 'situation', 'number_of_persons', 'assistance_required', 'coordinating_rcc', 'initial_action_taken', 'chronology', 'additional_information'] as $index => $field)
                @if($field === 'additional_information')
                    </div> <!-- Ferme la dernière ligne existante -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                            <input type="text" name="{{ $field }}" class="form-control" required>
                        </div>
                    </div>
                @else
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        <input type="text" name="{{ $field }}" class="form-control" required>
                    </div>
                    
                    @if($index % 2 == 1)
                        </div><div class="row">
                    @endif
                @endif
            @endforeach
        </div>

    </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection