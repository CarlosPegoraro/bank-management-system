<?php

namespace App\Services;

use App\Models\User;

class OnboardingProgressService
{
    public const STEPS = [
        'profile' => 'Completar o perfil',
        'account' => 'Cadastrar uma conta',
        'category' => 'Revisar categorias',
        'transaction' => 'Registrar a primeira transação',
        'dashboard' => 'Conhecer o dashboard',
    ];

    public function sync(User $user): void
    {
        $completed = [
            'profile' => filled($user->name) && filled($user->email),
            'account' => $user->accounts()->exists(),
            'category' => $user->categories()->exists(),
            'transaction' => $user->transactions()->exists(),
            'dashboard' => $user->onboarding_completed_at !== null,
        ];

        foreach ($completed as $step => $isComplete) {
            $progress = $user->onboardingProgress()->firstOrCreate(['step' => $step]);
            if ($isComplete && ! $progress->completed_at) {
                $progress->update(['completed_at' => now()]);
            }
        }
    }

    public function summary(User $user): array
    {
        $this->sync($user);
        $progress = $user->onboardingProgress()->pluck('completed_at', 'step');

        return collect(self::STEPS)->map(fn (string $label, string $step) => [
            'step' => $step,
            'label' => $label,
            'completed' => filled($progress->get($step)),
        ])->values()->all();
    }
}
