<?php

namespace Tests\Feature;

use App\Models\TransactionSeries;
use App\Models\User;
use App\Services\RecurrenceService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecurrenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_installments_create_one_occurrence_per_month(): void
    {
        $user = User::factory()->create();
        $series = $user->transactionSeries()->create([
            'type' => 'expense', 'amount' => 100,
            'description' => 'Notebook', 'recurrence' => 'installment',
            'starts_on' => Carbon::parse('2026-01-10'), 'ends_on' => Carbon::parse('2026-03-10'),
            'installments' => 3,
        ]);

        app(RecurrenceService::class)->materialize($series, Carbon::parse('2026-06-01'));

        $this->assertSame(3, $user->transactions()->count());
        $this->assertSame([1, 2, 3], $user->transactions()->orderBy('due_date')->pluck('installment_number')->all());
    }
}
