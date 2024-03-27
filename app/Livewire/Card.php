<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Card extends Component
{
    public function render()
    {
        $user = Auth::user();
        $cards = $user->cards;
        return view('livewire.card', compact('cards'));
    }
}
