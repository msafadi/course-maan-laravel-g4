<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class OpenWeatherMap
{
    
    protected $apiKey;

    protected $baseUrl = 'https://api.openweathermap.org/data/2.5/';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function currentWeather($city)
    {
        $response = Http::baseUrl($this->baseUrl)
            ->get('weather', [
                'q' => $city,
                'units' => config('services.openweathermap.units'),
                'lang' => App::currentLocale(),
                'appid' => $this->apiKey
            ]);

        return $response->json();
    }
}