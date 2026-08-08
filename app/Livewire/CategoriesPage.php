<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CategoriesPage extends Component
{
    public string $name = '';

    public string $type = 'expense';

    public string $successMessage = '';

    public function save()
    {
        $d = $this->validate(['name' => 'required|max:80', 'type' => 'required|in:income,expense']);
        auth()->user()->categories()->create($d);
        $this->reset('name');
        $this->successMessage = 'Categoria adicionada com sucesso.';
    }

    public function archive($id)
    {
        $category = auth()->user()->categories()->findOrFail($id);
        Gate::forUser(auth()->user())->authorize('update', $category);
        $category->update(['is_archived' => true]);
        $this->successMessage = 'Categoria arquivada.';
    }

    public function render()
    {
        return view('livewire.categories-page', ['categories' => auth()->user()->categories()->orderBy('type')->orderBy('name')->get()])->layout('layouts.app');
    }
}
