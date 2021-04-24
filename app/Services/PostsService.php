<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PostsService
{
    public function create($data)
    {
        $response = Http::baseUrl('http://localhost:8000/')
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->attach('image', Storage::disk('public')->get('aMpUq5qMjcYBPIfOizCws7qux7TFw1kB3JRKFYxb.jpg'))
            ->post('en/admin/posts', $data);

        dd($response);
    }
}