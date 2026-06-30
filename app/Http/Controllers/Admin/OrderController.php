<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product.category']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $data['status']]);

        // Integrate admin cancellation tightly with stock integrity
        if ($oldStatus !== 'cancelled' && $data['status'] === 'cancelled') {
            $order->load('items.product');
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        } elseif ($oldStatus === 'cancelled' && $data['status'] !== 'cancelled') {
            $order->load('items.product');
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('status', 'Order status updated to ' . ucfirst($data['status']) . '.');
    }
}
