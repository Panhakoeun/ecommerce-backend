@extends('admin.layout')

@section('title', 'Users')

@section('content')
    <div class="topline">
        <div>
            <h1>Users</h1>
            <p>View registered users and their order counts.</p>
        </div>
    </div>

    <section class="panel">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Orders</th>
                    <th>Joined</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge">{{ $user->is_admin ? 'Admin' : 'Customer' }}</span></td>
                        <td>{{ $user->orders_count }}</td>
                        <td>{{ $user->created_at?->format('M d, Y') }}</td>
                        <td>
                            <div class="actions">
                                <a class="button" href="{{ route('admin.users.show', $user) }}">
                                    <span class="icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z"></path><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"></path></svg></span>
                                    <span>View</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty">No users yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $users->links() }}</div>
    </section>
@endsection
