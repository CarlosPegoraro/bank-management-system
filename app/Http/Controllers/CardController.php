<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CardController extends Controller
{
    public function index() : RedirectResponse
    {
        return to_route('new-content');
    }

    public function create() : Renderable
    {
        return view('card.create');
    }

    public function store(CardRequest $request) : RedirectResponse
    {
        $user = Auth::user();
        $user->cards()->create($request->all());
        return to_route('home');
    }
}
