<x-layout title="Extrato de Compras">
    <div class="row p-2 p-sm-5"
        style="background-image: url('{{ asset('img/bgMain.png') }}'); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100vh">

        <div class="col-12">
            <x-navbar title="Lista de Compras"/>

            <div class="row align-items-center  my-4">
                <h1 class="col-6 text-center text-sm-start text-light fw-bold fs-3 mb-3 mb-sm-0">{{ __('All Debts') }}</h1>
                <a class="col-6 nav-link text-primary fw-bold fs-3" href="{{ route('transaction.create') }}">{{ __('New Debt') }}</a>
            </div>


            @php($totalAmount = 0)

            <div class="d-flex flex-column-reverse">
                @php($count = 1)
                @foreach ($transactions as $transaction)
                    @php($mensal = round($transaction->amount / $transaction->installments, 2))
                    @php($totalAmount += $mensal)

                    <x-transaction-card :transaction="$transaction" :mensal="$mensal" :count="$count"/>
                    @php($count++)
                @endforeach

                <div class="mb-4">
                    <h4 class="text-light">
                        {{ __('Total Amount') . ':' }}
                        <span class="text-primary fw-bold" id="formattedTotalAmount"></span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>
    var totalAmount = {{ $totalAmount }};

    var formattedTotalAmount = (totalAmount).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    // Atualizando o conteúdo da span com o valor formatado
    document.getElementById('formattedTotalAmount').innerText = formattedTotalAmount;
</script>
