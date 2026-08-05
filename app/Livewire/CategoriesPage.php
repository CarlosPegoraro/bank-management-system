<?php

namespace App\Livewire;

use Livewire\Component;

class CategoriesPage extends Component
{
    public string $name = '';

    public string $type = 'expense';

    public function save()
    {
        $d = $this->validate(['name' => 'required|max:80', 'type' => 'required|in:income,expense']);
        auth()->user()->categories()->create($d);
        $this->reset('name');
    }

    public function archive($id)
    {
        auth()->user()->categories()->findOrFail($id)->update(['is_archived' => true]);
    }

    public function render()
    {
        return view('livewire.categories-page', ['categories' => auth()->user()->categories()->orderBy('type')->orderBy('name')->get()])->layout('layouts.app');
    }
}
