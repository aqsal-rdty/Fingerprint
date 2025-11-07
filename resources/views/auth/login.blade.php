<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background: linear-gradient(135deg, #4A90E2, #1C6DD0);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            background-color: #fff;
            border-radius: 15px;
            padding: 2rem;
            width: 380px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .login-card h3 {
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .form-control {
            border-radius: 10px;
            padding: 0.75rem;
        }
        .btn-login {
            border-radius: 10px;
            padding: 0.75rem;
            background: linear-gradient(90deg, #4A90E2, #1C6DD0);
            border: none;
        }
        .btn-login:hover {
            opacity: 0.9;
        }
        .icon-circle {
            width: 60px;
            height: 60px;
            background-color: #fff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 1rem auto;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .demo-accounts {
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #555;
            text-align: center;
        }
        .demo-accounts div {
            margin: 0.3rem 0;
        }
        .demo-accounts span {
            font-weight: bold;
            color: #1C6DD0;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="icon-circle">
            <i class="fa-solid fa-shield-halved fa-2x text-primary"></i>
        </div>
        <h3 class="text-center">Fingerprint Login</h3>
        <p class="text-center text-muted mb-4">Sign in to Admin</p>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="text" name="username" class="form-control" placeholder="Enter your email" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button class="btn btn-login w-100 text-white"><i class="fa-solid fa-right-to-bracket me-2"></i> Sign In</button>
        </form>
        <p class="text-center text-muted mt-3" style="font-size:0.75rem;">© 2025 Fingerprint. All rights reserved.</p>
    </div>
</body>
</html>
