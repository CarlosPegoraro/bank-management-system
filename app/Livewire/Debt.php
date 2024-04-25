<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Debt extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $card;
    public $totalAmount;

    public function render()
    {
        $totalAmount = $this->totalAmount;
        $debts = $this->card->debts()?->where('finnaly', '>=', now()->format('Y-m-d'))->orderBy('finnaly', 'desc')->paginate(5);
        return view('livewire.debt', compact('debts', 'totalAmount'));
    }
}
