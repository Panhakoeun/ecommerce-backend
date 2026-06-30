<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Get the user's wishlist.
     */
    public function index(Request $request)
    {
        return response()->json(
            $request->user()->wishlists()->with('product.category')->get()
        );
    }

    /**
     * Add a product to the wishlist (idempotent).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::firstOrCreate([
            'user_id'    => $request->user()->id,
            'product_id' => $data['product_id'],
        ]);

        return response()->json($wishlist->load('product.category'), 201);
    }

    /**
     * Remove a product from the wishlist.
     */
    public function destroy(Request $request, Wishlist $wishlist)
    {
        if ($wishlist->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $wishlist->delete();

        return response()->json(['message' => 'Removed from wishlist']);
    }
}
