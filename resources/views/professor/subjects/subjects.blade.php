<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Subjects</title>
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

        .btn-enroll {
            background-color: transparent;
            color: maroon;
            border: none;
            font-weight: bold;
            text-decoration: underline; 
        }

        .btn-edit {
            background-color: transparent;
            color: white;
            border: none;
            text-decoration: underline; 
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
        <!-- Display success message if it exists -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <h1>Subjects</h1>

        <!-- Add Subject button -->
        <button class="btn btn-primary mb-3" onclick="toggleSubjectForm()">Add Subject</button>

        <!-- Subject creation form (hidden by default) -->
        <div id="subject-form" style="display: none;">
            <form method="POST" action="{{ route('subject.create') }}">
                @csrf
                <div class="mb-3">
                    <label for="course_id" class="form-label">Course ID</label>
                    <input type="text" class="form-control" id="course_id" name="course_id" required>
                </div>
                <div class="mb-3">
                    <label for="course_name" class="form-label">Course Name</label>
                    <input type="text" class="form-control" id="course_name" name="course_name" required>
                </div>
                <div class="mb-3">
                    <label for="slots" class="form-label">Available Slots</label>
                    <input type="number" class="form-control" id="slots" name="slots" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Create Subject</button>
                </div>
            </form>
        </div>

        <!-- Display the list of subjects -->
        @if ($subjects->isEmpty())
            <p>No subjects available.</p>
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
                    <div class="col-md-{{ $colSize }}">
                        <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="card-title">{{ $subject->course_name }} <i><a href="{{ route('subject.edit', ['subjectId' => $subject->id]) }}" class="btn btn-edit">Edit Subject</a></i></h5>
                                </div>
                                <div class="card-body">
                                <p class="card-text">Course ID: {{ $subject->course_id }}</p>
                                <p class="card-text">Available Slots: {{ $subject->slots }}</p>
                                <p class="card-text">Total Enrollees: {{ $enrollments->where('subject_id', $subject->id)->count() }}</p>
                                <button class="btn btn-enroll" onclick="toggleEnrollees({{ $subject->id }})">View Enrollees</button>
                                <div id="enrollees-{{ $subject->id }}" class="enrollees" style="display: none;">
                                    @if ($enrollments->isEmpty())
                                        <p>No students enrolled</p>
                                    @else
                                        <ul>
                                            @foreach ($enrollments as $enrollment)
                                                @if ($enrollment->subject_id == $subject->id)
                                                    <li>
                                                        @foreach($students as $student)
                                                            @if($enrollment->student_id == $student->id)
                                                                {{ $student->first_name}} {{ $student->middle_name}} {{$student->last_name}} 
                                                            @endif 
                                                        @endforeach
                                                        <form method="POST" action="{{ route('enrollment.remove', ['subjectId' => $subject->id, 'enrollmentId' => $enrollment->id]) }}">
                                                            @csrf
                                                            @method('DELETE') <!-- Add this line to override the method -->
                                                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                                        </form>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        function toggleEnrollees(subjectId) {
            var enrolleesDiv = document.getElementById('enrollees-' + subjectId);
            if (enrolleesDiv.style.display === "none") {
                enrolleesDiv.style.display = "block";
            } else {
                enrolleesDiv.style.display = "none";
            }
        }

        function toggleSubjectForm() {
            var subjectForm = document.getElementById('subject-form');
            if (subjectForm.style.display === "none") {
                subjectForm.style.display = "block";
            } else {
                subjectForm.style.display = "none";
            }
        }
    </script>
</body>
</html>
