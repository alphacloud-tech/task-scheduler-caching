<?php

namespace App\Http\Controllers;

use App\Models\ApiLog;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    protected $weatherService;

    /**
     * Constructor to inject the WeatherService.
     *
     * @param WeatherService $weatherService
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Get cached weather data.
     *
     * @return JsonResponse
     */
    public function getWeatherData(Request $request): JsonResponse
    {
        // Log the request details
        ApiLog::create([
            'ip_address' => $request->ip(),
            'endpoint' => $request->path(),
            'request_data' => json_encode($request->all()), // Log any request data if necessary
        ]);

        // Check if the data exists in cache
        if (Cache::has('weather_data')) {
            return response()->json([
                'source' => 'cache data',
                'data' => Cache::get('weather_data'),
            ]);
        }

        // If not cached, fetch from the API and store in cache
        $data = Cache::remember('weather_data', 3600, function () {
            return $this->weatherService->getWeatherData();
        });

        return response()->json([
            'source' => 'API data',
            'data' => $data,
        ]);
    }
}