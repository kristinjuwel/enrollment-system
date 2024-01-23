<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>All Subjects</title>
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

        .subjects {
            max-width: 100vw;
            margin: 0 auto;
            padding: 20px;
            justify-content: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .alert {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
            margin-top: 30px;
            width: 70vw;
            margin-left: auto;
            margin-right: auto;
        }

        .input-group .form-control {
            height: 50px;
            margin-top:10px;
        }

        .input-group-append .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        h2 {
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .card {
            margin-bottom: 20px;
            max-width: 400px;
        }

        .card-header {
            background-color: maroon;
            color: white;
            padding: 10px;
        }

        .card-body {
            background-color: white;
            color: black;
            padding: 15px;
        }

        .card-title {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .card-text {
            margin-bottom: 5px;
        }

        .btn-primary {
            background-color: maroon;
            border-color: maroon;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #800000;
            border-color: #800000;
        }

        .btn-danger {
            background-color: maroon;
            border-color: maroon;
        }

        .btn-danger:hover {
            background-color: #800000;
            border-color: #800000;
        }

        .btn-secondary {
            background-color: maroon;
            border-color: maroon;
        }

        .btn-secondary:hover {
            background-color: #800000;
            border-color: #800000;
        }

        .btn-secondary.mt-3 {
            display: block;
            margin-bottom: 10px;
            background-color: maroon;
            border-color: maroon;
        }

        .btn-primary.mt-3:hover {
            background-color: #800000;
            border-color: #800000;
        }

        .search-btn {
            background-color: maroon;
            border-color: maroon;
            margin-top: 10px;
            height: 50px;
            color: white;
        }

        .search-btn:hover {
            background-color: #800000;
            border-color: #800000;
        }

        .view-cart {
            text-align: center;
            margin-top: 30px;
        }

        .view-cart .btn-primary {
            display: inline-block;
        }

        .btn-cart {
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

    <div class="subjects">
        <h1>All Subjects</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('student.search') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search subjects">
                <div class="input-group-append">
                    <button type="submit" class="btn search-btn">Search</button>
                </div>
            </div>
        </form>

        <br />

        @if ($subjects->isEmpty())
            <p>No subjects found.</p>
        @else
            @php
                $subjectsPerRow = 4;
                $subjectsCount = $subjects->count();
                $subjectsPerRow = min($subjectsCount, $subjectsPerRow);
                $subjectsPerCol = ceil($subjectsCount / $subjectsPerRow);
                $colSize = 12 / $subjectsPerRow;
            @endphp

            <div class="row">
                @foreach ($subjects as $subject)
                    @php
                        $subjectInCart = $cartSubjects->contains('id', $subject->id);
                    @endphp
                    <div class="col-md-{{ $colSize }}">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title">{{ $subject->course_name }}</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Course ID: {{ $subject->course_id }}</p>
                                <p class="card-text">Slots Available: {{ $subject->slots }}</p>
                                @if ($subjectInCart)
                                    <form action="{{ route('student.cart.remove', $subject->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Remove from Cart</button>
                                    </form>
                                @else
                                    <form action="{{ route('student.cart.add', $subject->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="view-cart">
            <a href="{{ route('student.cart') }}" class="btn btn-cart">View Cart</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
