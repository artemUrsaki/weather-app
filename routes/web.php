<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/{url?}', [WeatherController::class, 'getWeather'])
    ->where('url', 'getCityWeather');

Route::get('/getcities', [WeatherController::class, 'getCities']);