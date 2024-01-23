<!-- enrolled_students.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Enrolled Students - {{ $subject->course_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Enrolled Students - {{ $subject->course_name }}</h1>

        <!-- Display success message if it exists -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Display error message if it exists -->
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Display the number of enrolled students -->
        <h2>Enrolled Students: {{ $subject->enrolledStudents->count() }}</h2>

        <!-- Display the list of enrolled students -->
        @if (empty($enrollments))
            <p>No students enrolled in this subject.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subject->enrolledStudents as $enrollment)
                        <tr>
                            <td>{{ $enrollment->student->id }}</td>
                            <td>{{ $enrollment->student->name }}</td>
                            <td>
                                <form method="POST" action="{{ route('enrollment.remove', ['subjectId' => $subject->id, 'enrollmentId' => $
