<div id="bg" class="row p-2 p-sm-5 height-image">
    @foreach ($cards as $card)
        <div class="col-12 col-sm-5 bg-white p-4 rounded-lg">

            <div class="row align-items-center mt-3 mt-sm-0 mb-4">
                <h1 class="col-12 col-sm-5 text-center text-sm-start fw-bold fs-3 mb-3 mb-sm-0">
                    {{ __('List of Recurring Debts') }}</h1>
                <a class="col-6 col-sm-4 nav-link text-primary text-center fw-bold fs-3"
                    href="{{ route('debt.create') }}">{{ __('New Debt') }}</a>
                <a class="col-6 col-sm-3 nav-link text-primary fw-bold fs-3"
                    href="{{ route('debt.extract') }}">{{ __('See Extract') }}</a>
            </div>

            @php($totalAmount = 0)

            <div class="d-flex flex-column-reverse">

                <div class="scroll-container pe-3">
                    <livewire:debt :card="$card" :totalAmount="$totalAmount" />
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-7 p-4 rounded-lg">

            <div class="row align-items-center mt-3 mt-sm-0 mb-4">
                <h1 class="col-12 col-sm-6 text-center text-white text-sm-start fw-bold fs-3 mb-3 mb-sm-0">
                    {{ __('Registered Cards') }}</h1>
                <a class="col-6 nav-link text-primary fw-bold fs-3"
                    href="{{ route('card.create') }}">{{ __('New Card') }}</a>
            </div>

        </div>

        <x-card :card="$card" :totalAmount="$totalAmount" />
    @endforeach

    <div class="d-flex justify-content-center align-items-center mt-3">
        {{ $cards->links() }}
    </div>
</div>
