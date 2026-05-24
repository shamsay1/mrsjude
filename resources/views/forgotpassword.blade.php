<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Forgot password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;

            /* HOTEL STYLE BACKGROUND */
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        }

        .login-card {
            width: 380px;
            background: #fff;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .login-title {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
            color: #2c5364;
        }

        .input-group-text {
            background: #fff;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .toggle-password {
            cursor: pointer;
        }

        .btn-login {
            background: #2c5364;
            color: #fff;
            border-radius: 10px;
            padding: 10px;
        }

        .btn-login:hover {
            background: #203a43;
            color: white;
            font-weight: bolder;
        }

        /* RESPONSIVE */
        @media(max-width: 500px) {
            .login-card {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="login-card">
    
    <h4 class="login-title text-center">
        Teachers Daily Recording <br> Management System
    </h4>

    <p class="text-center text-muted mb-3" style="font-size: 14px;">
        Enter your email to reset the password
    </p>

    <form action="{{ route('password.email') }}" method="post">
       @csrf
        <!-- Email -->
        <div class="mb-3 input-group">
            <span class="input-group-text">
                <i class="bi bi-envelope"></i>
            </span>
            <input type="email" name="email" class="form-control" placeholder="Enter email" required>
        </div>

        <!-- Forgot password -->
        

        <!-- Button -->
        @if(session("success"))
            <span style="color: green">{{ session("success") }}</span>
        @endif
        <button type="submit" class="btn btn-login w-100">
            Send Link
        </button>
        <div class="text-center mb-3 mt-3">
            <a href="{{ route('login') }}" style="font-size: 13px; text-decoration: none;">
                Back to login
            </a>
        </div>
        

    </form>

</div>


</body>
</html>