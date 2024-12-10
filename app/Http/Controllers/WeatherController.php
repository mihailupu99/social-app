<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;


class WeatherController extends Controller
{
    // protected $weatherService;
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index()
    {
        $weatherData = $this->weatherService->getWeatherData();

        return view('weather.card', ['weather' => $weatherData]);
    }
}
