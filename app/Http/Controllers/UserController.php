<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public static function getUserInfo() :Array {
        $url = "https://api.ip2location.io/?key=". env('LOCATION_API_KEY') ."&format=json";
        $info = json_decode(Http::get($url), true);
        return $info;
    }
}
