<x-layout title="Cadastrar Dívida">
    <div class="row" style="height: 100vh">
        <div class="col-12 col-sm-4 p-5">
            <x-navbar title="{{ __('New Card') }}"/>
            <h1 class="text-secondary my-4">{{ __('Register New Card') }}</h1>
            <form action="{{ route('card.store') }}" method="post">
                @csrf
                <div class="d-flex flex-column gap-3">
                    <div class="form-group">
                        <label for="owner" class="form-label">{{ __('Owner') }}</label>
                        <input required type="text" name="owner" id="owner" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="number" class="form-label">{{ __('Number') }}</label>
                        <input required type="text" step="0.01" name="number" id="number" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <input type="text" name="description" id="description" class="form-control"/>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">{{ __('Register') }}</button>
            </form>
        </div>
        <div class="d-none d-md-block col-sm-8"
            style="background-image: url('{{ asset('img/authBackground.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center">
        </div>
    </div>
</x-layout>


