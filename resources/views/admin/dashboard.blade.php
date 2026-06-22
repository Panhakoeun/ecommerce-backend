<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <style>
        :root {
            --ink: #18212f;
            --muted: #657184;
            --line: #d8dee8;
            --surface: #ffffff;
            --page: #f3f6fb;
            --accent: #0f766e;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--page);
            color: var(--ink);
            font-family: Arial, Helvetica, sans-serif;
        }

        header {
            background: var(--surface);
            border-bottom: 1px solid var(--line);
        }

        .bar,
        main {
            width: min(1080px, calc(100vw - 32px));
            margin: 0 auto;
        }

        .bar {
            min-height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            line-height: 1.2;
            letter-spacing: 0;
        }

        main {
            padding: 32px 0;
        }

        section {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 28px;
        }

        p {
            margin: 8px 0 0;
            color: var(--muted);
            line-height: 1.5;
        }

        button {
            min-height: 40px;
            border: 1px solid var(--line);
            border-radius: 6px;
            background: var(--surface);
            color: var(--ink);
            cursor: pointer;
            font: inherit;
            font-weight: 700;
            padding: 8px 14px;
        }

        button:hover {
            border-color: var(--accent);
            color: var(--accent);
        }
    </style>
</head>
<body>
    <header>
        <div class="bar">
            <h1>Ecommerce Admin</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Log out</button>
            </form>
        </div>
    </header>

    <main>
        <section>
            <h2>Welcome, {{ auth()->user()->name }}</h2>
            <p>You are signed in as {{ auth()->user()->email }}.</p>
        </section>
    </main>
</body>
</html>
