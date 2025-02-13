<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="position: ;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">katann APMF</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('avurnav.index') }}">Surveillance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("articles.index")}}">Liste des données</a>
                </li>
            </ul>
        </div>
    </div>
</nav>