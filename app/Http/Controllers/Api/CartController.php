<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->carts()->with('product.category')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
            'size' => 'nullable|string|in:S,M,L',
        ]);
        
        $size = $data['size'] ?? null;
        
        $cart = Cart::where('user_id', $request->user()->id)
                    ->where('product_id', $data['product_id'])
                    ->where('size', $size)
                    ->first();
                    
        if ($cart) {
            $cart->update(['quantity' => $cart->quantity + ($data['quantity'] ?? 1)]);
        } else {
            $cart = Cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $data['product_id'],
                'size' => $size,
                'quantity' => $data['quantity'] ?? 1
            ]);
        }
        
        return response()->json($cart->load('product.category'), 201);
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
