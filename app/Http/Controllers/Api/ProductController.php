<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $query = Product::with('category');
        if($request->category_id) $query->where('category_id', $request->category_id);
        if($request->search) $query->where('name', 'like', "%{$request->search}%");
        return response()->json($query->paginate(12));
    }
    public function show(Product $product) {
    return response()->json($product->load(['category', 'reviews.user']));
}
}
