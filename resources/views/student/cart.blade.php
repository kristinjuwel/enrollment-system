<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cart</title>
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

        body {
            background-color: #f9f9f9;
            color: #333;
        }

        .cart {
            max-width: 100vw;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .card-header {
            background-color: maroon;
            color: white;
            font-size: 24px;
            padding: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .list-group-item {
            margin-bottom: 10px;
            background-color: white;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            padding: 1rem;
        }

        .list-group-item:last-child {
            margin-bottom: 0;
        }

        .btn-primary {
            background-color: maroon;
            border-color: maroon;
            color: white;
        }

        .btn-primary:hover {
            background-color: maroon;
            border-color: maroon;
        }

        .btn-secondary {
            background-color: maroon;
            border-color: maroon;
            color: white;
        }

        .btn-secondary:hover {
            background-color: maroon;
            border-color: maroon;
        }

        .btn-danger {
            background-color: transparent;
            color: maroon;
            border: none;
            font-weight: bold;
            text-decoration: none; 
        }

        .btn-danger:hover {
            text-decoration: underline; 
        }

        .btn-enroll {
            background-color: transparent;
            color: maroon;
            border: none;
            font-weight: bold;
            text-decoration: underline; 
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('student.dashboard') }}">
            <img src="https://up.edu.ph/wp-content/uploads/2020/01/UP-Seal.png" alt="Logo" class="banner-logo">
            Student Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.subjects') }}">All Subjects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.cart') }}">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.enrollment.summary.total') }}">Total Enrollment Summary</a>
                </li>
            </ul>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-secondary btn-logout">Logout</button>
        </form>
    </div>
</nav>
<div class="cart">
    <div class="row">
    <div class="col-md-8 offset-md-2">
    <div class="card">
        <div class="card-header">
            Cart
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($cartSubjects->isEmpty())
                <p>Cart is empty.</p>
            @else
                <ul class="list-group mb-3">
                    @foreach ($cartSubjects as $cartSubject)
                        <li class="list-group-item">{{ $cartSubject->course_name }} <a href="{{ route('student.cart.remove', $cartSubject->id) }}" class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.getElementById('remove-form-{{ $cartSubject->id }}').submit();">Remove</a></li>
                        <form id="remove-form-{{ $cartSubject->id }}" action="{{ route('student.cart.remove', $cartSubject->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endforeach
                </ul>
                <form action="{{ route('student.cart.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Checkout</button>
                </form>
            @endif

          </div>
    </div>
    <a href="{{ route('student.enrollment.summary') }}" class="btn btn-enroll">View Enrollment Summary</a>
  
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
