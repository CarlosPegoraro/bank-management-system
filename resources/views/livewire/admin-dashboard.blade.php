<div class="dashboard-page">
    <div class="dashboard-heading">
        <div><p class="eyebrow">ADMINISTRAÇÃO</p><h1>Painel de uso</h1><p>Métricas agregadas para acompanhar ativação e saúde do produto.</p></div>
        <label class="field min-w-40">Período<select wire:model.live="days"><option value="7">Últimos 7 dias</option><option value="30">Últimos 30 dias</option><option value="90">Últimos 90 dias</option></select></label>
    </div>

    <div class="summary-grid">
        <article class="metric-card"><div class="metric-icon current-balance">◎</div><p>Usuários cadastrados</p><strong>{{ number_format($metrics['users'], 0, ',', '.') }}</strong><small>Base total</small></article>
        <article class="metric-card"><div class="metric-icon income">↗</div><p>Novos usuários</p><strong>{{ number_format($metrics['new_users'], 0, ',', '.') }}</strong><small>Desde {{ \Carbon\Carbon::parse($metrics['period_start'])->format('d/m/Y') }}</small></article>
        <article class="metric-card"><div class="metric-icon savings">◉</div><p>Ativos em 30 dias</p><strong>{{ number_format($metrics['active_users'], 0, ',', '.') }}</strong><small>Com login registrado</small></article>
        <article class="metric-card"><div class="metric-icon expense">✓</div><p>Onboarding concluído</p><strong>{{ number_format($metrics['completed_onboarding'], 0, ',', '.') }}</strong><small>{{ $metrics['onboarding_started'] }} iniciado(s)</small></article>
        <article class="metric-card"><div class="metric-icon current-balance">?</div><p>Feedbacks recebidos</p><strong>{{ number_format($metrics['feedback'], 0, ',', '.') }}</strong><small>No período selecionado</small></article>
    </div>

    <div class="mt-5 grid gap-5 lg:grid-cols-2">
        <article class="panel"><div class="panel-title"><div><p>Onboarding</p><h2>Eventos recentes</h2></div></div><div class="mt-4 space-y-3">@forelse($metrics['event_breakdown'] as $event => $total)<div class="flex items-center justify-between border-b border-slate-100 pb-3 text-sm"><span class="text-slate-600">{{ str_replace('_', ' ', ucfirst($event)) }}</span><strong class="text-slate-800">{{ $total }}</strong></div>@empty<p class="empty-copy">Nenhum evento no período.</p>@endforelse</div></article>
        <article class="panel"><div class="panel-title"><div><p>Contas recentes</p><h2>Últimos usuários</h2></div></div><div class="table-wrap mt-4"><table class="dashboard-table"><thead><tr><th>Usuário</th><th>Papel</th><th>Último acesso</th></tr></thead><tbody>@forelse($metrics['recent_users'] as $user)<tr><td><b>{{ $user->name }}</b><small>{{ $user->email }}</small></td><td><span class="status-pill {{ $user->role === 'admin' ? 'settled' : 'pending' }}">{{ $user->role === 'admin' ? 'Admin' : 'Usuário' }}</span></td><td>{{ $user->last_login_at?->format('d/m/Y H:i') ?? 'Ainda não acessou' }}</td></tr>@empty<tr><td colspan="3" class="empty-row">Nenhum usuário.</td></tr>@endforelse</tbody></table></div></article>
    </div>
</div>
