<?php

namespace App\Livewire;

use App\Services\AdminMetricsService;
use Livewire\Component;

class AdminDashboard extends Component
{
    public int $days = 30;

    public function render(AdminMetricsService $metrics)
    {
        return view('livewire.admin-dashboard', [
            'metrics' => $metrics->summarize($this->days),
        ])->layout('layouts.app');
    }
}
