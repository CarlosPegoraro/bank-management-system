<?php

namespace App\Services;

class CardNumberDetector
{
    /** @return array{brand: string, type: string, is_valid: bool}|null */
    public function detect(string $cardNumber): ?array
    {
        $digits = preg_replace('/\D+/', '', $cardNumber) ?? '';
        if ($digits === '') {
            return null;
        }

        $brand = match (true) {
            $this->matches($digits, '/^(401178|401179|431274|438935|451416|457393|457631|504175|627780|636297|636368|636369)\d{10}$/') => 'Elo',
            $this->matches($digits, '/^(606282\d{10}|3841\d{12})$/') => 'Hipercard',
            $this->matches($digits, '/^4\d{12}(?:\d{3}|\d{6})?$/') => 'Visa',
            $this->matches($digits, '/^(?:5[1-5]\d{2}|2(?:2(?:2[1-9]|[3-9]\d)|[3-6]\d{2}|27(?:[01]\d|20)))\d{12}$/') => 'Mastercard',
            $this->matches($digits, '/^3[47]\d{13}$/') => 'American Express',
            $this->matches($digits, '/^(?:6011\d{12}|65\d{14}|65\d{17}|64[4-9]\d{13})$/') => 'Discover',
            $this->matches($digits, '/^3(?:0[0-5]|6|8)\d{11}$/') => 'Diners Club',
            $this->matches($digits, '/^35(?:2[89]|[3-8]\d)\d{12}$/') => 'JCB',
            default => null,
        };

        return $brand === null ? null : [
            'brand' => $brand,
            'type' => 'credit',
            'is_valid' => $this->passesLuhn($digits),
        ];
    }

    private function matches(string $digits, string $pattern): bool
    {
        return preg_match($pattern, $digits) === 1;
    }

    private function passesLuhn(string $digits): bool
    {
        $sum = 0;
        $shouldDouble = false;
        for ($index = strlen($digits) - 1; $index >= 0; $index--) {
            $digit = (int) $digits[$index];
            if ($shouldDouble) {
                $digit *= 2;
                $digit = $digit > 9 ? $digit - 9 : $digit;
            }
            $sum += $digit;
            $shouldDouble = ! $shouldDouble;
        }

        return $sum > 0 && $sum % 10 === 0;
    }
}
