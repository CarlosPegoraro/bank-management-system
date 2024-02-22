<x-layout title="Extrato de Compras">
    <div class="row p-2 p-sm-5"
        style="background-image: url('{{ asset('img/bgMain.png') }}'); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100vh">

        <x-navbar title="Lista de Compras"/>
        <div class="col-12">

            <div class="row align-items-center mt-3 mt-sm-0 mb-4">
                <h1 class="col-12 col-sm-5 text-center text-sm-start text-light fw-bold fs-3 mb-3 mb-sm-0">Lista de Completa de Compras</h1>
                <a class="col-6 col-sm-4 nav-link text-primary fw-bold fs-3" href="{{ route('transaction.create') }}">Nova Compra</a>
                <a class="col-6 col-sm-3 nav-link text-primary fw-bold fs-3" href="{{ route('transaction.extract') }}">Ver Extrato</a>
            </div>


            @php($totalAmount = 0)

            <div class="d-flex flex-column-reverse">

                @foreach ($transactions as $transaction)
                    @php($mensal = round($transaction->amount / $transaction->installments, 2))
                    @php($totalAmount += $mensal)

                    <x-transaction-card :transaction="$transaction" :mensal="$mensal" />
                @endforeach

                <div class="mb-4">
                    <h4 class="text-light">Total Gasto: <span class="text-primary fw-bold">R$
                            {{ number_format($totalAmount, 2, ',', '.') }}</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</x-layout>
