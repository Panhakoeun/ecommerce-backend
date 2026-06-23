<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function update(Order $order)
    {
        $validated = request()->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $order->update($validated);

        return back()->with('status', 'Order status updated successfully.');
    }
}
