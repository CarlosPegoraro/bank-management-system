<div class="settings-page">
    <div class="dashboard-heading"><div><p class="eyebrow">CONFIGURAÇÕES</p><h1>Meu perfil</h1><p>Personalize sua conta e mantenha seus dados seguros.</p></div><a wire:navigate href="{{ route('dashboard') }}" class="btn-secondary">← Voltar ao dashboard</a></div>
    <div class="settings-grid">
        <section class="panel settings-panel"><div class="settings-title"><div><h2>Dados pessoais</h2><p>Estas informações aparecem na sua conta.</p></div><span class="settings-avatar">{{ $avatarIcon ?: strtoupper(substr($name, 0, 1)) }}</span></div>
            <form wire:submit="saveProfile" class="settings-form">
                <label class="field">Nome<input wire:model="name" autocomplete="name"></label>
                <label class="field">E-mail<input wire:model="email" type="email" autocomplete="email"></label>
                <fieldset class="avatar-picker"><legend>Ícone do perfil</legend><div>@foreach(['💸', '🌱', '📈', '💳', '🎯', '✨'] as $icon)<button type="button" wire:click="$set('avatarIcon', '{{ $icon }}')" @class(['selected' => $avatarIcon === $icon]) aria-label="Usar ícone {{ $icon }}">{{ $icon }}</button>@endforeach</div></fieldset>
                @error('name')<p class="form-error">{{ $message }}</p>@enderror @error('email')<p class="form-error">{{ $message }}</p>@enderror
                <div class="settings-actions"><span x-data x-on:profile-saved.window="setTimeout(() => $el.textContent = '', 2500)" wire:ignore.self></span><button class="btn-primary">Salvar alterações</button></div>
            </form>
        </section>
        <section class="panel settings-panel"><div class="settings-title"><div><h2>Segurança</h2><p>Use uma senha forte e exclusiva.</p></div><span class="security-icon">⌑</span></div>
            <form wire:submit="updatePassword" class="settings-form">
                <label class="field">Senha atual<input wire:model="currentPassword" type="password" autocomplete="current-password"></label>
                <label class="field">Nova senha<input wire:model="password" type="password" autocomplete="new-password"></label>
                <label class="field">Confirmar nova senha<input wire:model="passwordConfirmation" type="password" autocomplete="new-password"></label>
                @error('currentPassword')<p class="form-error">{{ $message }}</p>@enderror @error('password')<p class="form-error">{{ $message }}</p>@enderror
                <div class="settings-actions"><button class="btn-primary">Atualizar senha</button></div>
            </form>
        </section>
    </div>
</div>
