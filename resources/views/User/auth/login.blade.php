<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In - ISA</title>

    <!-- FAVICON -->
    <link rel="shortcut icon" href="frontends/images/logo/logo.png" type="image/x-icon" />

    <!-- FOR BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .container-fluid {
            height: 100vh;
        }

        h2 {
            color: #122444;
            font-weight: bolder;
        }

        .image-section {
            background: url('/images/login-bg.png');
            height: 100vh;
            object-fit: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .form-section {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f1f5f9;
            color: #122444;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            height: 100vh;
            position: relative;
        }

        .form-control:focus {
            outline: none;
            box-shadow: none;
            border: 1px solid #064e3b;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            position: absolute;
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
        }

        .btn {
            border: 1px solid #122444;
            background-color: none;
            color: #122444;
            font-weight: bold;
            border-radius: 999px;
            padding: 10px 0;
            font-size: 20px;
        }

        .btn:hover {
            color: #f1f5f9;
            background-color: #122444;
        }

        .form-container.hidden {
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
        }

        .toggle-btn {
            cursor: pointer;
            color: #064e3b;
            text-decoration: underline;
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-12 form-section">
                <div class="form-container" id="loginForm">
                    <h2 class="mb-3 text-center">Login</h2>
                    <h6 class="mb-4 text-center">
                        Welcome back! Log in to access your account and request a quote.
                    </h6>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required />
                        </div>
                        @if ($errors->has('login_error'))
                        <div class="">
                            {{ $errors->first('login_error') }}
                        </div>
                        @endif

                        @if ($errors->any() && !$errors->has('login_error'))
                        <div class="mb-3">
                            @foreach ($errors->all() as $error)
                            <span style="color: rgb(133, 11, 11)"> {{ $error }}</span>
                            @endforeach
                        </div>
                        @endif
                        <button type="submit" class="btn shadow-none w-100">Login</button>
                    </form>
                    <p class="mt-3 text-center">
                        Don't have an account?
                        <span class="toggle-btn" onclick="toggleForms()">Register</span>
                    </p>
                </div>
                <div class="form-container hidden" id="registerForm">
                    <h2 class="mb-3 text-center">Register</h2>
                    <h6 class="mb-4 text-center">
                        Join us today! Create an account to get started and request a
                        quote.
                    </h6>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="d-flex gap-2">
                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="fname" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="lname" class="form-control" required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirmpassword" class="form-control" required />
                        </div>
                        <button type="submit" class="btn shadow-none w-100">
                            Register
                        </button>
                    </form>
                    <p class="mt-3 text-center">
                        Already have an account?
                        <span class="toggle-btn" onclick="toggleForms()">Login</span>
                    </p>
                </div>
            </div>
            <div class="col-md-6 image-section d-none d-md-block"></div>
        </div>
    </div>

    <script>
        function toggleForms() {
        const loginForm = document.getElementById("loginForm");
        const registerForm = document.getElementById("registerForm");

        loginForm.classList.toggle("hidden");
        registerForm.classList.toggle("hidden");
      }
    </script>
</body>

</html>