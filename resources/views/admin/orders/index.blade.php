@extends('admin.layout')

@section('title', 'Orders')

@section('content')
    <div class="topline">
        <div>
            <h1>Orders</h1>
            <p>View customer orders and totals.</p>
        </div>
    </div>

    <section class="panel">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user?->name ?? 'Deleted user' }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td><span class="badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td>{{ $order->created_at?->format('M d, Y') }}</td>
                        <td>
                            <div class="actions">
                                <a class="button" href="{{ route('admin.orders.show', $order) }}">
                                    <span class="icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z"></path><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"></path></svg></span>
                                    <span>View</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $orders->links() }}</div>
    </section>
@endsection
