<x-layout title="Home">
    <div class="d-flex align-items-center gap-5 mb-4">
        <h2 class="text-primary">Lista de Compras</h2>
        <a class="btn btn-primary h-fit" style="height: fit-content" href="{{ route('transaction.create') }}">Cadastrar nova</a>
    </div>
    <h3 class="text-secondary mb-4">Bem vindo de volta, {{ auth()->user()->name }}!</h3>

    @php
        $totalAmount = 0;
        $count = 0;
    @endphp

    <div class="d-flex flex-column-reverse">

        @foreach ($transactions as $transaction)
            @php
                $mensal = round($transaction->amount / $transaction->installments, 2);
                $totalAmount += $mensal;
                $count++
            @endphp

            <div class="row border-1 border-bottom py-1 border-primary my-3 pb-1">

                <div class="col-12 col-sm-2 d-flex gap-3 border-1 border-end border-subtl-black ps-3">
                    <h1 class="fs-6">{{ $count }}.</h1>
                    <h1 class="fs-6">Data: {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</h1>
                </div>

                <div class="col-12 col-sm-2 border-1 border-end border-subtl-black ps-3">
                    <h1 class="fs-6">Loja: {{ $transaction->store }}</h1>
                </div>
                <div class="col-12 col-sm-2 border-1 border-end border-subtl-black ps-3">
                    <h1 class="fs-6">Total: {{ number_format($transaction->amount, 2, ',', '.') }}</h1>
                </div>
                <div class="col-12 col-sm-2 border-1 border-end border-subtl-black ps-3">
                    <h1 class="fs-6">Data de quitação: {{ \Carbon\Carbon::parse($transaction->finnaly)->format('d/m/Y') }}</h1>
                </div>
                <div class="col-12 col-sm-2 border-1 border-end border-subtl-black ps-3">
                    <h1 class="fs-6">Parcelas: {{ $transaction->installments }}</h1>
                </div>
                <div class="col-12 col-sm-2 border-1 border-end border-subtl-black ps-3">
                    <h1 class="fs-6">Mensaldade: {{ number_format($mensal, 2, ',', '.') }}</h1>
                </div>
            </div>
        @endforeach

        <!-- Display Total Amount at the Top -->
        <div class="mb-4">
            <h4 class="text-black">Total desse mês: <span class="text-danger">R$ {{ number_format($totalAmount, 2, ',', '.') }}</span></h4>

        </div>
    </div>
</x-layout>
