<main class="auth-wrap">
    <section class="auth-card">
        <div class="auth-form-pane">
            <a wire:navigate href="{{ route('dashboard') }}" class="auth-logo"><img src="{{ asset('logo.svg') }}" alt="Cadim"></a>
            <div class="auth-intro"><p class="eyebrow">BEM-VINDO DE VOLTA</p><h1>Suas finanças,<br>claras e sob controle.</h1><p>Acesse sua conta para acompanhar cada passo do seu dinheiro.</p></div>
            <form wire:submit="login" class="auth-form">
                <label class="auth-field">E-mail<input wire:model="email" type="email" autocomplete="email" autofocus placeholder="voce@exemplo.com"></label>
                <label class="auth-field">Senha<input wire:model="password" type="password" autocomplete="current-password" placeholder="Digite sua senha"></label>
                @error('email')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                <div class="auth-options"><label><input wire:model="remember" type="checkbox"> <span>Manter conectado</span></label><button type="button">Esqueci minha senha</button></div>
                <button class="auth-submit">Entrar na minha conta <span>→</span></button>
            </form>
            <p class="auth-switch">Ainda não tem conta? <a wire:navigate href="{{ route('register') }}">Criar minha conta</a></p>
        </div>
        <div class="auth-art-pane">
            <div class="auth-art-copy"><span>✦</span><p>Organize hoje.<br><b>Realize amanhã.</b></p></div>
            <img src="{{ asset('images/finance-auth-illustration.svg') }}" alt="Ilustração de organização financeira" class="auth-art">
            <p class="auth-art-footer">Seu dinheiro trabalhando com você.</p>
        </div>
    </section>
</main>
