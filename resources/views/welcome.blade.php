<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Student Enlistment</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    <style>
        body {
            background-image: url('https://www.upm.edu.ph/sites/default/files/CAS.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .center-box {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .content {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.7);
            padding: 2rem;
            border-radius: 0.25rem;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="center-box">
        <div class="content">
            <h1 class="text-center mt-4 text-4xl font-semibold">Welcome to the SAIS 2.0</h1>
            <div class="mt-4">
                <button type="button" onclick="window.location.href='{{ route('login') }}'" class="px-4 py-2 font-semibold btn btn-dark" style="background-color: black; color: white;">Login</button>
                <button type="button" onclick="window.location.href='{{ route('register') }}'" class="px-4 py-2 ml-4 font-semibold btn btn-dark" style="background-color: black; color: white;">Register</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
