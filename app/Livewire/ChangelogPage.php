<?php

namespace App\Livewire;

use Livewire\Component;

class ChangelogPage extends Component
{
    public function render()
    {
        return view('changelog')->layout('layouts.app');
    }
}
