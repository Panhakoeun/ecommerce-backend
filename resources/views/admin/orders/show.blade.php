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

    <section class="panel" style="margin-bottom: 18px;">
        <div class="panel-body">
            <h2>Update Order Status</h2>
            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                @csrf
                @method('PATCH')
                <select name="status" style="min-width:180px;">
                    @foreach (['pending', 'processing', 'completed', 'cancelled'] as $s)
                        <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button class="primary" type="submit">Update Status</button>
            </form>
            @if (session('status'))
                <p style="color:var(--green,#22c55e);margin-top:8px;">{{ session('status') }}</p>
            @endif
        </div>
    </section>

    <section class="panel">
        <div class="panel-body">
            <h2>Items</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($order->items as $item)
                    <tr>
                        <td>
                            @if ($item->product?->image_url)
                                <img class="thumb" src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                            @else
                                <div class="thumb thumb-empty">No img</div>
                            @endif
                        </td>
                        <td><strong>{{ $item->product?->name ?? 'Deleted product' }}</strong></td>
                        <td>{{ $item->size ? 'Size ' . $item->size : '—' }}</td>
                        <td>{{ $item->product?->category?->name ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty">No items in this order.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
