<?php

namespace App\Http\Controllers;

use App\Livewire\Card;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CardController extends Controller
{
    public function create(): Renderable
    {
        return view('card.create');
    }

    public function store(): RedirectResponse
    {
        $user = Auth::user();
        $user->cards()->create(request()->all());
        return redirect()->route('home');
    }

    public function addCredit(Request $request, Card $card): RedirectResponse
    {
        $card->credit += $request->credit;
        $card->save();
        return redirect()->route('home');
    }
}
