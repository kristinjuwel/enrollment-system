<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .card {
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 0;
            width: 100%;
            max-width: 400px;
            margin: auto;
            z-index: 9999; /* Add this line to set a higher z-index */
        }

        .card-body {
            padding: 20px;
        }

        .alert-danger {
            color: white;
            background-color: #dc3545;
            border-color: #dc3545;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
        }

        .btn-login {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h4>{{ __('Login') }}</h4>
                    </div>

                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="username" class="form-label">{{ __('Username') }}</label>
                                <input type="text" class="form-control" id="username" name="username" required autocomplete="username" value="{{ old('username') ?: '' }}">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-login">{{ __('Login') }}</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="{{ route('register') }}" style="color: black;">Register</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>