@extends('admin.layout')

@section('title', $user->name)

@section('content')
    <div class="topline">
        <div>
            <h1>{{ $user->name }}</h1>
            <p>{{ $user->email }}</p>
        </div>
        <a class="button" href="{{ route('admin.users.index') }}">Back to Users</a>
    </div>

    <div class="grid">
        <div class="stat"><span>Role</span><strong>{{ $user->is_admin ? 'Admin' : 'Customer' }}</strong></div>
        <div class="stat"><span>Orders</span><strong>{{ $user->orders->count() }}</strong></div>
        <div class="stat"><span>Joined</span><strong style="font-size: 18px;">{{ $user->created_at?->format('M d, Y') }}</strong></div>
        <div class="stat"><span>Email Verified</span><strong>{{ $user->email_verified_at ? 'Yes' : 'No' }}</strong></div>
    </div>

    <section class="panel">
        <div class="panel-body">
            <h2>Orders</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($user->orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td><span class="badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td>{{ $order->created_at?->format('M d, Y') }}</td>
                        <td>
                            <div class="actions">
                                <a class="button" href="{{ route('admin.orders.show', $order) }}">View</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty">This user has no orders.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
