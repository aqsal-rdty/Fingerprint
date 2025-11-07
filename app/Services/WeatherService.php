<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('app.weather_api_key', env('WEATHER_API_KEY'));
        $this->baseUrl = config('app.weather_api_url', env('WEATHER_API_URL'));
    }

    public function getCurrentWeather($location)
    {
        // contoh menggunakan WeatherAPI: endpoint /current.json
        $url = "{$this->baseUrl}/current.json";
        $response = Http::get($url, [
            'key' => $this->apiKey,
            'q' => $location,
        ]);

        if ($response->ok()) {
            return $response->json();
        }
        return null;
    }
}
