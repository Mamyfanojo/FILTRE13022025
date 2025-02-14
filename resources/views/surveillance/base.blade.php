<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- CDN Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 10;
            background: #343a40;
            color: white;
            padding-top: 20px;
        } */
       
        .sidebar a:hover {
            background: #495057;
        }
        .top-menu {
            z-index: 999;
            position: absolute;
            right: 20px;
            top: 10px;
            display: inline;
        }
        .bottom-center { 
            position: absolute;
            left: 20%;
        }
        .activee {
            background-color:rgba(110, 116, 121, 0.86);
        }
        .format{
            width: 1000px;
        }

        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 10;
            background: #212529;
            color: white;
            padding-top: 20px;
            transition: all 0.3s;
        }
        .sidebar h4 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: bold;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        /* .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
        } */
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover, .sidebar .activee {
            background: #495057;
            border-left: 4px solid #ffc107;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
        }

      
    </style>
</head>
<body>

    @include('navbar')

    <div class="sidebar">
        <h4>Menu</h4>
        <a href="{{ url('/avurnav') }}" class="{{ request()->is('avurnav*') ? 'activee' : '' }}">
            <i class="fas fa-ship"></i> FORMAT AVURNAV
        </a>
        <a href="{{ url('/pollutions') }}" class="{{ request()->is('pollution*') ? 'activee' : '' }}">
            <i class="fas fa-smog"></i> POLLUTIONS
        </a>
        <a href="{{ url('/sitreps') }}" class="{{ request()->is('sitrep*') ? 'activee' : '' }}">
            <i class="fas fa-file-alt"></i> FORMAT SITREP
        </a>
    </div>
    <div class="container-fluid">
        @yield('topmenu')
        <div class="bottom-center">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
