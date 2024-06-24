<x-layout title="Home">
    <div>
        @foreach ($cards as $card)
            <p>aqui é um cartao</p>
        @endforeach
        <div>
            {{ $cards->links() }}
        </div>
    </div>
</x-layout> 

