<x-layout title="Home">
    <div id="bg" class="row p-2 p-sm-5 height-image" style="">

        <div class="col-12 col-sm-5 bg-white p-4 rounded-lg">

            <div class="row align-items-center mt-3 mt-sm-0 mb-4">
                <h1 class="col-12 col-sm-5 text-center text-sm-start fw-bold fs-3 mb-3 mb-sm-0">Lista de
                    Dívidas Recorrentes</h1>
                <a class="col-6 col-sm-4 nav-link text-primary text-center fw-bold fs-3" href="{{ route('transaction.create') }}">Adicionar
                    Compra</a>
                <a class="col-6 col-sm-3 nav-link text-primary fw-bold fs-3"
                    href="{{ route('transaction.extract') }}">Ver
                    Extrato</a>
            </div>

            @php($totalAmount = 0)

            <div class="d-flex flex-column-reverse">

                <div class="scroll-container pe-3">
                    @foreach ($transactions as $transaction)
                        @php($mensal = round($transaction->amount / $transaction->installments, 2))
                        @php($totalAmount += $mensal)

                        <x-transaction-card :transaction="$transaction" :mensal="$mensal" />
                    @endforeach
                </div>

                <div class="mb-4">
                    <h4 class="text-dark">Total desse mês: <span class="text-primary fw-bold">R$
                            {{ number_format($totalAmount, 2, ',', '.') }}</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</x-layout>
