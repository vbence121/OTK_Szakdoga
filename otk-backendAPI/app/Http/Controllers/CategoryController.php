<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HobbyCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::all();
        $hobbyCategories = HobbyCategory::all();

        return response([
            'categories' => $categories,
            'hobbyCategories' => $hobbyCategories,
        ]);
    }
}
