<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AccountBalanceService;
use App\Services\TransferService;

test('a confirmed transfer moves realized balance between accounts without changing consolidated balance', function () {
    $user = User::factory()->create();
    $origin = $user->accounts()->create(['name' => 'Corrente', 'initial_balance' => 1000]);
    $destination = $user->accounts()->create(['name' => 'Reserva', 'initial_balance' => 100]);
    $transfer = app(TransferService::class)->create($user, [
        'from_account_id' => $origin->id, 'to_account_id' => $destination->id,
        'amount' => 300, 'transfer_date' => '2026-08-07', 'status' => 'settled',
    ]);

    $service = app(AccountBalanceService::class);
    $originSummary = $service->summarize($origin->refresh());
    $destinationSummary = $service->summarize($destination->refresh());
    $consolidated = $service->summarizeForUser($user)['consolidated'];

    expect($transfer->status)->toBe('settled')
        ->and($originSummary['realized_balance'])->toBe(700.0)
        ->and($destinationSummary['realized_balance'])->toBe(400.0)
        ->and($consolidated['realized_balance'])->toBe(1100.0);
});

test('a pending transfer affects projected balances and cancellation removes its effect', function () {
    $user = User::factory()->create();
    $origin = $user->accounts()->create(['name' => 'Corrente', 'initial_balance' => 1000]);
    $destination = $user->accounts()->create(['name' => 'Poupança', 'initial_balance' => 0]);
    $service = app(TransferService::class);
    $transfer = $service->create($user, [
        'from_account_id' => $origin->id, 'to_account_id' => $destination->id,
        'amount' => 250, 'transfer_date' => '2026-08-10', 'status' => 'pending',
    ]);

    $originProjected = app(AccountBalanceService::class)->summarize($origin->refresh())['projected_balance'];
    expect($originProjected)->toBe(750.0);

    $service->cancel($transfer);
    expect(app(AccountBalanceService::class)->summarize($origin->refresh())['projected_balance'])->toBe(1000.0)
        ->and($transfer->refresh()->status)->toBe('canceled');
});

test('a transfer cannot use the same account twice', function () {
    $user = User::factory()->create();
    $account = $user->accounts()->create(['name' => 'Conta']);

    expect(fn () => app(TransferService::class)->create($user, [
        'from_account_id' => $account->id, 'to_account_id' => $account->id,
        'amount' => 10, 'transfer_date' => '2026-08-07', 'status' => 'pending',
    ]))->toThrow(\InvalidArgumentException::class);
});
