<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FxRateController extends Controller
{
    public function latest(): JsonResponse
    {
        $base = strtoupper((string) request()->query('base', 'USD'));
        if (!in_array($base, ['USD', 'CAD', 'RWF'], true)) {
            return response()->json([
                'ok' => false,
                'message' => 'Unsupported base currency.',
            ], 422);
        }

        $symbolsRaw = (string) request()->query('symbols', 'USD,CAD,RWF');
        $symbols = array_values(array_filter(array_map(
            fn ($s) => strtoupper(trim((string) $s)),
            explode(',', $symbolsRaw)
        )));
        $symbols = array_values(array_intersect($symbols, ['USD', 'CAD', 'RWF']));
        if (count($symbols) === 0) {
            $symbols = ['USD', 'CAD', 'RWF'];
        }

        $cacheKey = 'fx:open_er_api:v1:base:' . $base;
        $payload = Cache::remember($cacheKey, now()->addHours(12), function () use ($base) {
            $url = 'https://open.er-api.com/v6/latest/' . urlencode($base);
            $res = Http::timeout(8)->acceptJson()->get($url);
            if (!$res->ok()) {
                return null;
            }
            $json = $res->json();
            if (!is_array($json) || (($json['result'] ?? null) !== 'success')) {
                return null;
            }
            return $json;
        });

        if (!is_array($payload)) {
            return response()->json([
                'ok' => false,
                'message' => 'FX provider unavailable.',
            ], 503);
        }

        $rates = is_array($payload['rates'] ?? null) ? $payload['rates'] : [];
        $outRates = [];
        foreach ($symbols as $sym) {
            $v = $rates[$sym] ?? null;
            if (is_numeric($v)) {
                $outRates[$sym] = (float) $v;
            }
        }

        return response()->json([
            'ok' => true,
            'provider' => $payload['provider'] ?? 'open.er-api.com',
            'base' => $payload['base_code'] ?? $base,
            'time_last_update_utc' => $payload['time_last_update_utc'] ?? null,
            'time_next_update_utc' => $payload['time_next_update_utc'] ?? null,
            'rates' => $outRates,
        ]);
    }
}

