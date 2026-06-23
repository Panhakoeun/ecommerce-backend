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
        <div class="stat"><span>Pending Revenue</span><strong>${{ number_format($stats['pending_revenue'], 2) }}</strong></div>
        <div class="stat"><span>Total Potential</span><strong>${{ number_format($stats['total_potential_revenue'], 2) }}</strong></div>
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}">#{{ $order->id }}</a></td>
                            <td>{{ $order->user?->name ?? 'Deleted user' }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td><span class="badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td>
                                <div class="actions">
                                    @if($order->status === 'pending')
                                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="button primary" title="Mark as Completed" style="padding: 4px 8px; min-height: 32px;">
                                                <span class="icon" style="width: 14px; height: 14px;"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6L9 17l-5-5"></path></svg></span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="button danger" title="Cancel Order" style="padding: 4px 8px; min-height: 32px;">
                                                <span class="icon" style="width: 14px; height: 14px;"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"></path></svg></span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty">No orders yet.</td></tr>
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
