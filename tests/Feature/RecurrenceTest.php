<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\RecurrenceService;
use Carbon\Carbon;

test('installments create one occurrence per month', function () {
    $user = User::factory()->create();
    $series = $user->transactionSeries()->create([
        'type' => 'expense', 'amount' => 100,
        'description' => 'Notebook', 'recurrence' => 'installment',
        'starts_on' => Carbon::parse('2026-01-10'), 'ends_on' => Carbon::parse('2026-03-10'),
        'installments' => 3,
    ]);

    app(RecurrenceService::class)->materialize($series, Carbon::parse('2026-06-01'));
    app(RecurrenceService::class)->materialize($series, Carbon::parse('2026-06-01'));

    expect($user->transactions()->count())->toBe(3)
        ->and($user->transactions()->orderBy('due_date')->pluck('installment_number')->all())->toBe([1, 2, 3]);
});
