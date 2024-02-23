@php($mensal = $transaction->amount / $transaction->installments)
<x-layout title="Dívida - {{ $transaction->store }} - {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}">
    <div class="row" style="height: 100vh">
        <div class="col-12 col-sm-4 p-5">
            <x-navbar title="Detalhes da Dívida"/>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <p class="text-dark">Loja: <span class="fw-bold text-primary">{{ $transaction->store }}</span></p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="text-dark">Data da Compra: <span class="fw-bold text-primary">{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</span></p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="text-dark">Data Final: <span class="fw-bold text-primary">{{ \Carbon\Carbon::parse($transaction->finnally)->format('d/m/Y') }}</span></p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="text-dark">Total da Compra: <span class="fw-bold text-primary">R$ {{ number_format($transaction->amount, 2, ',', '.') }}</span></p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="text-dark">Quantidade de Parcelas: <span class="fw-bold text-primary">{{ $transaction->installments }}</span></p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="text-dark">Valor Por Parcela: <span class="fw-bold text-primary">R$ {{ number_format($mensal, 2, ',', '.') }}</span></p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="text-dark">Descrição: <span class="fw-bold text-primary">{{ $transaction->description }}</span></p>
                </div>
            </div>
        </div>
        <div class="d-none d-md-block col-sm-8"
            style="background-image: url('{{ asset('img/authBackground.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center">
        </div>
    </div>
</x-layout>
