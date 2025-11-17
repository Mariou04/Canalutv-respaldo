<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather()
    {
        $apiKey = env('OPENWEATHER_KEY');
        $cities = ['Bucaramanga'];
        $weatherData = [];

        foreach ($cities as $city) {
            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city . ',CO',
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'es'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $weatherData[] = [
                    'city' => $city,
                    'temp' => round($data['main']['temp']),
                    'desc' => ucfirst($data['weather'][0]['description']),
                    'icon' => $data['weather'][0]['icon']
                ];
            }
        }

        return response()->json($weatherData);
    }
}
