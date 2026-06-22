@extends('admin.layout')

@section('title', 'Order #'.$order->id)

@section('content')
    <div class="topline">
        <div>
            <h1>Order #{{ $order->id }}</h1>
            <p>Placed {{ $order->created_at?->format('M d, Y h:i A') }}.</p>
        </div>
        <a class="button" href="{{ route('admin.orders.index') }}">Back to Orders</a>
    </div>

    <div class="grid">
        <div class="stat"><span>Customer</span><strong>{{ $order->user?->name ?? 'Deleted user' }}</strong></div>
        <div class="stat"><span>Email</span><strong style="font-size: 18px;">{{ $order->user?->email ?? '-' }}</strong></div>
        <div class="stat"><span>Total</span><strong>${{ number_format($order->total, 2) }}</strong></div>
        <div class="stat"><span>Status</span><strong><span class="badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></strong></div>
    </div>

    <section class="panel" style="margin-bottom: 18px;">
        <div class="panel-body">
            <h2>Shipping Address</h2>
            <p>{{ $order->address ?: 'No address saved.' }}</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-body">
            <h2>Items</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($order->items as $item)
                    <tr>
                        <td>{{ $item->product?->name ?? 'Deleted product' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty">No items in this order.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
