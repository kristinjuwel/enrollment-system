<!-- dashboard.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Professor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .navbar {
            background-color: maroon;
            color: white;
        }

        .navbar .navbar-brand {
            color: white;
        }

        .navbar .nav-link {
            color: white;
            margin-right: 10px; 
        }

        .navbar .nav-link:hover {
            text-decoration: underline;
        }

        .navbar .btn-logout {
            background-color: maroon;
            border-color: maroon;
        }

        .navbar .btn-logout:hover {
            background-color: darkred;
            border-color: darkred;
        }

        .banner-logo {
            width: 40px; 
            height: auto; 
            margin-right: 10px; 
        }

        .profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        .profile-card {
            width: 500px;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            font-size: 20px;
        }

        .profile-card p {
            margin-bottom: 10px;
        }

        .btn-primary {
            display: block;
            margin-bottom: 10px;
            background-color: maroon;
            border-color: maroon;
        }

        .btn-primary:hover {
            background-color: #800000;
            border-color: #800000;
        }

        body {
            background-color: #f9f9f9;
            color: #333;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('professor.dashboard') }}">
            <img src="https://up.edu.ph/wp-content/uploads/2020/01/UP-Seal.png" alt="Logo" class="banner-logo">
            Professor Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('professor.profile.edit') }}">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('subjects.index') }}">Subjects</a>
                    </li>
                </ul>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary btn-logout">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <br /> 
        <h1>Welcome, Professor {{ auth()->user()->first_name }}!</h1>

        <!-- Display success message if it exists -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class ="profile">
            <br /> 
            <br /> 
            <h2>Profile</h2>
            <br /> 
            <div class= "profile-card">
                <!-- Display profile -->
                <p><strong>Name:</strong> {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Username:</strong> {{ auth()->user()->username }}</p>
            </div>
            <br /> 
            <a href="{{ route('professor.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
