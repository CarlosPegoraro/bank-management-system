<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cadê o Meu Dinheiro?</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>
<body class="app-shell">
    <div class="min-h-screen lg:flex">
        <aside class="app-sidebar">
            <a wire:navigate href="{{ route('dashboard') }}" class="brand">
                <img src="{{ asset('logo.svg') }}" alt="Cadê o Meu Dinheiro?">
            </a>
            <nav class="app-nav">
                <a wire:navigate href="{{ route('dashboard') }}" @class(['app-nav-link','is-active' => request()->routeIs('dashboard')])><span>⌂</span>Dashboard</a>
                <a wire:navigate href="{{ route('transactions') }}" @class(['app-nav-link','is-active' => request()->routeIs('transactions')])><span>↔</span>Transações</a>
                <a wire:navigate href="{{ route('accounts') }}" @class(['app-nav-link','is-active' => request()->routeIs('accounts')])><span>▣</span>Contas e cartões</a>
                <a wire:navigate href="{{ route('categories') }}" @class(['app-nav-link','is-active' => request()->routeIs('categories')])><span>◇</span>Categorias</a>
            </nav>
        </aside>
        <section class="min-w-0 flex-1">
            <header class="topbar">
                <p class="text-sm font-semibold text-slate-800">@yield('page-title', 'Dashboard')</p>
                <div class="topbar-actions">
                    <label class="search-box"><span>⌕</span><input type="search" placeholder="Buscar"></label>
                    <button class="icon-button" type="button" aria-label="Notificações">♧</button>
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
    @livewireScripts
</body>
</html>
