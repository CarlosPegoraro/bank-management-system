<div class="dashboard-page">
    <div class="dashboard-heading">
        <div><p class="eyebrow">{{ now()->translatedFormat('F \d\e Y') }}</p><h1>Olá, {{ explode(' ', auth()->user()->name)[0] }}!</h1><p>Acompanhe sua vida financeira em um só lugar.</p></div>
        <a wire:navigate href="{{ route('transactions') }}" class="btn-primary">+ Nova transação</a>
    </div>

    <div class="dashboard-layout">
        <section class="dashboard-main">
            <div class="summary-grid">
                <article class="metric-card"><div class="metric-icon income">↙</div><p>Receitas do mês</p><strong>R$ {{ number_format($income, 2, ',', '.') }}</strong><small><b class="positive">●</b> R$ {{ number_format($settledIncome, 2, ',', '.') }} recebidos</small></article>
                <article class="metric-card"><div class="metric-icon expense">↗</div><p>Despesas do mês</p><strong>R$ {{ number_format($expense, 2, ',', '.') }}</strong><small><b class="negative">●</b> R$ {{ number_format($settledExpense, 2, ',', '.') }} pagos</small></article>
                <article class="metric-card"><div class="metric-icon savings">▱</div><p>Saldo previsto</p><strong>R$ {{ number_format($income - $expense, 2, ',', '.') }}</strong><small><b class="positive">●</b> considerando pendências</small></article>
            </div>

            <article class="panel chart-panel">
                <div class="panel-title"><div><p>Visão financeira</p><h2>Ganhos ao longo do ano</h2></div><span class="period-select">Este ano⌄</span></div>
                @php($max = max(1, $months->max('income'), $months->max('expense')))
                <div class="chart-key"><span><i class="bg-emerald-500"></i>Receitas</span><span><i class="bg-slate-200"></i>Despesas</span></div>
                <div class="bar-chart">
                    @foreach($months as $month)
                    <div class="chart-column" title="{{ $month['label'] }}: receitas R$ {{ number_format($month['income'], 2, ',', '.') }}, despesas R$ {{ number_format($month['expense'], 2, ',', '.') }}">
                        <div class="chart-bars"><i class="bar-expense" style="height: {{ max(6, ($month['expense'] / $max) * 150) }}px"></i><i class="bar-income" style="height: {{ max(6, ($month['income'] / $max) * 150) }}px"></i></div>
                        <span>{{ $month['label'] }}</span>
                    </div>
                    @endforeach
                </div>
            </article>

            <article class="panel transactions-panel">
                <div class="panel-title"><div><p>Movimentações recentes</p><h2>Histórico de transações</h2></div><a wire:navigate href="{{ route('transactions') }}" class="period-select">Ver todas →</a></div>
                <div class="table-wrap"><table class="dashboard-table"><thead><tr><th>Transação</th><th>Data</th><th>Categoria</th><th>Valor</th><th>Status</th></tr></thead><tbody>
                @forelse($recentTransactions as $transaction)<tr><td><b>{{ $transaction->description }}</b><small>{{ $transaction->merchant ?: ($transaction->account?->name ?? 'Lançamento financeiro') }}</small></td><td>{{ $transaction->due_date->format('d/m/Y') }}</td><td>{{ $transaction->category?->name ?? 'Sem categoria' }}</td><td class="{{ $transaction->type === 'income' ? 'amount-income' : 'amount-expense' }}">{{ $transaction->type === 'income' ? '+' : '-' }} R$ {{ number_format($transaction->amount, 2, ',', '.') }}</td><td><span class="status-pill {{ $transaction->status }}">{{ $transaction->status === 'settled' ? 'Confirmado' : 'Pendente' }}</span></td></tr>
                @empty<tr><td colspan="5" class="empty-row">Ainda não há transações para exibir.</td></tr>@endforelse
                </tbody></table></div>
            </article>
        </section>

        <aside class="dashboard-side">
            <article class="card-widget"><div class="side-heading"><h2>Meus cartões</h2><a wire:navigate href="{{ route('accounts') }}">+ Adicionar</a></div>
                @if($primaryCard)<div class="credit-card" style="--card-color: {{ $primaryCard->color ?: '#77bb8b' }}"><span class="card-chip">◈</span><span class="card-wave">⌁</span><p>{{ $primaryCard->name }}</p><strong>{{ auth()->user()->name }}</strong><div><small>LIMITE</small><small>VENCIMENTO</small></div><div><b>R$ {{ number_format($primaryCard->limit, 2, ',', '.') }}</b><b>Dia {{ $primaryCard->due_day }}</b></div></div>
                @else<div class="empty-card">Cadastre um cartão para acompanhar seu limite.</div>@endif
                <a wire:navigate href="{{ route('accounts') }}" class="quick-action">▣ <span>Gerenciar cartões</span>→</a>
            </article>
            <article class="side-panel"><div class="side-heading"><h2>Limite disponível</h2><span>•••</span></div><p class="limit-value">R$ {{ number_format($totalCardLimit, 2, ',', '.') }}</p><p class="limit-subtitle">em limites de cartão cadastrados</p><div class="progress-track"><i></i></div></article>
            <article class="side-panel"><div class="side-heading"><h2>Próximos lançamentos</h2><a wire:navigate href="{{ route('transactions') }}">Ver todos</a></div><div class="upcoming-list">@forelse($upcoming as $item)<div><span class="upcoming-dot {{ $item->type }}">{{ strtoupper(substr($item->description, 0, 1)) }}</span><p><b>{{ $item->description }}</b><small>{{ $item->due_date->format('d/m') }} · {{ $item->category?->name ?? 'Sem categoria' }}</small></p><strong class="{{ $item->type === 'income' ? 'amount-income' : 'amount-expense' }}">{{ $item->type === 'income' ? '+' : '-' }}R$ {{ number_format($item->amount, 2, ',', '.') }}</strong></div>@empty<p class="empty-copy">Nenhum lançamento pendente.</p>@endforelse</div></article>
        </aside>
    </div>
</div>
