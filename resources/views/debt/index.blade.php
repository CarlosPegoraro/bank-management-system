<x-layout title="Home">
    <div id="bg" class="row p-2 p-sm-5 height-image" style="">

        <div class="col-12 col-sm-5 bg-white p-4 rounded-lg">

            <div class="row align-items-center mt-3 mt-sm-0 mb-4">
                <h1 class="col-12 col-sm-5 text-center text-sm-start fw-bold fs-3 mb-3 mb-sm-0">{{ __('List of Recurring Debts') }}</h1>
                <a class="col-6 col-sm-4 nav-link text-primary text-center fw-bold fs-3" href="{{ route('debt.create') }}">{{ __('New Debt') }}</a>
                <a class="col-6 col-sm-3 nav-link text-primary fw-bold fs-3"
                    href="{{ route('debt.extract') }}">{{ __('See Extract') }}</a>
            </div>

            @php($totalAmount = 0)

            <div class="d-flex flex-column-reverse">

                <div class="scroll-container pe-3">
                    @php($count = 1)
                    @foreach ($debts as $debt)
                        @php($mensal = round($debt->amount / $debt->installments, 2))
                        @php($totalAmount += $mensal)

                        <x-debt-card :debt="$debt" :mensal="$mensal" :count="$count"/>
                        @php($count++)
                    @endforeach
                </div>

                <div class="mb-4">
                    <h4 class="text-dark">
                        {{ __('Total Month') }} <span id="formattedTotalAmount" class="text-primary fw-bold"></span>
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
