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

            $url = "https://". env('USER_PASSWORD') ."@api.meteomatics.com/now/t_2m:C/". $info['latitude'] .",". $info['longitude'] ."/json?model=mix";
            $response = Http::get($url);
            $weatherInfo = json_decode($response, true);

            $temp = $weatherInfo['data'][0]['coordinates'][0]['dates'][0]['value'];

            return Inertia::render('Home', ['temp' => $temp]);
        } catch(\Exception $e) {
            return view('404', ['error' => $e->getMessage()]);
        }
    }
}
