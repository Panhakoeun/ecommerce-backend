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
        <div class="stat"><span>Revenue</span><strong>${{ number_format($stats['revenue'], 2) }}</strong></div>
        <a href="{{ route('admin.products.index', ['stock_status' => 'low']) }}" class="stat hoverable">
            <span>Low Stock</span>
            <strong style="color: {{ $stats['low_stock_count'] > 0 ? '#ef4444' : 'inherit' }}">{{ $stats['low_stock_count'] }}</strong>
        </a>
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
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2>Low Stock Products</h2>
                    <a href="{{ route('admin.products.index', ['stock_status' => 'low']) }}" style="font-size: 0.8rem;">View All</a>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name ?? '-' }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if($product->stock <= 0)
                                    <span class="badge" style="background: #fee2e2; color: #991b1b;">Out of Stock</span>
                                @else
                                    <span class="badge" style="background: #fef3c7; color: #92400e;">Low Stock</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="empty">No low stock products.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
@endsection
