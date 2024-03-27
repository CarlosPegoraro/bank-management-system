<div>
    @foreach ($cards as $card)
        <div class="d-flex flex-column bg-white p-4 rounded-4 gap-3">
            <div class="d-flex justify-content-between align-items-center pe-5">
                <h4 class="text-black fw-bold">{{ $card->number }}</h4>
                <a href="{{ route('card.addCredit', $card) }}" class="text-primary fw-bold h4">{{ __('Add Credit') }}</a>
            </div>
            <h4 class="text-primary fw-bold" id="credit">R$ {{ $card->credit ?? '0,00' }}</h4>
            <h4 class="text-gray">{{ $card->description }}</h4>
            <h2 class="text-black fw-bold">{{ $card->owner }}</h2>
        </div>
    @endforeach
</div>
