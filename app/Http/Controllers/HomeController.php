<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home(): Renderable
    {
        $user = Auth::user();
        $cards = $user->cards()->paginate();
        return view('home', compact('cards'));
    }
}
