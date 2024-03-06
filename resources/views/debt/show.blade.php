@php($mensal = $debt->amount / $debt->installments)
<x-layout title="Dívida - {{ $debt->store }} - {{ \Carbon\Carbon::parse($debt->date)->format('d/m/Y') }}">
    <div class="row" style="height: 100vh">
        <div class="col-12 col-sm-4 p-5">
            <x-navbar title="Detalhes da Dívida"/>
            <div class="row mt-4">
                <div class="col-12 col-sm-6">
                    <p class="text-dark">{{ __('Store') .':' }} <span class="fw-bold text-primary">{{ $debt->store }}</span></p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="text-dark">{{ __('Bought Date') .':' }} <span class="fw-bold text-primary">{{ \Carbon\Carbon::parse($debt->date)->format('d/m/Y') }}</span></p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="text-dark">{{ __('Due Date') .':' }} <span class="fw-bold text-primary">{{ \Carbon\Carbon::parse($debt->finnally)->format('d/m/Y') }}</span></p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="text-dark">{{ __('Total Amount') .':' }} <span class="fw-bold text-primary" id="formattedTotalAmount"></span></p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="text-dark">{{ __('Installments') .':' }} <span class="fw-bold text-primary">{{ $debt->installments }}</span></p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="text-dark">{{ __('Installment Value') .':' }} <span class="fw-bold text-primary" id="formattedMensal"></span></p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="text-dark">{{ __('Description') .':' }} <span class="fw-bold text-primary">{{ $debt->description }}</span></p>
                </div>
            </div>
        </div>
        <div class="d-none d-md-block col-sm-8"
            style="background-image: url('{{ asset('img/authBackground.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center">
        </div>
    </div>
</x-layout>

<script>
    var totalAmount = {{ $debt->amount }};

    var formattedTotalAmount = (totalAmount).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    // Atualizando o conteúdo da span com o valor formatado
    document.getElementById('formattedTotalAmount').innerText = formattedTotalAmount;

    var mensal = {{ $mensal }};

    var formattedMensal = (mensal).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    // Atualizando o conteúdo da span com o valor formatado
    document.getElementById('formattedMensal').innerText = formattedMensal;
</script>
