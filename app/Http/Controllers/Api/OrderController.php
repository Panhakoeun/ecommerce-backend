<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * List the authenticated user's orders.
     */
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with(['items.product'])
            ->latest()
            ->get();

        return response()->json($orders);
    }

    /**
     * Show a single order (must belong to the user).
     */
    public function show(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json($order->load(['items.product']));
    }

    /**
     * Place an order (checkout) using the user's cart.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'address' => 'required|string|max:500',
        ]);

        $user = $request->user();
        $cartItems = $user->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 422);
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if (!$item->product || $item->product->stock < $item->quantity) {
                return response()->json([
                    'message' => "Insufficient stock for product: {$item->product?->name}",
                ], 422);
            }
        }

        $order = DB::transaction(function () use ($user, $cartItems, $data) {
            $total = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

            $order = Order::create([
                'user_id' => $user->id,
                'total'   => $total,
                'status'  => 'pending',
                'address' => $data['address'],
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);

                // Decrement stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            $user->carts()->delete();

            return $order;
        });

        return response()->json($order->load(['items.product']), 201);
    }
}
