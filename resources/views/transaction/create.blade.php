<x-layout title="Home">
    <div class="row" style="height: 100vh">
        <div class="col-12 col-sm-4 p-5">
            <x-navbar title="Nova Compra"/>
            <h1 class="text-secondary mb-4">Registar nova compra</h1>
            <form action="{{ route('transaction.store') }}" method="post">
                @csrf
                <div class="d-flex flex-column gap-3">
                    <div class="form-group">
                        <label for="store" class="form-label">Loja</label>
                        <input required type="text" name="store" id="store" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">Descrição</label>
                        <input type="text" name="description" id="description" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="form-label">Valor Total</label>
                        <input required type="number" step="0.01" name="amount" id="amount" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="installments" class="form-label">Número de Parcelas</label>
                        <input required type="number" name="installments" id="installments" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="date" class="form-label">Data da Compra</label>
                        <input required type="date" name="date" id="date" class="form-control"/>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Cadastrar</button>
            </form>
        </div>
        <div class="d-none d-md-block col-sm-8"
            style="background-image: url('{{ asset('img/authBackground.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center">
        </div>
    </div>
</x-layout>
