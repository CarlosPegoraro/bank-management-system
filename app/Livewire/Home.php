<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // public function paginationView()
    // {
    //     return 'components.paginate';
    // }

    public function render()
    {
        $user = Auth::user();
        $cards = $user->cards()->paginate(1);
        return view('livewire.home', compact('cards'));
    }
}
