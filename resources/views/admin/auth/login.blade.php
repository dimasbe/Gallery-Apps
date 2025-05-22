<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #AD1500;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .card {
            background-color: #fff;
            padding: 2.5rem 2rem;
            border-radius: 2rem;
            width: 100%;
            max-width: 390px;
            text-align: center;
            box-shadow: 0 12px 25px rgba(0,0,0,0.12);
        }

        .card img {
            width: 90px;
            margin: 0 auto 1rem;
            display: block;
        }

        .card h2 {
            font-weight: 600;
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
        }

        .card p {
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            color: #444;
        }

        .form-control {
            text-align: left;
            margin-bottom: 1.25rem;
            position: relative;
        }

        .form-control label {
            font-weight: 500;
            margin-bottom: 0.4rem;
            display: block;
            font-size: 0.875rem;
        }

        .form-control input {
            width: 100%;
            padding: 0.65rem 1rem;
            padding-right: 2.5rem;
            border: 1px solid #ccc;
            border-radius: 1rem;
            font-size: 0.9rem;
            background-color: #fff;
            color: #333;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            cursor: pointer;
            z-index: 10;
        }

        .toggle-password svg {
            width: 20px;
            height: 20px;
            stroke: #666;
            fill: none;
        }

        .btn {
            width: 100%;
            background-color: #AD1500;
            color: #fff;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            border-radius: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #921300;
        }

        .error {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('images/logo2.png') }}" alt="Admin Icon" class="logo">
        <h2>Login Admin</h2>
        <p>Silahkan Login Terlebih Dahulu</p>

        <form method="POST" action="{{ route('admin.login.store') }}">
            @csrf

            <div class="form-control">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required autofocus
                       value="{{ old('email') }}" placeholder="Masukkan email anda">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-control">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required placeholder="Masukkan password anda">
                <button type="button" onclick="togglePassword(this)" class="toggle-password">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-eye" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7-3.732 7-9.542 7-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>

    <script>
        function togglePassword(button) {
            const input = button.previousElementSibling;
            const svg = button.querySelector('svg');

            const show = `
                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path d="M2.458 12C3.732 7.943 7.523 5 12 5
                    s8.268 2.943 9.542 7-3.732 7-9.542 7
                    -8.268-2.943-9.542-7z" />`;

            const hide = `
                <path d="M13.875 18.825A10.05 10.05 0 0112 19
                    c-4.478 0-8.269-2.944-9.543-7
                    a9.956 9.956 0 012.342-3.36m3.093-2.52
                    A9.953 9.953 0 0112 5c4.478 0 8.269 2.944 9.543 7
                    a9.956 9.956 0 01-1.88 3.106" />
                <path d="M3 3l18 18" />`;

            if (input.type === 'password') {
                input.type = 'text';
                svg.innerHTML = hide;
            } else {
                input.type = 'password';
                svg.innerHTML = show;
            }
        }
    </script>
</body>
</html>
