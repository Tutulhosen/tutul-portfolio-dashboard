@extends('layouts.dashboard')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            color: white;
            width: 250px;
            overflow-y: auto;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        .sidebar .nav-link {
            padding: 10px 15px;
        }

        .sidebar .nav-link.active {
            background-color: #495057;
            border-radius: 5px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .top-header {
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1030;
            background-color: #343a40;
            color: white;
        }

        .top-header .navbar-brand {
            color: white;
            text-decoration: none;
        }

        .dropdown-menu {
            background-color: #495057;
        }

        .dropdown-menu a {
            color: white;
        }

        .dropdown-menu a:hover {
            background-color: #6c757d;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="py-4 px-3 text-center">
            <h4>My Portfolio</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('about') }}">
                    <i class="bi bi-person"></i> About Me
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('skills') }}">
                    <i class="bi bi-tools"></i> Skills
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('projects') }}">
                    <i class="bi bi-folder"></i> Projects
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#portfolioMenu" role="button" aria-expanded="false" aria-controls="portfolioMenu">
                    <i class="bi bi-briefcase"></i> Portfolio
                </a>
                <div class="collapse" id="portfolioMenu">
                    <ul class="list-unstyled ms-3">
                        <li><a href="{{ route('gallery') }}" class="nav-link">Gallery</a></li>
                        <li><a href="{{ route('testimonials') }}" class="nav-link">Testimonials</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('contact') }}">
                    <i class="bi bi-envelope"></i> Contact
                </a>
            </li>
        </ul>
    </nav>

    <!-- Top Header -->
    <header class="top-header py-2 px-3 d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="navbar-brand">My Dashboard</a>
        <div class="dropdown">
            <a href="#" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i> Profile
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('settings') }}">Settings</a></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </div>
    </header>

    <!-- Main Content -->
    <div class="content">
        <div class="mt-5 pt-4">
            <h1>Welcome to Your Dashboard</h1>
            <p>This is your portfolio dashboard. Use the menu on the left to navigate through different sections.</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>

</html>

@endsection
