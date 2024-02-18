@php
    $installmentLabel = $transaction->installments == 1 ? 'vez' : 'vezes';
    $formattedMensal = number_format($mensal, 2, ',', '.');
@endphp

<div class="d-flex flex-column gap-1 mb-2 p-2 px-3 rounded-3 bg-white">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-secondary fs-5">{{ $transaction->store }} -
            {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</h1>
        <h1 class="text-secondary fs-5">R$ {{ number_format($transaction->amount, 2, ',', '.') }}
        </h1>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="fs-5">{{ $transaction->description ?: 'Não Definida' }}</h1>

        <h1 class="text-secondary fs-5">
            {{ $transaction->installments }} {{ Str::plural($installmentLabel) }} de R$ {{ $formattedMensal }}
        </h1>

    </div>
</div>
