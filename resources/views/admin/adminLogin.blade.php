<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Form</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 97%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-login {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-login:hover {
            background-color: #218838;
        }

        .resend-password {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }

        .resend-password:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="login-container">
        <h2>Login</h2>
        <form action="{{ route('adminLogin') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
        <a href="{{ route('resetPasswordAdmin') }}" class="resend-password">Resend Password</a>
        <a href="{{ route('login') }}" class="resend-password">Back</a>

    </div>

    <script>
        // GSAP animations
        gsap.from(".login-container", {
            duration: 1.5,
            opacity: 0,
            y: 50,
            ease: "power2.out"
        });

        gsap.from("h2", {
            duration: 1,
            opacity: 0,
            y: -50,
            delay: 0.5
        });

        gsap.from(".form-group", {
            duration: 1,
            opacity: 0,
            stagger: 0.3,
            x: -30,
            delay: 0.8
        });

        gsap.from(".btn-login", {
            duration: 1,
            opacity: 0,
            scale: 0.5,
            delay: 1.5
        });

        gsap.from(".resend-password", {
            duration: 1,
            opacity: 0,
            scale: 0.5,
            delay: 2
        });
    </script>
</body>

</html>
