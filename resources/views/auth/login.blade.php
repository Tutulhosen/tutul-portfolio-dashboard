<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .login-container {
            width: 80%;
            max-width: 1100px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        }

        .left-section {
            background: url('https://source.unsplash.com/600x800/?technology,design') no-repeat center center;
            background-size: cover;
            position: relative;
            min-height: 100%;
        }

        .left-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .left-section .overlay-text {
            position: absolute;
            color: white;
            text-align: center;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .right-section {
            padding: 50px;
        }

        .login-form .form-control {
            border-radius: 30px;
        }

        .login-btn {
            border-radius: 30px;
            padding: 10px 25px;
            background-color: #007bff;
            color: white;
        }

        .login-btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .left-section {
                display: none;
            }

            .right-section {
                padding: 30px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container d-flex">
        <!-- Left Section -->
        <div class="left-section col-6 d-none d-md-block">
            <div class="overlay-text">
                <h1 class="fw-bold">Welcome Back!</h1>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section col-md-6">
            <h2 class="text-center mb-4">Login</h2>
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <div class="text-danger mt-1">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <div class="text-danger mt-1">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" id="remember_me" name="remember" class="form-check-input">
                        <label class="form-check-label" for="remember_me">Remember Me</label>
                    </div>
                </div>

                <!-- Login Button -->
                <div class="mb-3 text-center">
                    <button type="submit" class="btn login-btn w-100">Login</button>
                </div>

                <!-- Additional Links -->
                <div class="text-center">
                    @if (Route::has('register'))
                        <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
                    @endif
                    @if (Route::has('password.request'))
                        <p><a href="{{ route('password.request') }}">Forgot Password?</a></p>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
