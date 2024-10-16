<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class WeatherController extends Controller
{
    public function getLocation() :Array {
        $url = "https://api.ip2location.io/?key=". env('LOCATION_API_KEY') ."&format=json";
        $info = json_decode(Http::get($url), true);
        return $info;
    }

    public function getCities(Request $request) {
        try {
            $city = $request->input('city');
            return DB::table('worldcities')
                ->select('id', DB::raw('concat(city, ";", iso2, ";", lat, ";", lng) as text'))
                ->where('city', 'like', "$city%")
                ->limit(5)
                ->get();    
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getCityWeather(array $info, String $action) {
        try {
            $url = "api.openweathermap.org/data/2.5/weather?lat=". $info['latitude'] ."&lon=". $info['longitude'] ."&appid=". env("OPENWEATHER_API_KEY") ."&units=metric";
            $response = Http::get($url);
            $weatherInfo = json_decode($response, true);

            $props = [
                'city' => $info['city_name'],
                'temp' => floor($weatherInfo['main']['temp']),
                'wind' => $weatherInfo['wind']['speed'],
                'windGusts' => isset($weatherInfo['wind']['gust']) ? $weatherInfo['wind']['gust'] : 0,
                'precip' => isset($weatherInfo['rain']) ? round($weatherInfo['rain']['1h'], 1) : 0,
                'icon' => $weatherInfo['weather'][0]['icon'],
                'desc' => $weatherInfo['weather'][0]['description'],
                'forecast' => $this->getForecast($info['latitude'], $info['longitude']),
            ];

            if ($action == 'data') {
                echo json_encode($props);
                return;
            }

            return Inertia::render('Home', $props);
        } catch(\Exception $e) {
            return Inertia::render('Error', ['error' => $e->getMessage()]);
        }
    }

    public function getWeather(Request $request) {
        $info = $request->input();
        if (!$info) {
            $info = $this->getLocation();
            return $this->getCityWeather($info, 'view');
        }
        return $this->getCityWeather($info, 'data');
    }

    public function getForecast(float $lat, float $lon) {
        try {
            $url = "api.openweathermap.org/data/2.5/forecast?lat=". $lat ."&lon=". $lon ."&appid=". env("OPENWEATHER_API_KEY") ."&units=metric";
            $response = Http::get($url);
            $info = json_decode($response, true);

            $hours = [];
            $count = 0;
            while (date("Y-m-d") == date_format(date_create($info['list'][$count]['dt_txt']), "Y-m-d")) {
                $list = $info['list'][$count];
                array_push($hours, [
                    'temp' => floor($list['main']['temp']),
                    'icon' => $list['weather'][0]['icon'],
                    'precip' => $list['pop'] * 100,
                    'time' => date_format(date_create($list['dt_txt']), "H:i"),
                ]);
                $count++;
            }

            $days = $this->getDailyForecast(array_slice($info['list'], $count));
            return [$hours, $days];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getDailyForecast(array $arr) {
        $res = [];
        
        $date = "";
        for ($i = 0; $i < count($arr); $i++) {
            $item_date = date_format(date_create($arr[$i]['dt_txt']), "Y-m-d");
            if ($date != $item_date) {
                array_push($res, $this->getItemWithMaxTemp(array_slice($arr, $i, 8)));
                $date = $item_date;
            }
        }

        return $res;
    }

    private function getItemWithMaxTemp($arr) {
        $temp = 0;
        $precip = 0;
        $icon_arr = [];

        foreach ($arr as $item) {
            $icon = $item['weather'][0]['icon'];
            $icon_arr[$icon] = isset($icon_arr[$icon]) ? $icon_arr[$icon] + 1 : 1;

            if ($item['main']['temp'] > $temp) $temp = $item['main']['temp'];
            $precip += $item['pop'];
        }

        $icon = "";
        $icon_count = 0;
        foreach ($icon_arr as $key => $value) {
            if ($value > $icon_count) {
                $icon = $key;
                $icon_count = $value;
            }
        }

        $final_precip = round($precip / 8 * 100);

        return [
            'time' => date_format(date_create($arr[0]['dt_txt']), "D"),
            'temp' => floor($temp),
            'icon' => $icon,
            'precip' => $final_precip
        ];
    }
}
