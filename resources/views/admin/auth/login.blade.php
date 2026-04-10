<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink: #1a1a18;
            --ink-muted: #6b6b66;
            --ink-faint: #b0afa8;
            --surface: #faf9f6;
            --panel: #ffffff;
            --border: rgba(26,26,24,0.10);
            --border-focus: #2a2a26;
            --accent: #2a2a26;
            --accent-hover: #444440;
            --error-bg: #fff5f5;
            --error-text: #c0392b;
            --error-border: #f5c6c6;
            --success-bg: #f0faf4;
            --success-text: #1a7a45;
            --success-border: #b6e8cc;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface);
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ── Left decorative panel ── */
        .left-panel {
            background: var(--ink);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 400px; height: 400px;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 50%;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -120px; left: -60px;
            width: 340px; height: 340px;
            border: 1px solid rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1;
        }

        .brand-mark {
            width: 32px; height: 32px;
            background: rgba(255,255,255,0.12);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .brand-mark svg { width: 16px; height: 16px; fill: #fff; }

        .brand-name {
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            color: rgba(255,255,255,0.85);
            letter-spacing: 0.02em;
        }

        .panel-headline {
            z-index: 1;
        }

        .panel-headline h1 {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            color: #fff;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .panel-headline h1 em {
            font-style: italic;
            color: rgba(255,255,255,0.55);
        }

        .panel-headline p {
            font-size: 14px;
            color: rgba(255,255,255,0.4);
            line-height: 1.7;
            max-width: 280px;
        }

        .panel-footer {
            font-size: 12px;
            color: rgba(255,255,255,0.25);
            z-index: 1;
        }

        /* ── Right login panel ── */
        .right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
        }

        .login-title {
            font-family: 'DM Serif Display', serif;
            font-size: 1.75rem;
            color: var(--ink);
            margin-bottom: 0.4rem;
        }

        .login-sub {
            font-size: 14px;
            color: var(--ink-muted);
            margin-bottom: 2rem;
        }

        /* Alerts */
        .alert {
            padding: 11px 14px;
            border-radius: 8px;
            font-size: 13.5px;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.5;
        }
        .alert-error {
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            color: var(--error-text);
        }
        .alert-success {
            background: var(--success-bg);
            border: 1px solid var(--success-border);
            color: var(--success-text);
        }
        .alert-icon { font-size: 14px; flex-shrink: 0; margin-top: 1px; }

        /* Form */
        .field { margin-bottom: 1.1rem; }

        label {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--ink);
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            height: 44px;
            padding: 0 14px;
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14.5px;
            color: var(--ink);
            outline: none;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(26,26,24,0.07);
        }

        input::placeholder { color: var(--ink-faint); }

        /* Password wrapper */
        .password-wrap { position: relative; }

        .toggle-pw {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer; padding: 4px;
            color: var(--ink-faint);
            display: flex; align-items: center;
            transition: color 0.15s;
        }
        .toggle-pw:hover { color: var(--ink); }
        .toggle-pw svg { width: 17px; height: 17px; }

        /* Remember + forgot row */
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            font-size: 13.5px;
            color: var(--ink-muted);
            text-transform: none;
            letter-spacing: 0;
            font-weight: 400;
        }

        input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--ink);
            cursor: pointer;
        }

        .forgot {
            font-size: 13px;
            color: var(--ink-muted);
            text-decoration: none;
            transition: color 0.15s;
        }
        .forgot:hover { color: var(--ink); }

        /* Submit button */
        .btn-login {
            width: 100%;
            height: 46px;
            background: var(--accent);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14.5px;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.18s, transform 0.12s;
            letter-spacing: 0.01em;
        }
        .btn-login:hover { background: var(--accent-hover); }
        .btn-login:active { transform: scale(0.99); }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 1.5rem 0 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .divider span {
            font-size: 11.5px;
            color: var(--ink-faint);
            white-space: nowrap;
        }

        /* Responsive */
        @media (max-width: 700px) {
            body { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 2.5rem 1.5rem; align-items: flex-start; padding-top: 3.5rem; }
        }
    </style>
</head>
<body>

    {{-- ── Left decorative panel ── --}}
    <div class="left-panel">
        <div class="brand">
            <div class="brand-mark">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <span class="brand-name">Admin Console</span>
        </div>

        <div class="panel-headline">
            <h1>Manage your<br>platform <em>with<br>confidence.</em></h1>
            <p>Secure, centralized control for your entire operation. Sign in to continue.</p>
        </div>

        <div class="panel-footer">
            &copy; {{ date('Y') }} {{ config('app.name', 'Your App') }}. All rights reserved.
        </div>
    </div>

    {{-- ── Right login panel ── --}}
    <div class="right-panel">
        <div class="login-box">

            <h2 class="login-title">Welcome back</h2>
            <p class="login-sub">Sign in to your admin account</p>

            @if ($errors->any())
    <div class="alert alert-error">
        <ul style="margin:0;padding-left:18px;">
            @foreach ($errors->all() as $error)
                <li style="font-size:13px;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


            {{-- Error alert --}}
            @if(session('error'))
                <div class="alert alert-error" role="alert">
                    <span class="alert-icon">&#9888;</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Success alert --}}
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <span class="alert-icon">&#10003;</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" novalidate>
                @csrf

                {{-- Email --}}
                <div class="field">
                    <label for="email">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="admin@example.com"
                        autocomplete="email"
                        required
                        autofocus
                    >
                    @error('email')
                        <p style="font-size:12.5px;color:#c0392b;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="field">
                    <label for="password">Password</label>
                    <div class="password-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="toggle-pw" aria-label="Toggle password visibility" onclick="togglePassword()">
                            <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p style="font-size:12.5px;color:#c0392b;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="remember-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember">
                        Remember me
                    </label>
                    {{-- <a href="{{ route('admin.password.request') }}" class="forgot">Forgot password?</a> --}}
                </div>

                <button type="submit" class="btn-login">Sign in</button>

            </form>

        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden
                ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
                : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    </script>

</body>
</html>
