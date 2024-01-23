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

        .enrollment {
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

        h4 {
            margin-top: 0;
            margin-bottom: 20px;
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

    <div class="enrollment">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Enrollment Summary
                    </div>
                    <div class="card-body">
                        <h4>Your recent enrollments:</h4>
                        @if (empty($enrollments))
                            <p>No subjects enrolled.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($enrollments as $enrollment)
                                    @php
                                        $subject = \App\Models\Subject::find($enrollment->subject_id);
                                        $professor = \App\Models\User::find($enrollment->prof_id);
                                        $professorName = $professor->first_name;
                                        if ($professor->middle_name) {
                                            $professorName .= ' ' . $professor->middle_name;
                                        }
                                        $professorName .= ' ' . $professor->last_name;
                                    @endphp
                                    <li class="list-group-item">
                                        <strong>Subject ID:</strong> {{ $enrollment->subject_id }}<br>
                                        <strong>Course ID:</strong> {{ $subject->course_id }}<br>
                                        <strong>Course Name:</strong> {{ $subject->course_name }}<br>
                                        <strong>Professor Name:</strong> {{ $professorName }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <a href="{{ route('student.enrollment.summary.total') }}" class="btn btn-enroll">View Total Enrollment Summary</a>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>
