<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * List all categories (public).
     */
    public function index()
    {
        return response()->json(Category::orderBy('name')->get());
    }
}
