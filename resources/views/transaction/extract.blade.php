<x-layout title="Home">
    <div class="row p-2 p-sm-5"
        style="background-image: url('{{ asset('img/bgMain.png') }}'); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100vh">

        <div class="col-12">

            <div class="row align-items-center mt-3 mt-sm-0 mb-4">
                <h1 class="col-12 col-sm-5 text-center text-sm-start text-light fw-bold fs-3 mb-3 mb-sm-0">Lista de Compras</h1>
                <a class="col-6 col-sm-4 nav-link text-primary fw-bold fs-3" href="{{ route('transaction.create') }}">Nova Compra</a>
                <a class="col-6 col-sm-3 nav-link text-primary fw-bold fs-3" href="{{ route('transaction.extract') }}">Ver Extrato</a>
            </div>


            @php($totalAmount = 0)

            <div class="d-flex flex-column-reverse">

                @foreach ($transactions as $transaction)
                    @php($mensal = round($transaction->amount / $transaction->installments, 2))
                    @php($totalAmount += $mensal)

                    <div class="d-flex flex-column gap-1 mb-2 p-2 px-3 rounded-3 bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="text-secondary fs-5">{{ $transaction->store }} -
                                {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</h1>
                            <h1 class="text-secondary fs-5">R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                            </h1>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="fs-5">descricao</h1>
                            <h1 class="text-secondary fs-5">{{ $transaction->installments }} de R$
                                {{ number_format($mensal, 2, ',', '.') }}</h1>
                        </div>
                    </div>
                @endforeach

                <div class="mb-4">
                    <h4 class="text-light">Total desse mês: <span class="text-primary fw-bold">R$
                            {{ number_format($totalAmount, 2, ',', '.') }}</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</x-layout>
