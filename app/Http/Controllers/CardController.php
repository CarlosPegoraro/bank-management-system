<?php

namespace App\Http\Controllers;

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
}
