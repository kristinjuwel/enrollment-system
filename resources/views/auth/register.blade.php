<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>
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
        }

        .card-body {
            padding: 20px;
        }

        .existing-account {
            text-align: center;
            margin-top: 20px;
        }

        .btn-register {
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
                        <h4>{{ __('Register') }}</h4>
                    </div>

                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-danger">{{ session('message') }}</div>
                        @endif

                        <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
                            @csrf

                            <div class="mb-3">
                                <label for="first_name" class="form-label">{{ __('First Name') }}</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required autocomplete="first_name">
                                <div id="firstNameError" class="text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <label for="middle_name" class="form-label">{{ __('Middle Name') }}</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name" autocomplete="middle_name">
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required autocomplete="last_name">
                                <div id="lastNameError" class="text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control" id="email" name="email" required autocomplete="email">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">{{ __('Username') }}</label>
                                <input type="text" class="form-control" id="username" name="username" required autocomplete="username">
                                <div id="usernameError" class="text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                                <div id="passwordError" class="text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">{{ __('Role') }}</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="student">Student</option>
                                    <option value="professor">Professor</option>
                                </select>
                                <div id="roleError" class="text-danger"></div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-register" onclick="validateForm(event)">{{ __('Register') }}</button>
                            </div>
                        </form>
                        <div class="existing-account">
                            <p>Already have an account? <a href="{{ route('login') }}" style="color: black;">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm(event) {
            const firstNameField = document.getElementById('first_name');
            const firstNameError = document.getElementById('firstNameError');
            const lastNameField = document.getElementById('last_name');
            const lastNameError = document.getElementById('lastNameError');
            const usernameField = document.getElementById('username');
            const usernameError = document.getElementById('usernameError');
            const passwordField = document.getElementById('password');
            const passwordError = document.getElementById('passwordError');
            const roleField = document.getElementById('role');
            const roleError = document.getElementById('roleError');
            let isValid = true;

            if (firstNameField.value.trim() === '') {
                firstNameError.innerText = 'First Name is required.';
                isValid = false;
            } else {
                firstNameError.innerText = '';
            }

            if (lastNameField.value.trim() === '') {
                lastNameError.innerText = 'Last Name is required.';
                isValid = false;
            } else {
                lastNameError.innerText = '';
            }

            if (usernameField.value.trim() === '') {
                usernameError.innerText = 'Username is required.';
                isValid = false;
            } else {
                usernameError.innerText = '';
            }

            if (passwordField.value.length < 6) {
                passwordError.innerText = 'Password must be at least 6 characters long.';
                isValid = false;
            } else {
                passwordError.innerText = '';
            }

            if (roleField.value.trim() === '') {
                roleError.innerText = 'Role is required.';
                isValid = false;
            } else {
                roleError.innerText = '';
            }

            if (!isValid) {
                event.preventDefault(); // Prevent form submission
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
