<?php

namespace App\Livewire;

use Livewire\Component;

class FinancialAccountsPage extends Component
{
    public array $account = ['name' => '', 'type' => 'checking', 'initial_balance' => ''];

    public array $card = ['name' => '', 'brand' => '', 'closing_day' => '', 'due_day' => '', 'limit' => ''];

    public function saveAccount()
    {
        $d = $this->validate(['account.name' => 'required|max:100', 'account.type' => 'required|in:checking,savings,cash', 'account.initial_balance' => 'nullable|numeric']);
        auth()->user()->accounts()->create($d['account']);
        $this->account = ['name' => '', 'type' => 'checking', 'initial_balance' => ''];
    }

    public function saveCard()
    {
        $d = $this->validate(['card.name' => 'required|max:100', 'card.brand' => 'nullable|max:50', 'card.closing_day' => 'required|numeric|between:1,31', 'card.due_day' => 'required|numeric|between:1,31', 'card.limit' => 'nullable|numeric|min:0']);
        auth()->user()->creditCards()->create($d['card']);
        $this->card = ['name' => '', 'brand' => '', 'closing_day' => '', 'due_day' => '', 'limit' => ''];
    }

    public function render()
    {
        return view('livewire.financial-accounts-page', ['accounts' => auth()->user()->accounts()->where('is_archived', false)->get(), 'cards' => auth()->user()->creditCards()->where('is_archived', false)->get()])->layout('layouts.app');
    }
}
