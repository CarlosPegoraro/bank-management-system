<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $debts = $user->debts()->where('finnaly', '>=', now()->format('Y-m-d'))->orderBy('finnaly', 'desc')->get();
        $cards = $user->cards()->get();

        return view('home', compact('debts', 'cards'));
    }
}
