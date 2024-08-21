<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class WeatherController extends Controller
{
    public function getWeather(Request $request) {
        try {
            $info = UserController::getUserInfo($request);

            $url = "https://". env('USER_PASSWORD') ."@api.meteomatics.com/now/t_2m:C,wind_speed_10m:ms,weather_symbol_1h:idx/". $info['latitude'] .",". $info['longitude'] ."/json?model=mix";
            $response = Http::get($url);
            $weatherInfo = json_decode($response, true);

            $temp = round($weatherInfo['data'][0]['coordinates'][0]['dates'][0]['value']);
            $wind = $weatherInfo['data'][1]['coordinates'][0]['dates'][0]['value'];
            $symbol = $weatherInfo['data'][2]['coordinates'][0]['dates'][0]['value'];
            $city = $info['city_name'];

            $bg = self::setBackground(1);

            return Inertia::render('Home', [
                'city' => $city,
                'temp' => $temp,
                'wind' => $wind,
                'symbol' => 1,
            ]);
        } catch(\Exception $e) {
            return view('404', ['error' => $e->getMessage()]);
        }
    }

    private function setBackground(int $symbol) {
        return match ($symbol) {
            1 => 'clear',
            default => null
        };
    }
}
