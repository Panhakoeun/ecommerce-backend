@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="topline">
        <div>
            <h1>Dashboard</h1>
            <p>Welcome, {{ auth()->user()->name }}.</p>
        </div>
    </div>

    <div class="grid">
        <div class="stat"><span>Categories</span><strong>{{ $stats['categories'] }}</strong></div>
        <div class="stat"><span>Products</span><strong>{{ $stats['products'] }}</strong></div>
        <div class="stat"><span>Orders</span><strong>{{ $stats['orders'] }}</strong></div>
        <div class="stat"><span>Users</span><strong>{{ $stats['users'] }}</strong></div>
        <div class="stat"><span>Completed Revenue</span><strong>${{ number_format($stats['revenue'], 2) }}</strong></div>
        <div class="stat"><span>Pending Orders</span><strong>{{ $stats['pending_orders'] }}</strong></div>
    </div>

    <div class="split">
        <section class="panel">
            <div class="panel-body">
                <h2>Recent Orders</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}">#{{ $order->id }}</a></td>
                            <td>{{ $order->user?->name ?? 'Deleted user' }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td><span class="badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="empty">No orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <section class="panel">
            <div class="panel-body">
                <h2>Low Stock Products</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name ?? '-' }}</td>
                            <td>{{ $product->stock }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="empty">No low stock products.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
@endsection
