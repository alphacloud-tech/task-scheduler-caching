<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeatherData(): array
    {
        $response = Http::get(env('WEATHER_API_URL'), [
            'key' => env('WEATHER_API_KEY'),
            'q' => 'Lagos',
        ]);

        if ($response->failed()) {
            return ['error' => 'Failed to fetch data'];
        }

        return $response->json();
    }
}