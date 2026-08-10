<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cadim</title>
    <script>
        window.applySavedTheme = () => {
            document.documentElement.dataset.theme = localStorage.getItem('theme') === 'dark' ? 'dark' : 'light';
        };

        window.applySavedTheme();

        window.syncThemeToggle = () => {
            const dark = document.documentElement.dataset.theme === 'dark';
            document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
                button.classList.toggle('is-dark', dark);
                button.setAttribute('aria-pressed', dark ? 'true' : 'false');
                button.setAttribute('aria-label', dark ? 'Ativar modo claro' : 'Ativar modo escuro');
                button.querySelector('[data-theme-icon]')?.replaceChildren(document.createTextNode(dark ? '☀' : '☾'));
            });
        };

        window.toggleTheme = (event) => {
            event?.stopPropagation();
            const dark = document.documentElement.dataset.theme === 'dark';
            document.documentElement.dataset.theme = dark ? 'light' : 'dark';
            localStorage.setItem('theme', dark ? 'light' : 'dark');
            window.syncThemeToggle();
        };

        document.addEventListener('DOMContentLoaded', window.syncThemeToggle);
        document.addEventListener('livewire:navigating', window.applySavedTheme);
        document.addEventListener('livewire:navigated', () => {
            window.applySavedTheme();
            window.syncThemeToggle();
        });
        document.addEventListener('alpine:navigated', window.applySavedTheme);
    </script>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style id="theme-overrides">
        html[data-theme="dark"] { color-scheme: dark; }
        html[data-theme="dark"] body.app-shell { background: #0f1713 !important; color: #dbe7df !important; }
        html[data-theme="dark"] .app-sidebar,
        html[data-theme="dark"] .topbar,
        html[data-theme="dark"] .card,
        html[data-theme="dark"] .panel,
        html[data-theme="dark"] .metric-card,
        html[data-theme="dark"] .card-widget,
        html[data-theme="dark"] .side-panel { background: #17221c !important; border-color: #2a3a30 !important; color: #dbe7df !important; }
        html[data-theme="dark"] .bg-white,
        html[data-theme="dark"] .bg-stone-50,
        html[data-theme="dark"] .bg-slate-50 { background-color: #1d2a22 !important; }
        html[data-theme="dark"] .text-slate-900,
        html[data-theme="dark"] .text-slate-800,
        html[data-theme="dark"] .text-slate-700 { color: #e8f2eb !important; }
        html[data-theme="dark"] .text-slate-600 { color: #c9d8ce !important; }
        html[data-theme="dark"] .text-slate-500 { color: #b0c3b6 !important; }
        html[data-theme="dark"] .text-slate-400,
        html[data-theme="dark"] .text-slate-300,
        html[data-theme="dark"] .metric-card small,
        html[data-theme="dark"] .panel-title p,
        html[data-theme="dark"] .dashboard-table td small,
        html[data-theme="dark"] .upcoming-list small,
        html[data-theme="dark"] .limit-subtitle { color: #9caf9f !important; }
        html[data-theme="dark"] .metric-card p,
        html[data-theme="dark"] .field,
        html[data-theme="dark"] .dashboard-table td,
        html[data-theme="dark"] .upcoming-list b { color: #c9d8ce !important; }
        html[data-theme="dark"] .panel-title h2,
        html[data-theme="dark"] .side-heading h2,
        html[data-theme="dark"] .dashboard-heading h1,
        html[data-theme="dark"] .metric-card strong,
        html[data-theme="dark"] .limit-value { color: #f1f7f3 !important; }
        html[data-theme="dark"] .text-emerald-700,
        html[data-theme="dark"] .text-emerald-800,
        html[data-theme="dark"] .text-emerald-600,
        html[data-theme="dark"] .amount-income,
        html[data-theme="dark"] .side-heading a { color: #72e6a0 !important; }
        html[data-theme="dark"] .text-rose-600,
        html[data-theme="dark"] .amount-expense { color: #ff9b9b !important; }
        html[data-theme="dark"] .text-amber-700 { color: #fbd176 !important; }
        html[data-theme="dark"] .field input,
        html[data-theme="dark"] .field select,
        html[data-theme="dark"] .field textarea,
        html[data-theme="dark"] .filter-control { color: #e8f2eb !important; }
    </style>
    @livewireStyles
</head>
<body class="app-shell">
    <div class="min-h-screen lg:flex">
        <aside class="app-sidebar">
            <a wire:navigate href="{{ route('dashboard') }}" class="brand">
                <img src="{{ asset('logo.svg') }}" alt="Cadim">
            </a>
            <nav class="app-nav">
                <a wire:navigate href="{{ route('dashboard') }}" @class(['app-nav-link','is-active' => request()->routeIs('dashboard')])>Dashboard</a>
                <a wire:navigate href="{{ route('transactions') }}" @class(['app-nav-link','is-active' => request()->routeIs('transactions')])>Transações</a>
                <a wire:navigate href="{{ route('accounts', ['tab' => 'accounts']) }}" @class(['app-nav-link','is-active' => request()->routeIs('accounts') && request('tab', 'accounts') === 'accounts'])>Contas e Cartões</a>
{{--                <a wire:navigate href="{{ route('accounts', ['tab' => 'cards']) }}" @class(['app-nav-link','is-active' => request()->routeIs('accounts') && request('tab') === 'cards'])>Cartões</a>--}}
                <a wire:navigate href="{{ route('categories') }}" @class(['app-nav-link','is-active' => request()->routeIs('categories')])>Categorias</a>
                <a wire:navigate href="{{ route('budgets') }}" @class(['app-nav-link','is-active' => request()->routeIs('budgets')])>Orçamentos e metas</a>
            </nav>
        </aside>
        <section class="min-w-0 flex-1">
            <header class="topbar">
                <p class="text-sm font-semibold text-slate-800">@yield('page-title', 'Dashboard')</p>
                <div class="topbar-actions">
                    <form method="GET" action="{{ route('transactions') }}" class="search-box"><span>⌕</span><input name="search" value="{{ request()->routeIs('transactions') ? request('search') : '' }}" type="search" placeholder="Buscar transação"></form>
                    <button type="button" class="theme-toggle" data-theme-toggle onclick="window.toggleTheme(event)" aria-label="Ativar modo escuro" aria-pressed="false"><span class="theme-toggle-track"><span class="theme-toggle-thumb" data-theme-icon>☾</span></span></button>
                    <details class="notifications-menu"><summary class="icon-button relative" aria-label="Notificações">♧@if(($financialNotifications['count'] ?? 0) > 0)<span class="notification-badge">{{ $financialNotifications['count'] }}</span>@endif</summary><div class="notifications-dropdown"><div class="flex items-center justify-between border-b border-slate-100 px-3 py-2.5"><b class="text-xs text-slate-800">Notificações</b>@if(($financialNotifications['count'] ?? 0) > 0)<small class="text-[10px] text-slate-400">{{ $financialNotifications['count'] }} alerta(s)</small>@endif</div>@forelse(($financialNotifications['items'] ?? []) as $notification)<a href="{{ $notification['url'] }}" wire:navigate class="block border-b border-slate-50 px-3 py-2.5 hover:bg-emerald-50"><b class="block text-xs text-slate-700">{{ $notification['title'] }}</b><small class="mt-0.5 block text-[10px] leading-relaxed text-slate-400">{{ $notification['text'] }}</small></a>@empty<p class="px-3 py-5 text-center text-xs text-slate-400">Tudo em dia por aqui.</p>@endforelse</div></details>
                    <details class="profile-menu">
                        <summary class="profile-badge" aria-label="Abrir menu do perfil"><span class="profile-avatar">{{ auth()->user()->avatar_icon ?: strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><span class="hidden text-xs font-medium sm:inline">{{ auth()->user()->name }}</span><span class="hidden text-slate-400 sm:inline">⌄</span></summary>
                        <div class="profile-dropdown">
                            <div class="profile-dropdown-head"><span class="profile-avatar">{{ auth()->user()->avatar_icon ?: strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><div><b>{{ auth()->user()->name }}</b><small>{{ auth()->user()->email }}</small></div></div>
                            <a wire:navigate href="{{ route('profile') }}">⚙ <span>Meu perfil</span></a>
                            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">↪ <span>Sair</span></button></form>
                        </div>
                    </details>
                </div>
            </header>
            <main class="app-content">{{ $slot }}</main>
        </section>
    </div>
    <div wire:loading.flex class="loading-indicator" aria-live="polite"><span class="loading-dot"></span>Atualizando...</div>
    @livewireScripts
</body>
</html>
