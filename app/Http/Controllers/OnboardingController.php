<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function event(Request $request): JsonResponse
    {
        $data = $request->validate([
            'tour' => ['required', 'string', 'max:80'],
            'event' => ['required', 'in:opened,step,completed,skipped'],
            'step' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $request->user()->onboardingEvents()->create([
            ...$data,
            'route' => $request->header('referer'),
        ]);

        if ($data['event'] === 'completed' && $data['tour'] === 'first-access') {
            $request->user()->forceFill(['onboarding_completed_at' => now()])->save();
        }

        return response()->json(['ok' => true]);
    }

    public function feedback(Request $request): JsonResponse
    {
        $data = $request->validate([
            'article' => ['nullable', 'string', 'max:160'],
            'type' => ['required', 'in:helpful,not_helpful,suggestion,problem'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $request->user()->supportFeedback()->create($data);

        return response()->json(['ok' => true]);
    }
}
