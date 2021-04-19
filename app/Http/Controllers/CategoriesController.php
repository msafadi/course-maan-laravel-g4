<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::has('posts')->get();

        return view('front.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('front.categories.show', [
            'category' => $category,
        ]);
    }
}
