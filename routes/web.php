<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
dd(storage_path('app/countries.json'));

});
Route::get('/get-states/{id}', [StateController::class, 'getStates']);

Route::resource('countries', CountryController::class);
Route::resource('states', StateController::class);
Route::resource('cities', CityController::class);
