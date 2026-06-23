<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - Ecommerce</title>
    <style>
        :root {
            --ink: #172033;
            --muted: #667085;
            --line: #d6e0ea;
            --page: #eef4f7;
            --surface: #ffffff;
            --sidebar: #10233f;
            --sidebar-soft: #193b61;
            --sidebar-muted: #b9c8da;
            --accent: #0e9384;
            --accent-dark: #0f6f67;
            --accent-warm: #f97316;
            --danger: #b42318;
            --warn: #946200;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--page);
            color: var(--ink);
            font-family: Arial, Helvetica, sans-serif;
        }

        a { color: inherit; text-decoration: none; }

        .shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
        }

        aside {
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, #10233f 0%, #132f52 58%, #0f233f 100%);
            color: #ffffff;
            padding: 22px 14px;
            box-shadow: 12px 0 32px rgba(16, 35, 63, 0.2);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 20px;
            font-weight: 800;
            line-height: 1.2;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: var(--accent);
            box-shadow: 0 10px 24px rgba(14, 147, 132, 0.28);
        }

        .brand-mark svg,
        .icon svg,
        .nav-icon svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .admin-meta {
            margin: 16px 4px 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.06);
            padding: 12px;
            color: var(--sidebar-muted);
            font-size: 13px;
            line-height: 1.4;
        }

        .admin-meta strong {
            display: block;
            color: #ffffff;
            font-size: 14px;
            margin-bottom: 3px;
        }

        nav {
            display: grid;
            gap: 6px;
            margin-top: 8px;
        }

        nav a,
        .logout-button {
            width: 100%;
            min-height: 44px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: var(--sidebar-muted);
            cursor: pointer;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            padding: 10px 12px;
            text-align: left;
            transition: background 0.15s ease, color 0.15s ease;
        }

        nav a:hover,
        nav a.active,
        .logout-button:hover {
            background: var(--sidebar-soft);
            color: #ffffff;
        }

        nav a.active {
            box-shadow: inset 3px 0 0 var(--accent);
            background: rgba(14, 147, 132, 0.18);
        }

        .nav-icon {
            width: 26px;
            height: 26px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.08);
            color: inherit;
            text-align: center;
        }

        nav a.active .nav-icon {
            background: var(--accent);
            color: #ffffff;
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .content {
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            min-height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: var(--surface);
            border-bottom: 1px solid var(--line);
            padding: 0 28px;
            box-shadow: 0 8px 24px rgba(23, 32, 51, 0.05);
        }

        .topbar-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: 800;
        }

        .topbar-title::before {
            content: "";
            width: 10px;
            height: 28px;
            border-radius: 999px;
            background: var(--accent-warm);
        }

        .topbar-user {
            color: var(--muted);
            font-size: 14px;
        }

        main {
            width: min(1120px, calc(100vw - 32px));
            margin: 0 auto;
            padding: 28px 0 44px;
        }

        .topline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        h1, h2, h3 { margin: 0; letter-spacing: 0; }
        h1 { font-size: 28px; line-height: 1.2; }
        h2 { font-size: 20px; line-height: 1.25; }
        h3 { font-size: 16px; line-height: 1.3; }
        p { color: var(--muted); line-height: 1.5; margin: 8px 0 0; }

        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 14px 34px rgba(23, 32, 51, 0.07);
        }

        .panel-body { padding: 20px; }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 18px;
            box-shadow: 0 12px 28px rgba(23, 32, 51, 0.06);
        }

        .stat:nth-child(2n) {
            border-top: 3px solid var(--accent);
        }

        .stat:nth-child(2n + 1) {
            border-top: 3px solid var(--accent-warm);
        }

        .stat.hoverable:hover {
            transform: translateY(-4px);
            border-color: var(--accent);
            box-shadow: 0 16px 36px rgba(23, 32, 51, 0.1);
        }

        .stat span {
            display: block;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .stat strong {
            display: block;
            font-size: 28px;
            line-height: 1.1;
        }

        .split {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border-bottom: 1px solid var(--line);
            padding: 14px 16px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f7fafc;
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
        }

        tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: #fbfcfe; }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-end;
        }

        .button,
        button {
            min-height: 40px;
            border: 1px solid var(--line);
            border-radius: 6px;
            background: var(--surface);
            color: var(--ink);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font: inherit;
            font-weight: 700;
            padding: 8px 14px;
            gap: 8px;
            transition: background 0.15s ease, border-color 0.15s ease, color 0.15s ease, transform 0.15s ease;
        }

        .button:hover,
        button:hover {
            transform: translateY(-1px);
        }

        .button.primary,
        button.primary {
            border-color: var(--accent);
            background: var(--accent);
            color: #ffffff;
            box-shadow: 0 10px 22px rgba(14, 147, 132, 0.2);
        }

        .button.primary:hover,
        button.primary:hover { background: var(--accent-dark); }

        .button.danger,
        button.danger {
            border-color: rgba(180, 35, 24, 0.35);
            color: var(--danger);
        }

        .icon {
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            min-height: 24px;
            border-radius: 999px;
            background: #eef2f6;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            padding: 3px 9px;
        }

        .badge.completed { background: #e8f5ee; color: #137547; }
        .badge.pending { background: #fff5d6; color: var(--warn); }
        .badge.cancelled { background: #fdecec; color: var(--danger); }

        form.stack {
            display: grid;
            gap: 16px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 700;
        }

        input,
        select,
        textarea {
            width: 100%;
            min-height: 42px;
            border: 1px solid var(--line);
            border-radius: 6px;
            color: var(--ink);
            font: inherit;
            padding: 9px 11px;
            background: #ffffff;
        }

        input[type="file"] {
            padding: 8px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--accent);
            outline: 3px solid rgba(15, 118, 110, 0.14);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .upload-grid {
            display: grid;
            grid-template-columns: minmax(220px, 1fr) 160px;
            gap: 16px;
            align-items: stretch;
        }

        .hint {
            margin-top: 8px;
            font-size: 13px;
        }

        .image-preview,
        .thumb,
        .thumb-empty {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #f8fafc;
        }

        .image-preview {
            min-height: 150px;
            display: grid;
            place-items: center;
            overflow: hidden;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            text-align: center;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            min-height: 150px;
            object-fit: cover;
        }

        .thumb {
            width: 68px;
            height: 68px;
            display: block;
            object-fit: cover;
        }

        .thumb-empty {
            width: 68px;
            height: 68px;
            display: grid;
            place-items: center;
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            text-align: center;
            padding: 6px;
        }

        .alert {
            border: 1px solid rgba(15, 118, 110, 0.25);
            border-radius: 6px;
            background: rgba(14, 147, 132, 0.09);
            color: var(--accent-dark);
            margin-bottom: 18px;
            padding: 12px 14px;
        }

        .error {
            color: var(--danger);
            font-size: 13px;
            margin-top: 6px;
        }

        .empty {
            color: var(--muted);
            padding: 24px;
            text-align: center;
        }

        .pagination {
            padding: 16px;
        }

        @media (max-width: 900px) {
            .shell {
                grid-template-columns: 1fr;
            }

            aside {
                position: static;
                height: auto;
                padding: 16px;
            }

            .brand {
                padding-bottom: 14px;
            }

            nav {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            }

            .sidebar-footer {
                margin-top: 12px;
            }

            .topbar {
                padding: 16px;
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 760px) {
            .topline {
                align-items: flex-start;
                flex-direction: column;
            }

            .actions {
                justify-content: flex-start;
            }

            th, td {
                padding: 12px 10px;
            }

            .upload-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="shell">
        <aside>
            <a class="brand" href="{{ route('admin.dashboard') }}">
                <span class="brand-mark">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16l-2 12H6L4 7Z"></path><path d="M9 7a3 3 0 0 1 6 0"></path></svg>
                </span>
                <span>Ecommerce Admin</span>
            </a>

            <div class="admin-meta">
                <strong>{{ auth()->user()->name }}</strong>
                {{ auth()->user()->email }}
            </div>

            <nav>
                <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 13h6V4H4v9Z"></path><path d="M14 20h6V4h-6v16Z"></path><path d="M4 20h6v-3H4v3Z"></path></svg></span>
                    <span>Dashboard</span>
                </a>
                <a class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16"></path><path d="M4 12h16"></path><path d="M4 18h16"></path></svg></span>
                    <span>Categories</span>
                </a>
                <a class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 4h12v16H6V4Z"></path><path d="M9 8h6"></path><path d="M9 12h6"></path><path d="M9 16h3"></path></svg></span>
                    <span>Products</span>
                </a>
                <a class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 4h10l2 16H5L7 4Z"></path><path d="M9 8h6"></path><path d="M9 12h6"></path></svg></span>
                    <span>Orders</span>
                </a>
                <a class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 20v-2a4 4 0 0 0-8 0v2"></path><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"></path><path d="M18 10a3 3 0 0 1 3 3v2"></path></svg></span>
                    <span>Users</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">
                        <span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 17l5-5-5-5"></path><path d="M15 12H3"></path><path d="M21 4v16"></path></svg></span>
                        <span>Log out</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="content">
            <div class="topbar">
                <div class="topbar-title">@yield('title', 'Admin')</div>
                <div class="topbar-user">Signed in as {{ auth()->user()->email }}</div>
            </div>

            <main>
                @if (session('status'))
                    <div class="alert">{{ session('status') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
