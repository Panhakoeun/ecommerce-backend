<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->carts()->with('product')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'integer|min:1']);
        $cart = Cart::updateOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $data['product_id']],
            ['quantity' => $data['quantity'] ?? 1]
        );
        return response()->json($cart, 201);
    }

    /**
     * Remove the specified cart item.
     */
    public function destroy(Request $request, Cart $cart)
    {
        $this->authorize('delete', $cart);

        /** @var \Illuminate\Database\Eloquent\Model $cart */
        $cart->delete();

        return response()->json(['message' => 'Removed']);
    }
}
