@php
    $installmentLabel = $transaction->installments == 1 ? 'vez' : 'vezes';
    $formattedMensal = number_format($mensal, 2, ',', '.');
@endphp

<div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-1 mb-3 p-2 px-3 rounded-3 bg-white shadow">
    <div class="d-flex flex-column justify-content-between align-items-center">
        <h1 class="text-secondary fs-6">{{ $transaction->store }} -
            {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }} <a href="{{ route('transaction.show', $transaction) }}" class="bi bi-eye-fill"></a>
        </h1>

        <h1 class="fs-6">{{ $transaction->description ?: 'Não Definida' }}</h1>
    </div>
    <div class="d-flex flex-column justify-content-between align-items-center">
        <h1 class="text-secondary fs-6">
            R$ {{ number_format($transaction->amount, 2, ',', '.') }}
        </h1>
        <h1 class="text-secondary fs-6">
            {{ $transaction->installments }} {{ Str::plural($installmentLabel) }} de R$ {{ $formattedMensal }}
        </h1>
    </div>
    <div class="d-flex flex-sm-column justify-content-center justify-content-sm-between align-items-center">
        <a href="{{ route('transaction.edit', $transaction) }}" class="btn btn-white text-primary fs-4"><i class="bi bi-pencil-square"></i></a>

        <form action="{{ route('transaction.destroy', $transaction->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-white text-danger mt-3 mt-sm-0 fs-4"><i class="bi bi-trash"></i></button>
        </form>
    </div>
</div>
