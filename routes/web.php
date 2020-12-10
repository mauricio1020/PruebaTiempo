<?php

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    
    $data = null;

    if($request->has("search")) {
        $weather = new \App\Utils\Sdk\Weather();
        $data = $weather->getWeatherData($request->get("search"));

        History::create([
            "search" => $request->get("search"),
            "temp" => $data->current_observation->condition->temperature
        ]);
    }

    $histories = History::query()->orderByDesc("created_at")->get();

    return view('welcome', compact("data", "histories"));
});
