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
                                @if($order->status === 'pending')
                                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="button primary" title="Mark as Completed" style="padding: 8px;">
                                            <span class="icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6L9 17l-5-5"></path></svg></span>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="button danger" title="Cancel Order" style="padding: 8px;">
                                            <span class="icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"></path></svg></span>
                                        </button>
                                    </form>
                                @endif
                                <a class="button" href="{{ route('admin.orders.show', $order) }}" title="View Details">
                                    <span class="icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z"></path><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"></path></svg></span>
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
