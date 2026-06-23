@extends('admin.layout')

@section('title', 'Categories')

@section('content')
<style>
    .actions { justify-content: center !important; align-items: center; }
    th:last-child, td:last-child { text-align: center !important; }
    .actions form { display: flex; margin: 0; }
</style>
    <div class="topline">
        <div>
            <h1>Categories</h1>
            <p>Create and manage product categories.</p>
        </div>
        <a class="button primary" href="{{ route('admin.categories.create') }}">
            <span class="icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg></span>
            <span>New Category</span>
        </a>
    </div>

    <section class="panel">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Products</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <div class="actions">
                                <a class="button" href="{{ route('admin.categories.edit', $category) }}">
                                    <span class="icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 20h4l11-11-4-4L4 16v4Z"></path><path d="M13 7l4 4"></path></svg></span>
                                    <span>Edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="danger" type="submit" onclick="return confirm('Delete this category? Products inside it will also be deleted.')">
                                        <span class="icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M6 7l1 13h10l1-13"></path><path d="M9 7V4h6v3"></path></svg></span>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $categories->links() }}</div>
    </section>
@endsection
