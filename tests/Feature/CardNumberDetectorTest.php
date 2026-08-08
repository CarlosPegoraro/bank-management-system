<?php

use App\Services\CardNumberDetector;

test('the local detector identifies common card brands and validates Luhn', function (string $number, string $brand) {
    $result = app(CardNumberDetector::class)->detect($number);

    expect($result['brand'])->toBe($brand)
        ->and($result['type'])->toBe('credit')
        ->and($result['is_valid'])->toBeTrue();
})->with([
    ['4111111111111111', 'Visa'],
    ['5555555555554444', 'Mastercard'],
    ['378282246310005', 'American Express'],
]);

test('the local detector marks a recognized number with an invalid checksum', function () {
    $result = app(CardNumberDetector::class)->detect('4111111111111112');

    expect($result['brand'])->toBe('Visa')
        ->and($result['is_valid'])->toBeFalse();
});

test('the local detector falls back when the brand is unknown', function () {
    expect(app(CardNumberDetector::class)->detect('1234567890123456'))->toBeNull();
});
