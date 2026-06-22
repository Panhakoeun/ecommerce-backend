<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #18212f;
            --muted: #657184;
            --line: #d8dee8;
            --surface: #ffffff;
            --page: #f3f6fb;
            --accent: #0f766e;
            --accent-dark: #115e59;
            --danger: #b42318;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: var(--page);
            color: var(--ink);
            font-family: Arial, Helvetica, sans-serif;
        }

        main {
            width: min(420px, calc(100vw - 32px));
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 18px 48px rgba(24, 33, 47, 0.12);
            padding: 32px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 28px;
            line-height: 1.2;
            letter-spacing: 0;
        }

        p {
            margin: 0 0 28px;
            color: var(--muted);
            line-height: 1.5;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            min-height: 44px;
            border: 1px solid var(--line);
            border-radius: 6px;
            padding: 10px 12px;
            color: var(--ink);
            font: inherit;
        }

        input:focus {
            border-color: var(--accent);
            outline: 3px solid rgba(15, 118, 110, 0.14);
        }

        .field {
            margin-bottom: 18px;
        }

        .row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 2px 0 24px;
            color: var(--muted);
            font-size: 14px;
        }

        button {
            width: 100%;
            min-height: 44px;
            border: 0;
            border-radius: 6px;
            background: var(--accent);
            color: #ffffff;
            cursor: pointer;
            font: inherit;
            font-weight: 700;
        }

        button:hover {
            background: var(--accent-dark);
        }

        .error {
            margin: 0 0 18px;
            border: 1px solid rgba(180, 35, 24, 0.25);
            border-radius: 6px;
            background: rgba(180, 35, 24, 0.08);
            color: var(--danger);
            padding: 10px 12px;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <main>
        <h1>Admin Login</h1>
        <p>Sign in to manage your ecommerce backend.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', 'panha.koeun142007@gmail.com') }}" autocomplete="email" required autofocus>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required>
            </div>

            <label class="row">
                <input name="remember" type="checkbox" value="1">
                <span>Remember me</span>
            </label>

            <button type="submit">Log in</button>
        </form>
    </main>
</body>
</html>
