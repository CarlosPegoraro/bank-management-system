<?php

namespace App\Services;

use App\Models\OnboardingEvent;
use App\Models\SupportFeedback;
use App\Models\User;
use Illuminate\Support\Carbon;

class AdminMetricsService
{
    public function summarize(int $days = 30): array
    {
        $since = now()->subDays($days)->startOfDay();
        $activeSince = now()->subDays(30);

        return [
            'users' => User::count(),
            'new_users' => User::where('created_at', '>=', $since)->count(),
            'active_users' => User::where('last_login_at', '>=', $activeSince)->count(),
            'completed_onboarding' => User::whereNotNull('onboarding_completed_at')->count(),
            'onboarding_started' => OnboardingEvent::where('tour', 'first-access')->where('event', 'opened')->distinct('user_id')->count('user_id'),
            'feedback' => SupportFeedback::where('created_at', '>=', $since)->count(),
            'recent_users' => User::query()->select(['id', 'name', 'email', 'role', 'last_login_at', 'created_at'])->latest()->limit(10)->get(),
            'event_breakdown' => OnboardingEvent::query()->where('created_at', '>=', $since)->selectRaw('event, count(*) as total')->groupBy('event')->orderByDesc('total')->pluck('total', 'event'),
            'period_start' => Carbon::parse($since)->toDateString(),
        ];
    }
}
