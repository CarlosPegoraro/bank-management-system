<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Cadim: organize suas finanças com clareza e leveza.">
    <title>Cadim — Sua vida financeira mais leve</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="landing-page">
    <header class="landing-header">
        <div class="landing-container landing-nav">
            <a href="{{ route('landing') }}" class="landing-brand" aria-label="Cadim, início">
                <img src="{{ asset('logo.svg') }}" alt="Cadim">
            </a>
            <nav class="landing-nav-actions" aria-label="Acesso à conta">
                <a href="{{ route('login') }}" class="landing-login">Entrar</a>
                <a href="{{ route('register') }}" class="landing-button landing-button-small">Criar minha conta <span aria-hidden="true">↗</span></a>
            </nav>
        </div>
    </header>

    <main>
        <section class="landing-hero">
            <div class="landing-container landing-hero-grid">
                <div class="landing-hero-copy">
                    <p class="landing-eyebrow"><span></span> Clareza para as suas escolhas</p>
                    <h1>Seu dinheiro no lugar. <em>Sua cabeça também.</em></h1>
                    <p class="landing-hero-text">O Cadim transforma sua vida financeira em uma visão simples, organizada e fácil de acompanhar — todos os dias.</p>
                    <div class="landing-hero-actions">
                        <a href="{{ route('register') }}" class="landing-button">Começar agora <span aria-hidden="true">↗</span></a>
                        <a href="#como-funciona" class="landing-text-link">Descobrir como funciona <span aria-hidden="true">↓</span></a>
                    </div>
                    <div class="landing-trust"><span class="landing-avatars"><i>J</i><i>M</i><i>A</i></span><span>Feito para deixar sua rotina mais leve.</span></div>
                </div>

                <div class="landing-visual" aria-label="Prévia do dashboard financeiro do Cadim">
                    <div class="landing-orb landing-orb-one"></div>
                    <div class="landing-orb landing-orb-two"></div>
                    <div class="landing-dashboard-card">
                        <div class="landing-card-top"><div><span class="landing-card-kicker">Visão geral</span><strong>Olá, Marina <span aria-hidden="true">✦</span></strong></div><span class="landing-card-menu">•••</span></div>
                        <div class="landing-balance"><span>Saldo total</span><strong>R$ 8.420,00</strong><small><b>↑ 12,4%</b> este mês</small></div>
                        <div class="landing-mini-metrics"><div><span>Receitas</span><strong>R$ 6.800</strong><i class="landing-income">+18,2%</i></div><div><span>Despesas</span><strong>R$ 3.240</strong><i class="landing-expense">-4,8%</i></div></div>
                        <div class="landing-chart"><div class="landing-chart-heading"><span>Fluxo financeiro</span><small>Últimos 6 meses⌄</small></div><svg viewBox="0 0 430 132" role="img" aria-label="Gráfico de evolução financeira"><path class="landing-chart-grid" d="M0 22H430M0 65H430M0 108H430"/><path class="landing-chart-fill" d="M0 95 C28 91 38 72 70 78 S112 101 142 75 S179 48 210 58 S249 83 275 51 S313 33 340 46 S381 67 430 17 V132 H0 Z"/><path class="landing-chart-line" d="M0 95 C28 91 38 72 70 78 S112 101 142 75 S179 48 210 58 S249 83 275 51 S313 33 340 46 S381 67 430 17"/><circle cx="340" cy="46" r="5" class="landing-chart-dot"/></svg><div class="landing-chart-labels"><span>Jan</span><span>Fev</span><span>Mar</span><span>Abr</span><span>Mai</span><span>Jun</span></div></div>
                        <div class="landing-card-footer"><span><i class="landing-footer-dot"></i> Tudo sob controle</span><a href="{{ route('register') }}">Ver dashboard →</a></div>
                    </div>
                    <div class="landing-floating-card landing-floating-card-top"><span class="landing-floating-icon">✓</span><div><small>Meta alcançada</small><strong>Reserva de emergência</strong></div></div>
                    <div class="landing-floating-card landing-floating-card-bottom"><span class="landing-floating-icon landing-floating-icon-purple">↗</span><div><small>Você economizou</small><strong>R$ 840 este mês</strong></div></div>
                </div>
            </div>
        </section>

        <section class="landing-features" id="como-funciona">
            <div class="landing-container">
                <div class="landing-section-heading"><p class="landing-eyebrow"><span></span> Tudo em um só lugar</p><h2>Menos planilhas. Mais <em>tranquilidade.</em></h2><p>O essencial para você entender o presente e construir o futuro que deseja.</p></div>
                <div class="landing-feature-grid">
                    <article class="landing-feature-card"><span class="landing-feature-icon landing-icon-green">↗</span><h3>Veja para onde o dinheiro vai</h3><p>Registre suas entradas e saídas e acompanhe seus hábitos com uma visão clara.</p><a href="{{ route('register') }}">Organizar minhas finanças <span>→</span></a></article>
                    <article class="landing-feature-card"><span class="landing-feature-icon landing-icon-yellow">◷</span><h3>Planeje sem complicar</h3><p>Crie orçamentos, metas e lançamentos recorrentes para não ser pego de surpresa.</p><a href="{{ route('register') }}">Começar meu planejamento <span>→</span></a></article>
                    <article class="landing-feature-card"><span class="landing-feature-icon landing-icon-blue">▣</span><h3>Decida com confiança</h3><p>Tenha seus saldos, contas e cartões organizados para fazer escolhas melhores.</p><a href="{{ route('register') }}">Criar uma conta grátis <span>→</span></a></article>
                </div>
            </div>
        </section>

        <section class="landing-bottom-cta">
            <div class="landing-container landing-bottom-cta-inner"><div><p class="landing-eyebrow"><span></span> Um novo começo</p><h2>Organizar sua vida financeira pode ser leve.</h2></div><a href="{{ route('register') }}" class="landing-button landing-button-light">Quero começar <span aria-hidden="true">↗</span></a></div>
        </section>
    </main>

    <footer class="landing-footer"><div class="landing-container"><img src="{{ asset('logo.svg') }}" alt="Cadim"><p>© {{ date('Y') }} Cadim. Organização financeira para a vida real.</p><a href="{{ route('login') }}">Já tenho uma conta →</a></div></footer>
</body>
</html>
