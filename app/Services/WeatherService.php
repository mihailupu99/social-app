<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('WEATHER_API_KEY'); // Set this in your `.env`
        $this->baseUrl = 'https://api.openweathermap.org/data/3.0/onecall';
    }

    public function getWeatherData()
    {
        $response = Http::get($this->baseUrl, [
            'lat' => 40.7128, // Fixed coordinates for New York City
            'lon' => -74.0060,
            'exclude' => 'minutely,hourly',
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Error fetching weather data');
    }
}
