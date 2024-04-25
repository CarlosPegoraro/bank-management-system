<x-layout title="Editar Dívida">
    <div class="row" style="height: 100vh">
        <div class="col-12 col-sm-4 p-5">
            <x-navbar title="Nova Compra"/>
            <h1 class="text-secondary my-4">{{ __('Edit Debt') }}</h1>
            <form action="{{ route('debt.update', $debt) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="d-flex flex-column gap-3">
                    <div class="form-group">
                        <label for="store" class="form-label">{{ __('Store') }}</label>
                        <input required type="text" name="store" id="store" class="form-control" value="{{ $debt->store ?: old('store') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <input type="text" name="description" id="description" class="form-control" value="{{ $debt->description ?: old('description') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="form-label">{{ __('Total Amount') }}</label>
                        <input required type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $debt->amount ?: old('amount') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="installments" class="form-label">{{ __('Installments') }}</label>
                        <input required type="number" name="installments" id="installments" class="form-control" value="{{ $debt->installments ?: old('installments') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="date" class="form-label">{{ __('Bought Date') }}</label>
                        <input required type="date" name="date" id="date" class="form-control" value="{{ $debt->date ?: old('date') }}" />
                    </div>
                    <div class="form-group">
                        <label for="card_id" class="form-label">{{ __('Card') }}</label>
                        <select required name="card_id" id="card_id" class="form-control">
                            <option value="{{ $debt->card?->id }}">{{ $debt->card?->number }}</option>
                            @foreach ($cards as $card)
                                <option value="{{ $card->id }}">{{ $card->number }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">{{ __('Update') }}</button>
            </form>
        </div>
        <div class="d-none d-md-block col-sm-8"
            style="background-image: url('{{ asset('img/authBackground.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center">
        </div>
    </div>
</x-layout>
