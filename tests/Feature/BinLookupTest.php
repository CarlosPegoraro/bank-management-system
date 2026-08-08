<?php

use App\Livewire\FinancialAccountsPage;
use App\Models\User;
use App\Services\BinLookupService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

test('the BIN lookup requests only the first six digits and caches the response', function () {
    config(['services.api_ninjas.key' => 'test-key']);
    Http::fake([
        'https://api.api-ninjas.com/v2/bin*' => Http::response([[
            'bin' => '405316',
            'brand' => 'Visa',
            'type' => 'credit',
            'issuer' => 'Example Bank',
            'country' => 'United States',
        ]]),
    ]);
    Cache::forget('bin-lookup:405316');
    Cache::forget('bin-lookup-calls:'.now()->format('Y-m'));

    $service = app(BinLookupService::class);
    $first = $service->lookup('4053 16 1234 5678');
    $second = $service->lookup('4053169999999999');

    expect($first['brand'])->toBe('Visa')
        ->and($second['issuer'])->toBe('Example Bank');
    Http::assertSentCount(1);
    Http::assertSent(fn ($request): bool => $request->url() === 'https://api.api-ninjas.com/v2/bin?bin=405316'
        && $request->header('X-Api-Key')[0] === 'test-key');
});

test('BIN lookup gracefully falls back when no API key is configured', function () {
    config(['services.api_ninjas.key' => null]);

    expect(app(BinLookupService::class)->lookup('4053161234567890'))->toBeNull();
});

test('BIN lookup stops calling the API after the monthly limit', function () {
    config(['services.api_ninjas.key' => 'test-key', 'services.api_ninjas.monthly_limit' => 2]);
    Http::fake(['https://api.api-ninjas.com/v2/bin*' => Http::response([['brand' => 'Visa']])]);
    Cache::forget('bin-lookup-calls:'.now()->format('Y-m'));
    foreach (['405316', '405317', '405318'] as $bin) {
        Cache::forget('bin-lookup:'.$bin);
    }

    $service = app(BinLookupService::class);
    $service->lookup('4053161234567890');
    $service->lookup('4053171234567890');
    expect($service->lookup('4053181234567890'))->toBeNull()
        ->and($service->monthlyLimitReached())->toBeTrue();
    Http::assertSentCount(2);
});

test('the card form detects the brand locally after clicking consult', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(FinancialAccountsPage::class)
        ->set('card.number', '4053161234567890')
        ->assertSet('card.brand', '')
        ->call('lookupCardBin')
        ->assertSet('card.brand', 'Visa');

    Http::assertNothingSent();
});
