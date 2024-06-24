<x-layout title="Cadastrar Dívida">
    <div class="row" style="height: 100vh">
        <div class="col-12 col-sm-4 p-5">
            <x-navbar title="New Card"/>
            <h1 class="text-secondary my-4">{{ __('Register New Card') }}</h1>
            <form action="{{ route('card.store') }}" method="post">
                @csrf
                <div class="d-flex flex-column gap-3">
                    {{-- To Do: add a mask --}}
                    <div class="form-group">
                        <label for="number" class="form-label">{{ __('Card Number') }}</label>
                        <input required type="text" maxlength="16" name="number" id="number" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="bank" class="form-label">{{ __('Bank') }}</label>
                        <input required type="text" name="bank" id="bank" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <input type="text" name="description" id="description" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="owner" class="form-label">{{ __('Card Owner') }}</label>
                        <input required type="text" name="owner" id="owner" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="validateDay" class="form-label">{{ __('Validate Date') }}</label>
                        <input required type="number" name="validateDay" id="validateDay" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="paymentDay" class="form-label">{{ __('Payment Date') }}</label>
                        <input required type="number" name="paymentDay" id="paymentDay" class="form-control"/>
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


