<div>
    @php($count = 1)
    @foreach ($debts as $debt)
        @php($mensal = round($debt->amount / $debt->installments, 2))
        @php($totalAmount += $mensal)

        <x-debt-card :debt="$debt" :mensal="$mensal" :count="$count" />
        @php($count++)
    @endforeach
    {{ $debts->links() }}
</div>
