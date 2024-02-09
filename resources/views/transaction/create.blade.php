<x-layout title="Home">
    <h1 class="text-success mb-4">Registar nova compra</h1>
    <form action="{{ route('transaction.store') }}" method="post">
        @csrf

        <div class="d-flex flex-col flex-sm-row gap-5">
            <div class="form-group">
                <label for="date" class="form-label">Data da Compra</label>
                <input required type="date" name="date" id="date" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="store" class="form-label">Loja</label>
                <input required type="text" name="store" id="store" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="amount" class="form-label">Valor</label>
                <input required type="number" step="0.01" name="amount" id="amount" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="installments" class="form-label">Parcelas</label>
                <input required type="number" name="installments" id="installments" class="form-control"/>
            </div>
        </div>
        <button type="submit" class="btn btn-success mt-4">Registrar</button>
    </form>
</x-layout>