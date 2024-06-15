<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index() {
        return to_route('new-content');
    }

    public function create() {
        return view('card.create');
    }
}
