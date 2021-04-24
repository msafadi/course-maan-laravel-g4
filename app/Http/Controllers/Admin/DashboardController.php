<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OpenWeatherMap;
use App\Services\PostsService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $postService = new PostsService();
        $response = $postService->create([
            'title' => 'Test post',
            'category_id' => 60,
            'content' => 'Content',
            'tag' => [1, 2, 3],
        ]);
        dd($response);


        $owm = new OpenWeatherMap(config('services.openweathermap.key'));
        $response = $owm->currentWeather('Gaza');

        return view('admin.dashboard', [
            'weather' => $response['weather'][0]['description'],
            'temp' => $response['main']['temp'],
        ]);
    }
}
