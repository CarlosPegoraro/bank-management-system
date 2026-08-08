<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BinLookupService
{
    public function isConfigured(): bool
    {
        return filled(config('services.api_ninjas.key'));
    }

    public function monthlyLimitReached(): bool
    {
        return (int) Cache::get($this->usageKey(), 0) >= (int) config('services.api_ninjas.monthly_limit', 9500);
    }

    /** @return array<string, mixed>|null */
    public function lookup(string $cardNumber): ?array
    {
        $digits = preg_replace('/\D+/', '', $cardNumber) ?? '';
        if (strlen($digits) < 6 || ! $this->isConfigured()) {
            return null;
        }

        $bin = substr($digits, 0, 6);
        $responseKey = 'bin-lookup:'.$bin;
        if (Cache::has($responseKey)) {
            return Cache::get($responseKey);
        }
        if (! $this->reserveMonthlyCall()) {
            return null;
        }

        try {
            $response = Http::acceptJson()
                ->withHeaders(['X-Api-Key' => config('services.api_ninjas.key')])
                ->timeout(4)
                ->get(config('services.api_ninjas.bin_url'), ['bin' => $bin]);

            if ($response->failed()) {
                return null;
            }

            $payload = $response->json();
            if (is_array($payload) && array_is_list($payload)) {
                $payload = $payload[0] ?? null;
            }
            if (! is_array($payload)) {
                return null;
            }

            Cache::put($responseKey, $payload, now()->addDay());

            return $payload;
        } catch (\Throwable) {
            return null;
        }
    }

    private function reserveMonthlyCall(): bool
    {
        $key = $this->usageKey();
        $limit = (int) config('services.api_ninjas.monthly_limit', 9500);
        Cache::add($key, 0, now()->endOfMonth()->endOfDay());

        return (int) Cache::increment($key) <= $limit;
    }

    private function usageKey(): string
    {
        return 'bin-lookup-calls:'.now()->format('Y-m');
    }
}
