<main class="auth-wrap">
    <section class="auth-card">
        <div class="auth-form-pane">
            <a wire:navigate href="{{ route('dashboard') }}" class="auth-logo"><img src="{{ asset('logo.svg') }}" alt="Cadê o Meu Dinheiro?"></a>
            <div class="auth-intro"><p class="eyebrow">COMECE AGORA</p><h1>Uma vida financeira<br>mais leve começa aqui.</h1><p>Crie sua conta grátis e dê mais clareza às suas decisões.</p></div>
            <form wire:submit="register" class="auth-form">
                <label class="auth-field">Nome completo<input wire:model="name" type="text" autocomplete="name" placeholder="Como podemos te chamar?"></label>
                <label class="auth-field">E-mail<input wire:model="email" type="email" autocomplete="email" placeholder="voce@exemplo.com"></label>
                <label class="auth-field">Senha<input wire:model="password" type="password" autocomplete="new-password" placeholder="Crie uma senha"></label>
                <label class="auth-field">Confirmar senha<input wire:model="password_confirmation" type="password" autocomplete="new-password" placeholder="Repita sua senha"></label>
                @if($errors->any())<p class="text-sm text-rose-600">Revise os campos informados.</p>@endif
                <button class="auth-submit">Criar minha conta <span>→</span></button>
            </form>
            <p class="auth-switch">Já possui uma conta? <a wire:navigate href="{{ route('login') }}">Entrar</a></p>
        </div>
        <div class="auth-art-pane">
            <div class="auth-art-copy"><span>✦</span><p>Organize hoje.<br><b>Realize amanhã.</b></p></div>
            <img src="{{ asset('images/finance-auth-illustration.svg') }}" alt="Ilustração de organização financeira" class="auth-art">
            <p class="auth-art-footer">Planejamento para chegar mais longe.</p>
        </div>
    </section>
</main>
