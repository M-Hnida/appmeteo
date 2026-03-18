<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->input('city', 'Marseille');

        try {
            // 1. Obtenir les coordonnées de la ville en utilisant l'API de géocodage Open-Meteo
            $geoResponse = Http::timeout(5)->get('https://geocoding-api.open-meteo.com/v1/search', [
                'name' => $city,
                'count' => 1,
                'language' => 'fr',
                'format' => 'json'
            ]);

            if ($geoResponse->failed() || empty($geoResponse->json()['results'])) {
                throw new \Exception("Impossible de trouver la ville : {$city}. Veuillez vérifier l'orthographe.");
            }

            $location = $geoResponse->json()['results'][0];
            $latitude = $location['latitude'];
            $longitude = $location['longitude'];
            $resolvedCity = $location['name'];

            // 2. Obtenir la météo actuelle avec le fuseau horaire local
            $weatherResponse = Http::timeout(5)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'current_weather' => true,
                'timezone' => 'auto'
            ]);

            if ($weatherResponse->failed()) {
                throw new \Exception('Échec de la récupération des données météorologiques.');
            }

            $weatherData = $weatherResponse->json();

            return view('weather', [
                'weather' => $weatherData['current_weather'] ?? null,
                'timezone' => $weatherData['timezone'] ?? 'UTC',
                'city' => $resolvedCity,
                'error' => null
            ]);
            
        } catch (\Exception $e) {
            return view('weather', [
                'weather' => null,
                'timezone' => 'UTC',
                'city' => $city,
                'error' => $e->getMessage()
            ]);
        }
    }
}
