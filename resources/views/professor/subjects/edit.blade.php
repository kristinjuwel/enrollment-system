<!-- edit.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content {
            max-width: 60vw;
            margin: 0 auto;
            padding: 20px;
            font-size: 21px;
        }

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

        .edit {
            background-color: #f9f9f9;
            color: #333;
            max-width: 60vw;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .alert {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            margin-bottom: 10px;
            font-size:19px;
        }

        .btn-primary {
            background-color: maroon;
            border-color: maroon;
            margin-right: 10px;
        }

        .btn-primary:hover {
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
    
    <div class="content">
    </br>
        <h1>Edit Subject</h1>

        <!-- Display any error messages if they exist -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Subject edit form -->
        <form method="POST" action="{{ route('subject.update', ['subjectId' => $subject->id]) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="course_id" class="form-label">Course ID</label>
                <input type="text" class="form-control" id="course_id" name="course_id" value="{{ $subject->course_id }}" required>
            </div>
            <div class="mb-3">
                <label for="course_name" class="form-label">Course Name</label>
                <input type="text" class="form-control" id="course_name" name="course_name" value="{{ $subject->course_name }}" required>
            </div>
            <div class="mb-3">
                <label for="slots" class="form-label">Available Slots</label>
                <input type="number" class="form-control" id="slots" name="slots" value="{{ $subject->slots }}" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update Subject</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
